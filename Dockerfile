# Use Ubuntu 22.04 base image
FROM ubuntu:22.04

# Set environment variables to configure the timezone non-interactively
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Kolkata

# Install required dependencies for Unity game server and tzdata
RUN apt-get update && apt-get install -y \
    tzdata \
    libc6 \
    libstdc++6 \
    libsecret-1-0 \
    libgcc-s1 \
    libpthread-stubs0-dev \
    curl \
    && rm -rf /var/lib/apt/lists/* \
    # Set the timezone to IST automatically
    && ln -fs /usr/share/zoneinfo/Asia/Kolkata /etc/localtime \
    && dpkg-reconfigure --frontend noninteractive tzdata

# Set working directory inside the container
WORKDIR /app

# Copy the game server files from the LudoServer directory into the container
COPY LudoServer/ .

# Ensure the server binary is executable
RUN chmod +x server.x86_64 \
    # Set proper permissions for the plugins and server data
    && chmod -R 5 /app/server_Data/Plugins

# Expose the port used by the game server
EXPOSE 7770

# Command to run the game server
CMD ["./server.x86_64"]