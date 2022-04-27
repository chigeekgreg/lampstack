# LAMP Stack Docker Example
Example of a LAMP stack using docker-compose

## Demo
[![asciicast](https://asciinema.org/a/AA9zEYiHjt5QNFigKLTytrM2V.svg)](https://asciinema.org/a/AA9zEYiHjt5QNFigKLTytrM2V)

## Compose stack files
### `Dockerfile`
```Dockerfile
FROM php:7.4-apache AS base
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
VOLUME /var/www/config

FROM base AS development
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

FROM base AS production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY html /var/www/html
```
This dockerfile is a multi-stage build that has two three stages, which each build targets: `base`, `development`, and `production`. The `development` target builds and image that is lighter weight and does not include thr html files which will need to be bbind-mounted into the container as a volume. The `production` target builds a container suitable for production, with all of the html files added to the container as an immutable layer. The two targets also use different php.ini files since some options are helpful for debugging but should not be used in a production environment. The `base` stage contains layers that are commo to both targets. To build using docker cli, run `docker build --tag chigeekgreg/lampstack:development --target development.` for development, or `docker build --tag chigeekgreg/lampstack:production .` for production. When using Docker Buildkit, only the desired target stage is run and layers are cached to improve build times.

### `docker-compose.yml`
```yml
version: "2.4"
services:
  web:
    image: chigeekgreg/lampstack-web:production
    build:
      context: .
      target: production
    volumes:
      - ./config:/var/www/config
    ports:
      - "80:80"
    depends_on:
      db:
        condition: service_healthy
    restart: unless-stopped
  db:
    image: mariadb
    volumes:
      - db:/var/lib/mysql
      - ./sql:/docker-entrypoint-initdb.d
      - ./seed:/seed
    environment:
      MYSQL_RANDOM_ROOT_PASSWORD: "yes"
      MYSQL_USER: ${MYSQL_USER}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD}
      MYSQL_DATABASE: ${MYSQL_DATABASE}
    healthcheck:
      test: ["CMD", "mysqladmin", "-u$MYSQL_USER", "-p$MYSQL_PASSWORD", "ping", "--silent"]
      interval: 5s
      start_period: 10s
      timeout: 5s
      retries: 2
    restart: unless-stopped
volumes:
  db:
```
This docker-compose file defines two services (`web` and `db`) and one named volume (`db`). Note that only port 80 is exposed. The database port does not need to be exposed because the two services can communicate over the named docker bridge network which compose creates by defatult.

### `docker-compose.override.yml` for development environment
```yml
# This file overrides docker-compose.yml for a development environment.
# Delete or rename this file to switch to production environment.
services:
  web:
    image: chigeekgreg/lampstack-web:development
    build:
      target: development
    volumes:
      - ./html:/var/www/html
```
The benefit of this override file is to support fast reloading of the content in the webroot by bind-mounting the html directory instead of packing it into the image. When `docker-compose up` is run, the directives from the override file are automatically merged over the configuration from the default `docker-compose.yml` file. To prevent that from happening, rename the override file to something else, like `docker-compose.dev.yml`. Then the production environment can be brought up with `docker compose up` and the development environment with `docker-compose -f docker-compose.yml -f docker-compose.dev.yml`.

### `.env`
```env
MYSQL_USER='lampstack'
MYSQL_PASSWORD='Changeme!'
MYSQL_DATABASE='lampstack'
```
The `.env` file is loaded by docker compose by default and can be used for variable replacement. It is possible to use other env file names and/or use muktiple env files that each map to specific services, but a single `.env` file allows environment variables to be shared by multiple services, and is the most common.
