#!/usr/bin/env bash

docker-compose --env-file docker.env run chan-api php artisan migrate:fresh --seed
docker-compose --env-file docker.env up -d
