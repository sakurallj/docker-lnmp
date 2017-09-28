#!/bin/bash
docker run --name nginx -p 80:80 -v 你本机的php代码路径（如：/home/sakurallj/personDoc/dockerSpace/nginx/html）:/usr/local/nginx/html --link php7:php7 -it sakurallj/nginx