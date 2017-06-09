#
# Dockerfile for building Nginx images
# 
# https://github.com/sakurallj/docker-lnmp.git
#

FROM hub.c.163.com/library/centos:centos7 
MAINTAINER sakurallj <liaolingjia@163.com>

ENV TZ "Asia/Shanghai"

RUN echo "nameserver 8.8.8.8" >>/etc/resolv.conf

#Yum
 

RUN yum install -y  gcc automake autoconf libtool

RUN yum install -y  make gcc-c++ vixie-cron  wget

RUN yum install -y  zlib  file openssl-devel sharutils zip

RUN yum install -y   bash vim cyrus-sasl-devel libmemcached libmemcached-devel libyaml 

RUN yum install -y  libyaml-devel unzip libvpx-devel openssl-devel 

RUN yum install -y  ImageMagick-devel  autoconf  tar gcc libxml2-devel gd-devel

RUN yum install -y  libmcrypt-devel libmcrypt mcrypt mhash libmcrypt libmcrypt-devel libxml2

RUN yum install -y  libxml2-devel bzip2 bzip2-devel curl 

RUN yum install -y  curl-devel libjpeg libjpeg-devel libpng libpng-devel

RUN yum install -y  freetype-devel bison libtool-ltdl-devel net-tools

RUN yum clean all

#Nginx
RUN cd /tmp && \
  wget http://nginx.org/download/nginx-1.13.1.tar.gz && \
  tar xzf nginx-1.13.1.tar.gz && \
  cd /tmp/nginx-1.13.1 && \
  ./configure \
    --prefix=/usr/local/nginx \
    --with-http_ssl_module --with-http_sub_module --with-http_dav_module --with-http_flv_module \
    --with-http_gzip_static_module --with-http_stub_status_module --with-debug && \
    make && \
    make install

#配置nginx
ENV HTTP_PHP_CONFIG \\\n\\\t#php\\\n\\\tlocation ~ \\\\.php$ {\\\n\\\t\\\troot    html;\\\n\\\t\\\tfastcgi_pass   php7:9000;\\\n\\\t\\\tfastcgi_index    index.php;\\\n\\\t\\\tfastcgi_param  SCRIPT_FILENAME    /usr/local/nginx/html\$fastcgi_script_name;\\\n\\\t\\\tinclude    fastcgi_params;\\\n\\\t}\\\n\\\n\\\t

RUN sed -i -e "s@# deny access to .htaccess files, if Apache@${HTTP_PHP_CONFIG}# deny access to .htaccess files, if Apache@" /usr/local/nginx/conf/nginx.conf

 
 


EXPOSE 80 443

#启动nginx
ENTRYPOINT ["/usr/local/nginx/sbin/nginx", "-g", "daemon off;"]
