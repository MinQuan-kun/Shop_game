#!/bin/bash
set -e

echo "🚀 Starting deployment tasks..."

php artisan package:discover --ansi

# 2. Các lệnh clear cache cũ
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Ready to start Apache."

# Start Apache
exec apache2-foreground