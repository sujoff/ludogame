#!/bin/bash

# Configuration variables
DOCKER_IMAGE="ludo-server-image"
IMAGE_TAG=$(date +%Y%m%d%H%M%S) # Use a timestamp as the image tag
BLUE_CONTAINER="ludo-server-blue"
GREEN_CONTAINER="ludo-server-green"
BLUE_PORT="7771"
GREEN_PORT="7772"
NGINX_CONFIG="/etc/nginx/sites-available/ludo-server"

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
    OLD_PORT=$GREEN_PORT
fi

echo "Active container: $ACTIVE_CONTAINER (port $OLD_PORT)"
echo "Deploying to new container: $NEW_CONTAINER (port $NEW_PORT)"

# Step 3: Deploy the new container
echo "Stopping and removing the new container (if it exists)..."
docker stop $NEW_CONTAINER 2>/dev/null || true
docker rm $NEW_CONTAINER 2>/dev/null || true

echo "Starting the new container: $NEW_CONTAINER"
docker run -d --name $NEW_CONTAINER -p $NEW_PORT:7770 $DOCKER_IMAGE:$IMAGE_TAG || { echo "Failed to start new container"; exit 1; }

# Step 4: Test the new container
echo "Testing the new container on port $NEW_PORT..."
sleep 5 # Give the container a few seconds to start
if ! curl --fail http://localhost:$NEW_PORT; then
    echo "New container failed to start properly. Rolling back..."
    docker stop $NEW_CONTAINER
    docker rm $NEW_CONTAINER
    exit 1
fi
echo "New container is running and accessible"

# Step 5: Switch traffic to the new container by updating Nginx
echo "Updating Nginx to route traffic to the new container (port $NEW_PORT)..."
sudo sed -i "s/server 127.0.0.1:$OLD_PORT/server 127.0.0.1:$NEW_PORT/" $NGINX_CONFIG || { echo "Failed to update Nginx config"; exit 1; }
if ! sudo nginx -t; then
    echo "Nginx configuration test failed. Rolling back..."
    sudo sed -i "s/server 127.0.0.1:$NEW_PORT/server 127.0.0.1:$OLD_PORT/" $NGINX_CONFIG
    docker stop $NEW_CONTAINER
    docker rm $NEW_CONTAINER
    exit 1
fi
sudo systemctl reload nginx || { echo "Failed to reload Nginx"; exit 1; }
echo "Nginx updated to route traffic to the new container"

# Step 6: Stop and remove the old container
echo "Stopping and removing the old container: $ACTIVE_CONTAINER..."
docker stop $ACTIVE_CONTAINER 2>/dev/null || true
docker rm $ACTIVE_CONTAINER 2>/dev/null || true

# Step 7: Clean up old Docker images (optional)
echo "Cleaning up old Docker images..."
docker image prune -f

echo "Deployment completed successfully! New container ($NEW_CONTAINER) is now active on port $NEW_PORT"