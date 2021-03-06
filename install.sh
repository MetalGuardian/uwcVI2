#!/usr/bin/env bash
sudo su
export DEBIAN_FRONTEND=noninteractive

apt-get update -y

apt-get install -y -q git php5-cli php5-mysql php5-curl php5-intl php5-json curl
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# for cloning from github
#mkdir ~/www
#cd ~/www
#git clone https://github.com/MetalGuardian/uwcVI2.git .
#composer install
#cp /vagrant/config.php.sample ~/www/config.php
# cloning done

# for unpacking tar.gz
cd ~
tar xvzf /vagrant/metalguardian.tar.gz
# unpackin done


cd ~/www/public
nohup php -S 0.0.0.0:8000 &
