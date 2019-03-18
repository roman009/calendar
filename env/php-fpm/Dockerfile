FROM php:fpm-alpine

RUN apk upgrade --update && apk add \
      autoconf file g++ gcc make libstdc++ libgcc \
      coreutils \
      freetype-dev \
      libjpeg-turbo-dev \
      libltdl \
      libmcrypt-dev \
      libpng-dev \
      imap-dev \
      openssl-dev

RUN docker-php-ext-install pdo_mysql mbstring ctype iconv imap json soap curl

CMD ["php-fpm"]

EXPOSE 9000