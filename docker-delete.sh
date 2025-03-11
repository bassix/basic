#!/bin/bash

# Stop all containers
docker stop $(docker ps -a -q)

# Delete all images
docker rmi -f $(docker images -q)

# Delete all networks and volumes
docker system prune --all --force --volumes
