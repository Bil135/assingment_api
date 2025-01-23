FROM php:8.3-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache(optional)
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -u $uid -ms /bin/bash -g www-data $user

WORKDIR /var/www/assingment_api
COPY . /var/www/assingment_api
RUN composer require laravel/sanctum
RUN composer require darkaonline/l5-swagger

RUN composer install
RUN php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
RUN php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"

RUN curl -o /wait-for-it.sh https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh
RUN chmod +x /wait-for-it.sh


COPY --chown=$user:www-data . /var/www

USER $user

EXPOSE 9000

CMD ["php-fpm"]
