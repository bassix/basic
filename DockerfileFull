FROM php:apache
LABEL Author="Adam Ibrom" Description="A docker image to run basic application with Apache-2.4 and PHP-8.3"

# Stop dpkg-reconfigure tzdata from prompting for input
ENV DEBIAN_FRONTEND=noninteractive

# Install apache, PHP, and supplimentary programs. openssh-server, curl, and lynx-cur are for debugging the container.
RUN apt-get update && \
    apt-get -y upgrade && \
    apt-get -y install \
      apache2 \
      libapache2-mod-php \
      libapache2-mod-auth-openidc \
      php-bcmath \
      php-cli \
      php-curl \
      php-gd \
      php-intl \
      php-json \
      php-ldap \
      php-mbstring \
      php-memcached \
      php-mysql \
      php-pgsql \
      php-soap \
      php-tidy \
      php-uploadprogress \
      php-xml \
      php-xmlrpc \
      php-yaml \
      php-zip \
      php-redis \
      php-imagick \
      && \
    # Install ImageMagick CLI tools
    apt-get -y install --no-install-recommends imagemagick && \
    # Clean up apt setup files
    apt-get -y autoremove && \
    apt-get clean

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

EXPOSE 80
USER www-data

ENTRYPOINT ["apache2ctl", "-D", "FOREGROUND"]
