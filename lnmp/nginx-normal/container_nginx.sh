#!/bin/bash
docker run --name nginx -p 80:80 -v 你本机的php代码路径（如：/home/sakurallj/personDoc/dockerSpace/nginx/html）:/usr/local/nginx/html --link php7:php7 -it sakurallj/nginx



docker run --name nginx-normal -p 7000:7000 -p 7001:7001 -p 7002:7002 -p 7003:7003 -p 7004:7004 -p 7005:7005 -p 7006:7006 -p 6999:80 -v /Users/sakurallj/personDoc/phpSpace:/usr/local/nginx/html --v /Users/sakurallj/personDoc/nginx/config:/usr/local/nginx/conf/s-config --link php7-normal:php7 -d saklurallj/nginx-normal
