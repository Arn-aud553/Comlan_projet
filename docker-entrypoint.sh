#!/bin/bash
set -e

# Fix Apache MPM conflict at runtime (just in case)
rm -f /etc/apache2/mods-enabled/mpm_event.load
rm -f /etc/apache2/mods-enabled/mpm_event.conf
rm -f /etc/apache2/mods-enabled/mpm_worker.load
rm -f /etc/apache2/mods-enabled/mpm_worker.conf
# Ensure prefork is enabled (link manually if needed, but a2enmod should work)
# We assume prefork is already enabled by Dockerfile but we double check
if [ ! -f /etc/apache2/mods-enabled/mpm_prefork.load ]; then
    ln -s /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load
    ln -s /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
fi

echo "Running migrations..."
php artisan migrate --force

echo "Starting Apache..."
apache2-foreground
