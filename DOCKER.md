## Docker

## Terminal commands:

## build image:
docker build -t image-name .

## list images:
docker image ls

## run image:
docker-compose up

## run image in background:
docker-compose up -d
remove image
docker image rm image-name

## explore running container:
docker exec -it container-name bash

## restart container:
docker restart container-name

## remove container:
docker rm container-name

## remove all stopped containers including "none" containers:
docker system prune