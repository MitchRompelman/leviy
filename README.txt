BASIC SETUP

1. sudo add-apt-repository ppa:ondrej/php
2. sudo apt update
3. sudo apt install php7.3 php7.3-cli php7.3-fpm
4. sudo apt install openssl php7.3-common php7.3-curl php7.3-json php7.3-mbstring php7.3-mysql php7.3-xml php7.3-zip
5. Install composer
6. sudo apt install git
7. sudo composer create-project laravel/laravel leviy 5.8.*
8. sudo a2enmod rewrite
9. systemctl restart apache2

VIRTUAL HOST

1. //etc/apache2/sites-available
2. create file leviy.localhost.conf
3. Add content to leviy.localhost.conf:

<VirtualHost *:80>

        <Directory /var/www/leviy/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/leviy/public
        ServerName leviy.localhost
        ServerAlias www.leviy.localhost

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

4. sudo a2ensite leviy.localhost.conf
5. sudo systemctl restart apache2

SETUP LOCAL

1. composer install
2. Setup the .env file
3. php artisan key:generate
4. php artisan migrate

SETUP USER

1. php artisan tinker
2. $user = new User();
3. $user->name = 'leviy';
4. $user->email = 'leviy@leviy.nl';
5. $user->password = Hash::make('leviy');
6. $user->save();

COMMAND GENERATE CSV
1. php artisan SchemeCommand
2. login and download generated csv
