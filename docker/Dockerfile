FROM php:8.1-apache

# Arguments defined in docker-compose.yml
ARG user
ARG uid

RUN apt-get update \
    && apt-get install -y git unzip zip git npm exiftool \
    && apt-get install -y vim \
    && a2enmod ssl \
    && apt-get install -y cron

RUN npm install -g pm2

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_mysql bcmath zip intl opcache exif mbstring

# Enable apache rewrite
RUN rm /etc/apache2/sites-available/000-default.conf
COPY /docker/sites-available/000-default.conf /etc/apache2/sites-available/
RUN a2enmod rewrite

# Custom php configs
COPY /docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set our application folder as an environment variable
ENV APP_HOME /var/www/html

# Copy source files
COPY . $APP_HOME

RUN cd $APP_HOME && composer install --no-interaction && npm i && npm run prod

RUN chown -R $user:www-data $APP_HOME/storage
RUN chown -R $user:www-data $APP_HOME/bootstrap/cache

RUN cd $APP_HOME && php artisan view:clear

USER $user
