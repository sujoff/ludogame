#!/bin/bash

# Configuration variables
DOCKER_IMAGE="ludo-server-image"
IMAGE_TAG=$(date +%Y%m%d%H%M%S) # Use a timestamp as the image tag
BLUE_CONTAINER="ludo-server-blue"
GREEN_CONTAINER="ludo-server-green"
BLUE_PORT="7771"
GREEN_PORT="7772"
PUBLIC_PORT="7770"

# Ensure the script is run from the current user's home directory
cd ~ || { echo "Failed to change to home directory"; exit 1; }

# Step 1: Build the new Docker image
echo "Building new Docker image: $DOCKER_IMAGE:$IMAGE_TAG"
docker build -t $DOCKER_IMAGE:$IMAGE_TAG . || { echo "Docker build failed"; exit 1; }

# Step 2: Determine which container is currently active (blue or green)
if docker ps --filter "name=$BLUE_CONTAINER" --format '{{.Names}}' | grep -q $BLUE_CONTAINER; then
    ACTIVE_CONTAINER=$BLUE_CONTAINER
    NEW_CONTAINER=$GREEN_CONTAINER
    NEW_PORT=$GREEN_PORT
    OLD_PORT=$BLUE_PORT
else
    ACTIVE_CONTAINER=$GREEN_CONTAINER
    NEW_CONTAINER=$BLUE_CONTAINER
    NEW_PORT=$BLUE_PORT
    OLD_PORT=$PUBLIC_PORT
fi

echo "Active container: $ACTIVE_CONTAINER (port $OLD_PORT)"
echo "Deploying to new container: $NEW_CONTAINER (port $NEW_PORT)"

# Step 3: Deploy the new container on a temporary port
echo "Stopping and removing the new container (if it exists)..."
docker stop $NEW_CONTAINER 2>/dev/null || true
docker rm $NEW_CONTAINER 2>/dev/null || true

echo "Starting the new container: $NEW_CONTAINER on temporary port $NEW_PORT"
docker run -d --name $NEW_CONTAINER -p $NEW_PORT:7770/udp -p $NEW_PORT:7770/tcp $DOCKER_IMAGE:$IMAGE_TAG || { echo "Failed to start new container"; exit 1; }

# Step 4: Test the new container
echo "Testing the new container on port $NEW_PORT..."
sleep 10 # Give the container more time to start
if ! nc -u -z localhost $NEW_PORT; then
    echo "New container failed to start properly (port $NEW_PORT not open for UDP). Rolling back..."
    docker stop $NEW_CONTAINER
    docker rm $NEW_CONTAINER
    exit 1
fi
echo "New container is running and port $NEW_PORT is open for UDP"

# Step 5: Switch traffic by remapping the public port
echo "Stopping the old container to free up port $PUBLIC_PORT..."
docker stop $ACTIVE_CONTAINER 2>/dev/null || true
docker rm $ACTIVE_CONTAINER 2>/dev/null || true

# Wait for the port to be released
echo "Waiting for port $PUBLIC_PORT to be released..."
RETRY_COUNT=0
MAX_RETRIES=30
while nc -u -z localhost $PUBLIC_PORT 2>/dev/null; do
    if [ $RETRY_COUNT -ge $MAX_RETRIES ]; then
        echo "Port $PUBLIC_PORT is still in use after $MAX_RETRIES seconds. Exiting..."
        docker stop $NEW_CONTAINER
        docker rm $NEW_CONTAINER
        exit 1
    fi
    echo "Port $PUBLIC_PORT still in use, waiting... ($RETRY_COUNT/$MAX_RETRIES)"
    sleep 1
    RETRY_COUNT=$((RETRY_COUNT + 1))
done
echo "Port $PUBLIC_PORT is now free"

echo "Starting the new container on public port $PUBLIC_PORT..."
docker stop $NEW_CONTAINER 2>/dev/null || true
docker rm $NEW_CONTAINER 2>/dev/null || true
docker run -d --name $NEW_CONTAINER -p $PUBLIC_PORT:7770/udp -p $PUBLIC_PORT:7770/tcp $DOCKER_IMAGE:$IMAGE_TAG || { echo "Failed to start new container on public port"; exit 1; }

# Step 6: Test the new container on the public port
echo "Testing the new container on public port $PUBLIC_PORT..."
sleep 10 # Give the container more time to start
if ! nc -u -z localhost $PUBLIC_PORT; then
    echo "New container failed to start properly on public port $PUBLIC_PORT for UDP. Exiting..."
    docker stop $NEW_CONTAINER
    docker rm $NEW_CONTAINER
    exit 1
fi
echo "New container is running and port $PUBLIC_PORT is open for UDP"

# Step 7: Clean up old Docker images
echo "Cleaning up old Docker images..."

# Remove all ludo-server-image images except the one we just built
echo "Removing old $DOCKER_IMAGE images (keeping $DOCKER_IMAGE:$IMAGE_TAG)..."
# Get the image ID of the current image
CURRENT_IMAGE_ID=$(docker images -q $DOCKER_IMAGE:$IMAGE_TAG | head -n 1)

# List all ludo-server-image images and remove those that don't match the current image ID
docker images --filter=reference="$DOCKER_IMAGE" --format "{{.ID}} {{.Tag}}" | while read -r IMAGE_ID TAG; do
    if [ "$IMAGE_ID" != "$CURRENT_IMAGE_ID" ]; then
        echo "Removing $DOCKER_IMAGE:$TAG (ID: $IMAGE_ID)..."
        docker rmi $IMAGE_ID 2>/dev/null || true
    fi
done

# Optionally, remove dangling images
echo "Removing dangling images..."
docker image prune -f

echo "Deployment completed successfully! New container ($NEW_CONTAINER) is now active on port $PUBLIC_PORT"