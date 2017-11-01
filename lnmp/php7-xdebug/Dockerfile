#
# Dockerfile for building PHP7 images
# 
# https://github.com/sakurallj/docker-lnmp.git
#

FROM hub.c.163.com/library/centos:centos7
MAINTAINER sakurallj <liaolingjia@163.com>

ENV TZ "Asia/Shanghai"

#Dir
RUN mkdir -p /usr/local/nginx/html

#Yum
RUN yum -y update && \
    yum install -y gcc automake autoconf libtool make gcc-c++ vixie-cron  wget zlib  file openssl-devel sharutils zip  bash vim cyrus-sasl-devel libmemcached libmemcached-devel libyaml libyaml-devel unzip libvpx-devel openssl-devel ImageMagick-devel  autoconf  tar gcc libxml2-devel gd-devel libmcrypt-devel libmcrypt mcrypt mhash libmcrypt libmcrypt-devel libxml2 libxml2-devel bzip2 bzip2-devel curl curl-devel libjpeg libjpeg-devel libpng libpng-devel freetype-devel bison libtool-ltdl-devel net-tools && \
    yum clean all

#Php
 
RUN cd /tmp && \
  wget http://cn2.php.net/distributions/php-7.1.5.tar.gz && \
  tar xzf php-7.1.5.tar.gz && \
  cd /tmp/php-7.1.5 && \
  ./configure \
    --prefix=/usr/local/php \
    --with-mysqli --with-pdo-mysql --with-iconv-dir --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir --enable-simplexml --enable-xml --disable-rpath --enable-bcmath --enable-soap --enable-zip --with-curl --enable-fpm --with-fpm-user=nobody --with-fpm-group=nobody --enable-mbstring  --enable-sockets  --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-opcache  --enable-pcntl  && \
    make && \
    make install

#install pcntl
RUN cd /tmp/php-7.1.5/ext/pcntl/ && /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config && make && make install &&   echo "extension=pcntl.so">>/usr/local/php/lib/php.ini

#copy php ini config
RUN cp /tmp/php-7.1.5/php.ini-production /usr/local/php/lib/php.ini && \
    cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf && \
    cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf

#install yaf 
RUN cd / && wget  http://pecl.php.net/get/yaf-3.0.4.tgz && tar xvf /yaf-3.0.4.tgz   && ls -al && cd /yaf-3.0.4  && ls -al && /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config  && make  && make test && make install && echo "extension=yaf.so">>/usr/local/php/lib/php.ini
#install xdebug
RUN cd / && wget https://xdebug.org/files/xdebug-2.5.5.tgz && tar xvf /xdebug-2.5.5.tgz && ls -al && cd /xdebug-2.5.5 && ls -al && /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config  && make  && make test && make install \
    &&  echo "[xdebug]">>/usr/local/php/lib/php.ini \
    &&  echo "zend_extension=xdebug.so">>/usr/local/php/lib/php.ini \
     &&  echo "xdebug.remote_enable = on">>/usr/local/php/lib/php.ini \
      &&  echo "xdebug.remote_autostart = off">>/usr/local/php/lib/php.ini \
        &&  echo "xdebug.remote_host=192.168.101.106">>/usr/local/php/lib/php.ini \
        &&  echo "xdebug.remote_port = 9999">>/usr/local/php/lib/php.ini \
         &&  echo "xdebug.idekey = PHPSTROM">>/usr/local/php/lib/php.ini
#install redis
RUN cd / && wget http://pecl.php.net/get/redis-3.1.4.tgz && tar xvf /redis-3.1.4.tgz && ls -al && cd /redis-3.1.4 && ls -al &&  /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config  && make  && make test && make install &&  echo "[redis]">>/usr/local/php/lib/php.ini && echo "extension=redis.so">>/usr/local/php/lib/php.ini

#install unzip
RUN yum install unzip

#install swoole
RUN cd / && wget https://codeload.github.com/swoole/swoole-src/zip/master && unzip master   && ls -al && cd swoole-src-master && ls -al &&  /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config --enable-openssl  --enable-swoole   --enable-sockets     --enable-swoole-debug && make && make install && echo  "extension=swoole.so">>/usr/local/php/lib/php.ini

#install crontab
RUN  yum install -y vixie-cron;yum install -y crontabs;


ENV container docker
RUN (cd /lib/systemd/system/sysinit.target.wants/; for i in *; do [ $i == \
systemd-tmpfiles-setup.service ] || rm -f $i; done); \
rm -f /lib/systemd/system/multi-user.target.wants/*;\
rm -f /etc/systemd/system/*.wants/*;\
rm -f /lib/systemd/system/local-fs.target.wants/*; \
rm -f /lib/systemd/system/sockets.target.wants/*udev*; \
rm -f /lib/systemd/system/sockets.target.wants/*initctl*; \
rm -f /lib/systemd/system/basic.target.wants/*;\
rm -f /lib/systemd/system/anaconda.target.wants/*;
VOLUME [ "/sys/fs/cgroup" ]


EXPOSE 9000
EXPOSE 9999

#setting php-fpm
RUN sed -i -e 's/listen = 127.0.0.1:9000/listen = 9000/' /usr/local/php/etc/php-fpm.d/www.conf

#start php-fpm
#ENTRYPOINT  /usr/local/php/sbin/php-fpm  -c /usr/local/php/lib/php.ini

CMD ["/usr/sbin/init"]