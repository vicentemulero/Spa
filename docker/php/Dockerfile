FROM php:8.1-fpm-alpine

VOLUME /var/run/php

RUN apk add --no-cache 																								\
		acl 																										\
		fcgi 																										\
		file 																										\
		gettext 																									\
		git 																										\
		gnu-libiconv 																								\
																													;

RUN set -eux; 																										\
	apk add --no-cache --virtual .build-deps 																		\
		$PHPIZE_DEPS 																								\
		icu-dev 																									\
		libzip-dev 																									\
		zlib-dev 																									\
																													;

RUN docker-php-ext-configure zip 																				&&  \
	docker-php-ext-install -j$(nproc) 																				\
		intl 																										\
		zip 																										\
																													;


RUN apk add --update linux-headers																				&& \
	pecl install xdebug 																						&& \
	docker-php-ext-enable xdebug																					;

COPY docker/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY docker/php/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache --virtual .pgsql-deps postgresql-dev; \
	docker-php-ext-install -j$(nproc) pdo_pgsql; \
	apk add --no-cache --virtual .pgsql-rundeps so:libpq.so.5; #\
	#apk del .pgsql-deps not working in windows


RUN mkdir -p /srv/app/var/cache /srv/app/var/log 																&&	\
    setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX /srv/app/var												&& 	\
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX /srv/app/var													;

WORKDIR /srv/app

CMD ["php-fpm"]
