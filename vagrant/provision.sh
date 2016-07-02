#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PASSWORD="12345678"

echo update / upgrade
sudo apt-get update
sudo apt-get -y upgrade

echo  "installing php 5.5"
sudo apt-get install -y php5 nginx php5-fpm php5-cli > /dev/null
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/fpm/php.ini

echo  "preparing swap"
sudo dd if=/dev/zero of=/swapfile bs=1024 count=512k
mkswap /swapfile
swapon /swapfile

echo "installing nginx"
VHOST=$(cat <<EOF
server {
    server_name localhost;
    root /var/www/address/app;

    location / {
        try_files \$uri /index.php\$is_args$args;
    }

    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT \$realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/app.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }

    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
      return 404;
    }

    error_log /var/log/nginx/address_error.log;
    access_log /var/log/nginx/address_access.log;
}
EOF
)

echo "${VHOST}" > /etc/nginx/sites-available/address.local
sudo ln -s /etc/nginx/sites-available/address.local /etc/nginx/sites-enabled/
rm /etc/nginx/sites-available/default
sudo service nginx restart > /dev/null


echo "install mysql and give password to installer"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get -y install mysql-server php5-mysql > /dev/null

echo "install mysql and give password to installer"
file="/etc/mysql/my.cnf"

if [ -w "$file" ] #Check if you have write permissions
then
 if ! grep -q collation-server "$file";
 then
   echo "Setting default collation to UTF-8 in /etc/mysql/my.cnf"
  sed '/\[mysqld\]/a # set default collation\
collation-server = utf8_unicode_ci\
init-connect='\''SET NAMES utf8'\''\
character-set-server = utf8\' -i "$file"
sed 's/\\//g' -i "$file"
 fi

 if ! grep -q 'user = root' "$file" && ! grep -q 'password = 12345678' "$file";
 then
   echo "Setting user and password /etc/mysql/my.cnf"
   sed '/\[mysql\]/a # set root password\
user = root\
password = 12345678\' -i "$file"
sed 's/\\//g' -i "$file"
  fi
else
  echo "Can't write to $file. ry running the script with 'sudo'."
fi

sudo service mysql restart

cat /var/www/address/resources/bootstrap_fixtures.sql | mysql

