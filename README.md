# Ludo Game Server

## Overview
- **Description**: A lightweight Ludo game server built with FishNet and LiteNetLib, supporting multiplayer gameplay over UDP on port 7770.
- **Deployment**: Uses a blue-green deployment strategy with Docker for minimal downtime (~2 seconds).

## Deployment Instructions

### Prerequisites
- Docker installed on the host machine.
- UDP port 7770 open on the host firewall.

### Steps
1. **Clone the Repository**
  
   git clone <repository-url>
   cd <repository-directory>

Build and Deploy
Ensure the LudoServer directory and Dockerfile are in the current directory.
Run the deployment script:
bash

Collapse

Wrap

Copy
chmod +x Upgrade.sh
./Upgrade.sh
The script will:
Build a new Docker image (ludo-server-image:<timestamp>).
Deploy the new container on a temporary port (7771 or 7772).
Test the new container (UDP on port 7770).
Switch traffic to the new container on port 7770.
Clean up old images.
Verify Deployment
Check the running container:

docker ps
Test connectivity from another machine:
bash

Collapse

Wrap

Copy
nc -u -v <server-ip> 7770
Notes
Downtime: ~2 seconds during deployment.
Lightsail Migration: Use the $5/month plan (1 GB RAM, 1 vCPU, 40 GB SSD, Mumbai region). Ensure the Lightsail firewall allows UDP on port 7770.
text

Collapse

Wrap

Copy

---

### Explanation:
- **Format**: Written in Markdown with code blocks (```bash) for commands, making it easy to read and copy-paste.
- **Content**:
  - **Overview**: Briefly describes the project (Ludo game server, FishNet/LiteNetLib, UDP, blue-green deployment).
  - **Deployment Instructions**: Provides clear steps to deploy the server locally or on a similar environment, including prerequisites, cloning, running the script, and verifying the deployment.
  - **Notes**: Mentions the downtime, Lightsail migration details, and firewall requirements.
- **Length**: Kept short and to the point, focusing on essential information.

Let me know if you’d like to add more details or adjust the format!