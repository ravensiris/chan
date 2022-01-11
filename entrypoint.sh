#!/usr/bin/env bash

docker-compose up -d --build
docker-compose run chan-api php artisan migrate:fresh --seed
