FROM php:8.1-fpm-alpine3.14
ARG USER
ARG UID

WORKDIR /var/www
RUN rm  -rf /var/www/html

RUN apk update && apk add \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd pdo pdo_mysql

RUN addgroup $USER
RUN adduser -u $UID -H -S $USER -D
RUN addgroup -S $USER $USER
RUN addgroup -S $USER wheel

#Baixa e instala o composer
#Cópia todos os arquivos do diretório atual
COPY --chown=$USER:$USER . .
COPY --from=composer:2.2.12  /usr/bin/composer /usr/bin/composer
RUN composer install

RUN chown -R $USER:$USER vendor

ADD ./docker/config/php.ini /usr/local/etc/php/php.ini

EXPOSE 9000
CMD ["php-fpm"]
