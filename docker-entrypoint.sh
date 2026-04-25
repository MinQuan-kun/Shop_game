#!/bin/bash
set -e

echo "🚀 Starting deployment tasks for MongoDB Project..."

# Clear all Laravel cache (DO NOT re-cache on Render deployment)
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "✅ Cache cleared. Starting Apache..."

# Start Apache
exec apache2-foreground