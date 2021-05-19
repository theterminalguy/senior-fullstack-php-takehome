FROM  php:7.4-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip 

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd soap xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 

WORKDIR /app 

COPY . /app 

RUN composer install
