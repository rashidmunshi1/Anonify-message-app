#!/bin/bash

# Copy environment file
cp .env.railway .env

# Start PHP server directly without migrations for now
php artisan serve --host=0.0.0.0 --port=$PORT