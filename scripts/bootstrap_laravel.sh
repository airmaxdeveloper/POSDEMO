#!/bin/bash
# Build assets, clear caches, and restart services for POSDEMO Laravel application.
# Run as root or using sudo where necessary.

set -e

APP_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$APP_ROOT"

# Build CSS/JS assets for each module
for module in Modules/*; do
  if [[ -f "$module/package.json" ]]; then
    echo "Building assets in $module"
    (cd "$module" && npm install && npm run prod)
  fi
done

# Clear and rebuild Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services if systemd is available
if command -v systemctl >/dev/null 2>&1; then
  sudo systemctl restart php-fpm || true
  sudo systemctl restart nginx || true
fi
