FROM php:7.2-apache
ENV APACHE_DOCUMENT_ROOT /repo/web

RUN set -x \
  && apt-get update \
  && apt-get install -y --no-install-recommends \
    unzip git curl libldap2-dev \
    libssl-dev libpcre3 libpcre3-dev zlib1g-dev libmagickwand-dev sendmail libmemcached-dev

RUN set -x \
  && docker-php-ext-install -j$(nproc) pdo_mysql mysqli mbstring gd zip ldap \
  && pecl install imagick-3.4.3 memcached \
  && docker-php-ext-enable imagick memcached \
  && a2enmod rewrite

COPY entrypoint.sh /entrypoint.sh
COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY php.ini /usr/local/etc/php/php.ini

RUN set -x \
  && echo 'emlauncher:emlauncher' > /dbauth \
  && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
  && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
  && mkdir -p /var/www/emlauncher \
  && chmod 755 /var/www/emlauncher \
  && chown www-data:www-data /var/www/emlauncher

ENTRYPOINT /entrypoint.sh
ENV MFW_ENV docker

RUN set -x \
  && mkdir -p /usr/share/man/man1 \
  && apt-get install -y --no-install-recommends default-jre-headless \
  && curl -sL -o/bundletool.jar https://github.com/google/bundletool/releases/download/0.10.0/bundletool-all-0.10.0.jar \
  && echo -e 'EMLauncher\n\nKLab Inc.\n\nTokyo\nJP\nyes' | keytool -genkeypair -keystore /emlauncher.keystore -alias emlauncher -storepass emlauncher -keypass emlauncher -keyalg RSA -keysize 2048 -validity 36524

# Composerのインストール
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# LDAP接続
RUN echo 'TLS_REQCERT allow' >> /etc/ldap/ldap.conf
RUN echo 'SASL_NOCANON on' >> /etc/ldap/ldap.conf
