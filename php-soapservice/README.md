# PHP Soap Service

### Requirements

- PHP >= 7.4.3
- MySQL >= 8
- Composer >= 2.0.13 
- apt-get install php-mysql

### Setting up locally

Use [composer](https://getcomposer.org/) to install all dependencies with

```shell
composer install 
```

### Troubleshooting

If you run into issues setting this up locally, reach out to me. 

Some issues you may run into includes the following extensions missing 

- php-mxl, install with `sudo apt install php-xml`
- php-mbstring, install with `sudo apt-get install php-mbstring`
- mysql pdo extension first check with `php -m | grep pdo_mysql` if missing run `apt-get install php-mysql` to install


### Useful commands

```
# Clear composer cache 
composer clear-cache 

# Regenerate vendor/autoload
composer dump-autoload 

# Run all test  
./vendor/bin/phpunit tests --color

# Start the SOAP server. Use any port you wish
php -S localhost:12312

```