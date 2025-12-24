#!/bin/bash
set -e

# Create .env file from environment variables safely
{
    echo "--- START DEPLOY LOG ---"
    echo "Timestamp: $(date)"
    
    # Filter and quote variables for .env
    # We only keep common Laravel prefixes to avoid noisy/corrupt system vars
    echo "Generating .env..."
    true > /var/www/html/.env
    # Exported vars to keep
    KEEP_REGEX='^(APP_|DB_|REDIS_|MAIL_|LOG_|SESSION_|QUEUE_|FILESYSTEM_|VITE_|PORT|_PORT|FEDAPAY_|RAILWAY_)'
    
    # Use 'env' and a loop to properly quote values
    env | grep -E "$KEEP_REGEX" | while read -r line; do
        key=$(echo "$line" | cut -d '=' -f 1)
        # Get the value safely, handle cases where '=' might be in the value
        val=$(echo "$line" | cut -d '=' -f 2-)
        # Write to .env with quotes
        echo "$key=\"$val\"" >> /var/www/html/.env
        # Log masked version
        echo "$key=********" >> /tmp/deploy.log
    done
    
    echo "--- END DEPLOY LOG ---"
} > /tmp/deploy.log

chown www-data:www-data /var/www/html/.env
chmod 644 /var/www/html/.env

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
