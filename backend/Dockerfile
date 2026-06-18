# ============================================
# Stage de base : Configuration PHP commune
# ============================================
FROM php:8.4-fpm-alpine AS base

# Installation des dépendances système nécessaires
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    icu-dev \
    oniguruma-dev

# Installation des extensions PHP requises par Symfony
RUN docker-php-ext-install \
    pdo_mysql \      
    zip \            
    intl \           
    opcache          

# Installation de Composer (gestionnaire de dépendances PHP)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# ============================================
# Stage développement
# ============================================
FROM base AS dev

# Configuration PHP adaptée au développement
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Installation de Xdebug (debugger PHP)
# Note : Installé mais désactivé par défaut pour les performances
RUN apk add --no-cache $PHPIZE_DEPS linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del $PHPIZE_DEPS linux-headers

# Désactivation de Xdebug par défaut (gain de performance x3-x10)
RUN echo "xdebug.mode=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Installation des dépendances Composer
# COPY backend/composer.* ./
# RUN composer install 

# Copie du code source
# COPY backend/ .
# RUN composer dump-autoload --optimize

EXPOSE 9000

CMD ["php-fpm"]

# ============================================
# Stage production
# ============================================
FROM base AS prod

# Configuration PHP optimisée pour la production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Configuration OPcache pour performances maximales
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini

# Installation des dépendances (sans dépendances de dev)
COPY backend/composer.* ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copie du code source
COPY backend/ .
RUN composer dump-autoload --optimize --classmap-authoritative

# Configuration des permissions pour www-data
RUN chown -R www-data:www-data var/

EXPOSE 9000

CMD ["php-fpm"]