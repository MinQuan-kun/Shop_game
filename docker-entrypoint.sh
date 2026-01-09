#!/bin/bash
set -e

echo "🚀 Starting deployment tasks for MongoDB Project..."

# Clear cache Laravel
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Cache cleared. Starting Apache..."

# Start Apache
exec apache2-foreground