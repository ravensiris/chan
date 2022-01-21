#!/usr/bin/env bash

docker-compose --env-file docker.env run backend php artisan migrate:fresh --seed
docker-compose --env-file docker.env up -d
