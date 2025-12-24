#!/bin/bash
set -e

# Create .env file from environment variables
# We know they exist because migrations work. We use printenv to be sure.
echo "Generating .env from Railway environment..."
# Define a list of prefixes we want to keep
KEEP_PREFIXES="APP_|DB_|REDIS_|MAIL_|LOG_|SESSION_|QUEUE_|FILESYSTEM_|VITE_|PORT|_PORT|FEDAPAY_"

# Clear existing .env and write variables
true > /var/www/html/.env
printenv | while read -r line; do
    if echo "$line" | grep -qE "^($KEEP_PREFIXES)"; then
        echo "$line" >> /var/www/html/.env
    fi
done

chown www-data:www-data /var/www/html/.env
chmod 644 /var/www/html/.env

echo "DEBUG: Count of variables in generated .env: $(wc -l < /var/www/html/.env)"

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
