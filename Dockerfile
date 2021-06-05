FROM php:7.2-cli

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    git

RUN docker-php-source extract \
    # do important things \
    && docker-php-source delete \
    && docker-php-ext-install zip

RUN cd /tmp && curl -o /tmp/libsodium-1.0.18.tar.gz https://download.libsodium.org/libsodium/releases/libsodium-1.0.18.tar.gz && \
    tar -xvf libsodium-1.0.18.tar.gz && \
    cd libsodium-1.0.18 && \
    ./configure && \
    make && make check && \
    make install

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer
