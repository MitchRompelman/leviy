BASIC SETUP

1. Install composer
2. sudo apt install git
3. sudo apt install openssl php-common php-curl php-json php-mbstring php-mysql php-xml php-zip
4. sudo composer create-project --prefer-dist laravel/laravel leviy

VIRTUAL HOST

1. //etc/apache2/sites-available
2. create file leviy.localhost.conf
3. Add content to leviy.localhost.conf:

<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/leviy/public
        ServerName leviy.localhost
        ServerAlias www.leviy.localhost
        
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

