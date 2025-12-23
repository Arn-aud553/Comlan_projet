FROM php:8.2-apache

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    nodejs \
    npm

# Configuration PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration Apache - Racine web vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

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

# Commande de démarrage (Migrations automatique optionnelle mais recommandée sur Railway via script start.sh ou CMD)
# Ici on lance Apache en premier plan
CMD php artisan migrate --force && apache2-foreground
