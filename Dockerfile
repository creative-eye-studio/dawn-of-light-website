
# CONFIGURATION DE COMPOSER
# ---------------------------------------------------------------------------------
FROM php:8.2-apache

RUN a2enmod rewrite
 
RUN apt-get update \
    && apt-get install -y libzip-dev git wget libicu-dev --no-install-recommends \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install intl pdo pdo_mysql zip
 
RUN wget https://getcomposer.org/download/2.5.1/composer.phar \
    && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer
 
COPY .docker/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY . /var/www
 
WORKDIR /var/www

# Donner les droits d'écriture au cache prod
RUN chmod -R 777 var/cache/prod
RUN chmod -R 777 var/log

RUN composer install -n

# CONFIGURATION DE NPM
# ---------------------------------------------------------------------------------

# Installation de Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Installation des dépendances npm
COPY package.json .
COPY package-lock.json .
RUN npm install

# Exécution de npm run build
RUN npm run build

CMD ["apache2-foreground"]