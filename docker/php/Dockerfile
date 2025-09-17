FROM php:fpm

# Stop dpkg-reconfigure tzdata from prompting for input
ENV DEBIAN_FRONTEND=noninteractive

# Install apache, PHP, and supplimentary programs. openssh-server, curl, and lynx-cur are for debugging the container.
RUN apt-get update && \
    apt-get -y upgrade && \
    apt-get -y install \
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
