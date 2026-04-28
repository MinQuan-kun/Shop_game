#!/bin/bash
set -e

echo "🚀 Starting deployment tasks..."

# Discover packages
php artisan package:discover --ansi

# Clear all Laravel cache (DO NOT re-cache on Render deployment)
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "✅ Ready to start Apache."

# Start Apache
exec apache2-foreground