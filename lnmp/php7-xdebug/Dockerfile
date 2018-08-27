#
# Dockerfile for building PHP7 images
# 
# https://github.com/sakurallj/docker-lnmp.git
#

FROM  centos
MAINTAINER sakurallj <liaolingjia@163.com>

ENV TZ "Asia/Shanghai"


#install composer
#COPY composer.phar /
#RUN   mv /composer.phar /usr/local/bin/composer && chmod u+x /usr/local/bin/composer
#Dir
RUN mkdir -p /usr/local/nginx/html

#Yum
  RUN yum -y update && \
    yum install -y gcc automake autoconf libtool make gcc-c++ vixie-cron  wget zlib  file openssl-devel sharutils zip  bash vim cyrus-sasl-devel libmemcached libmemcached-devel libyaml libyaml-devel unzip libvpx-devel openssl-devel ImageMagick-devel  autoconf  tar gcc libxml2-devel gd-devel libmcrypt-devel libmcrypt mcrypt mhash libmcrypt libmcrypt-devel libxml2 libxml2-devel bzip2 bzip2-devel curl curl-devel libjpeg libjpeg-devel libpng libpng-devel freetype-devel bison libtool-ltdl-devel net-tools && \
    yum clean all


#Php

RUN  wget http://cn.php.net/distributions/php-7.2.7.tar.gz && \
  tar xzf php-7.2.7.tar.gz && \
  cd /php-7.2.7 && \

  ./configure \
    --prefix=/usr/local/php \
    --with-mysqli --with-pdo-mysql --with-iconv-dir --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir --enable-simplexml --enable-xml --disable-rpath --enable-bcmath --enable-soap --enable-zip --with-curl --enable-fpm --with-fpm-user=nobody --with-fpm-group=nobody --enable-mbstring  --enable-sockets  --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-opcache  --enable-pcntl  && \

    make install

#install pcntl
RUN cd /php-7.2.7/ext/pcntl/ && /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config && make && make install &&   echo "extension=pcntl.so">>/usr/local/php/lib/php.ini

#copy php ini config
RUN cp /php-7.2.7/php.ini-production /usr/local/php/lib/php.ini && \
    cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf && \
    cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf


#install xdebug
RUN cd / && wget https://github.com/xdebug/xdebug/archive/2.6.0.tar.gz && tar xvf /2.6.0.tar.gz && ls -al && cd /xdebug-2.6.0 && ls -al && /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config  && make   && make install \
    &&  echo "[xdebug]">>/usr/local/php/lib/php.ini \
    &&  echo "zend_extension=xdebug.so">>/usr/local/php/lib/php.ini \
     &&  echo "xdebug.remote_enable = on">>/usr/local/php/lib/php.ini \
      &&  echo "xdebug.remote_autostart = off">>/usr/local/php/lib/php.ini \
        &&  echo "xdebug.remote_host=192.168.11.146">>/usr/local/php/lib/php.ini \
        &&  echo "xdebug.remote_port = 9999">>/usr/local/php/lib/php.ini \
         &&  echo "xdebug.idekey = PHPSTROM">>/usr/local/php/lib/php.ini \
         && rm -f xdebug-2.6.0.tgz && rm -rf xdebug-2.6.0

#install redis
RUN cd / && wget http://pecl.php.net/get/redis-3.1.4.tgz && tar xvf /redis-3.1.4.tgz && ls -al && cd /redis-3.1.4 && ls -al &&  /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config  && make  && make test && make install &&  echo "[redis]">>/usr/local/php/lib/php.ini && echo "extension=redis.so">>/usr/local/php/lib/php.ini && rm -f redis-3.1.4.tgz && rm -rf redis-3.1.4 \



#install swoole
&& cd / && wget https://github.com/swoole/swoole-src/archive/v4.0.1.tar.gz && tar xvf /v4.0.1.tar.gz   && ls -al && cd swoole-src-4.0.1 && ls -al &&  /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config --enable-openssl  --enable-swoole   --enable-sockets     --enable-swoole-debug && make && make install && echo  "extension=swoole.so">>/usr/local/php/lib/php.ini


RUN ln -s /usr/local/php/bin/php /usr/local/bin

#install composer
COPY composer.phar .
RUN   mv composer.phar /usr/local/bin/composer && chmod u+x /usr/local/bin/composer

#install re2c
RUN cd / && wget https://github.com/skvadrik/re2c/releases/download/1.0.3/re2c-1.0.3.tar.gz && tar xvf re2c-1.0.3.tar.gz && cd re2c-1.0.3 && ./configure && make && make install


##install phalcon
#RUN cd / &&  wget https://github.com/phalcon/cphalcon/archive/master.zip && unzip master.zip   && ls -al && cd /cphalcon-master/build && ls -al \
#      &&  ./install --phpize /usr/local/php/bin/phpize --php-config /usr/local/php/bin/php-config && echo  "extension=phalcon.so">>/usr/local/php/lib/php.ini \
##install phalcon-tool
#&& mkdir /usr/local/phalcon-tool && cd /usr/local/phalcon-tool  && wget https://github.com/phalcon/phalcon-devtools/archive/master.zip && unzip  master.zip && rm -rf  master.zip && \
#    cd phalcon-devtools-master  && ln -s $(pwd)/phalcon.php /usr/bin/phalcon && chmod ugo+x /usr/bin/phalcon \

    #配置php
RUN sed -i -e 's/listen = 127.0.0.1:9000/listen = 9000/' /usr/local/php/etc/php-fpm.d/www.conf

EXPOSE 9000 9999 80 443 8080  55858 55757  55656


#启动php
ENTRYPOINT ["/usr/local/php/sbin/php-fpm", "-F", "-c", "/usr/local/php/lib/php.ini"]