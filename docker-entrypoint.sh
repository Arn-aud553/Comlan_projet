#!/bin/bash
set -e

# Create .env file from environment variables
echo "Generating .env from Railway environment..."
# Capture everything to be 100% sure we are not missing anything
env > /var/www/html/.env
chown www-data:www-data /var/www/html/.env
chmod 644 /var/www/html/.env

echo "DEBUG: ENVIRONMENT DUMP (Masked values):"
env | grep -vE "PASS|KEY|SECRET|TOKEN|AUTH" | head -n 20
echo "DEBUG: Check for DB_CONNECTION: $(grep "DB_CONNECTION" /var/www/html/.env || echo 'NOT FOUND')"

# Fix Apache MPM conflict at runtime
rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf
rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf
a2disconf mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# Force Apache to listen on $PORT (Railway requirement)
if [ -n "$PORT" ]; then
    echo "Configuring Apache to listen on port $PORT"
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:$PORT>/g" /etc/apache2/sites-available/000-default.conf
fi

echo "Running migrations..."
php artisan migrate --force

echo "Optimizing configuration..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "Starting Apache..."
exec apache2-foreground
