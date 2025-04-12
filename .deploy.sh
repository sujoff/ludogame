#!/bin/bash

# Variables
LIGHTSAIL_IP="13.235.166.28"
SSH_KEY="/Volumes/Transcend/Aws/devkey.pem"

# Build images
echo "Building Docker images..."
docker build -t app1:latest ./app1 || { echo "Failed to build app1"; exit 1; }
docker build -t app2:latest ./app2 || { echo "Failed to build app2"; exit 1; }

# Save images
echo "Saving Docker images..."
docker save -o app1.tar app1:latest || { echo "Failed to save app1"; exit 1; }
docker save -o app2.tar app2:latest || { echo "Failed to save app2"; exit 1; }

# Transfer images and docker-compose.yml to Lightsail
echo "Transferring files to Lightsail..."
scp -i $SSH_KEY app1.tar ubuntu@$LIGHTSAIL_IP:/home/ubuntu/ || { echo "Failed to transfer app1.tar"; exit 1; }
scp -i $SSH_KEY app2.tar ubuntu@$LIGHTSAIL_IP:/home/ubuntu/ || { echo "Failed to transfer app2.tar"; exit 1; }
scp -i $SSH_KEY docker-compose.yml ubuntu@$LIGHTSAIL_IP:/home/ubuntu/ || { echo "Failed to transfer docker-compose.yml"; exit 1; }

# SSH into Lightsail and deploy
echo "Deploying containers on Lightsail..."
ssh -i $SSH_KEY ubuntu@$LIGHTSAIL_IP << 'EOF'
    # Load images
    docker load -i /home/ubuntu/app1.tar || { echo "Failed to load app1"; exit 1; }
    docker load -i /home/ubuntu/app2.tar || { echo "Failed to load app2"; exit 1; }

    # Stop and remove existing containers (if any)
    docker-compose -f /home/ubuntu/docker-compose.yml down

    # Start new containers
    docker-compose -f /home/ubuntu/docker-compose.yml up -d || { echo "Failed to start containers"; exit 1; }

    # Clean up
    rm /home/ubuntu/app1.tar /home/ubuntu/app2.tar /home/ubuntu/docker-compose.yml
    docker rmi $(docker images -f dangling=true -q)
    echo "Deployment completed on Lightsail!"
EOF

echo "Local script completed!"