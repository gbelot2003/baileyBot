FROM php:8.2-apache-bullseye

RUN apt-get update && apt-get install -y \
git \
tree \
vim \
wget \
libmagickwand-6.q16-dev \
libfreetype6-dev \
libjpeg62-turbo-dev \
libwebp-dev \
libpng-dev \
libpq-dev \
libzip-dev \
zip \
&& docker-php-ext-install zip \
&& ln -s /usr/lib/x86_64-linux-gnu/ImageMagick-6.8.9/bin-Q16/MagickWand-config /usr/bin \
&& pecl install imagick \
&& echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini \
&& rm -rf /var/lib/apt/lists/* 

#RUN printf "\n" | pecl install imagick-beta
#RUN docker-php-ext-enable imagick

# configure, install and enable all php packages
RUN set -eux; \
	docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp; \
	docker-php-ext-configure intl; \
	docker-php-ext-configure mysqli --with-mysqli=mysqlnd; \
	docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd; \
	docker-php-ext-configure zip; \
	docker-php-ext-install -j "$(nproc)" \
		gd \
		intl \
		mysqli \
		opcache \
		pdo_mysql \
		zip

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

WORKDIR /var/www

RUN mkdir ./.composer

RUN chmod -R 777 .composer

WORKDIR /var/www/html

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# Copy existing application directory permissions
COPY --chown=www-data:www-data ./ /var/www

COPY --chown=www-data:www-data ./ /var/www/html

# Change current user to www
USER www-data