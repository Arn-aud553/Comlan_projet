FROM php:8.2-apache

# Installation des dépendances système (Sans recommendations pour éviter les conflits Apache)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    nodejs \
    npm \
    dos2unix \
    && rm -rf /var/lib/apt/lists/*

# Configuration PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration Apache - Racine web vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Fix MPM Conflict: Forcefully remove conflicting configurations installed by apt
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2dismod mpm_event || true \
    && a2dismod mpm_worker || true \
    && a2enmod mpm_prefork

# Configuration PHP Custom (Memory limit, timeouts)
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini
RUN echo "upload_max_filesize=50M" > /usr/local/etc/php/conf.d/uploads.ini
RUN echo "post_max_size=50M" >> /usr/local/etc/php/conf.d/uploads.ini

# Dossier de travail
WORKDIR /var/www/html

# Copie des fichiers Composer
COPY composer.json composer.lock ./

# Installation des dépendances PHP (Sans scripts pour l'instant pour éviter les erreurs si le code n'est pas là)
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# Copie du reste du projet
COPY . .

# Exécution des scripts post-install maintenant que tout est là
RUN composer run-script post-autoload-dump

# Installation des dépendances JS et Build
RUN npm install
RUN npm run build

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port
EXPOSE 80

# Script de démarrage robuste
COPY docker-entrypoint.sh /usr/local/bin/
RUN dos2unix /usr/local/bin/docker-entrypoint.sh && chmod +x /usr/local/bin/docker-entrypoint.sh

CMD ["/usr/local/bin/docker-entrypoint.sh"]
