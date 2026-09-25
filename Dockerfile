# ============================================
# Stage 1: Build Vite / Tailwind assets
# ============================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# ============================================
# Stage 2: Laravel PHP
# ============================================
FROM php:8.2-fpm

WORKDIR /var/www/html


# ============================================
# System dependencies
# ============================================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    nginx \
    supervisor \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        bcmath \
        exif \
        pcntl \
        gd \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# ============================================
# Composer
# ============================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ============================================
# Copy Laravel project
# ============================================
COPY . .


# ============================================
# Install Laravel dependencies
# ============================================
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# ============================================
# Copy Vite production build
# ============================================
COPY --from=frontend /app/public/build ./public/build


# ============================================
# Laravel directories
# ============================================
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache


# ============================================
# Permissions
# ============================================
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache \
    public


# ============================================
# Nginx configuration
# ============================================
COPY docker/nginx.conf /etc/nginx/sites-available/default


# ============================================
# Supervisor configuration
# ============================================
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf


# ============================================
# Render port
# ============================================
EXPOSE 10000


# ============================================
# Start PHP-FPM + Nginx
# ============================================
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]