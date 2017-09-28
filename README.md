## 背景
每次换电脑都要重新部署lnmp，每次花费的时间至少要半天，很浪费时间。所以就把lnmp docker化。
## 环境
本机环境：ubuntu 16.04 LTS
## 安装dockeer

``` shell
$ apt-get install docker.io
$ docker --version //output:Docker version 1.12.6, build 78d1802  说明docker安装成功
```
## 编写dockfile
### mysql [dockfile](https://github.com/sakurallj/docker-lnmp/blob/master/lnmp/mysql/Dockerfile)
这里使用了 hub.c.163.com/library/mysql:8.0.1的镜像，后面只是简单的设置了一下时区而已。基体的镜像用法见[这里](https://c.163.com/hub#/m/repository/?repoId=2955)。
```
FROM hub.c.163.com/library/mysql:8.0.1   #网易蜂巢的镜像
MAINTAINER sakurallj <liaolingjia@163.com> #作者 及 email
ENV TZ "Asia/Shanghai"  #设置时区
```
### php [dockfile](https://github.com/sakurallj/docker-lnmp/blob/master/lnmp/php7/Dockerfile)

基于centos7 镜像，自己编译定制安装，并且附带yaf框架的安装
### nginx [dockfile](https://github.com/sakurallj/docker-lnmp/blob/master/lnmp/nginx/Dockerfile)
基于centos7 镜像，自己编译定制安装 

## 创建镜像

``` shell
docker build --tag sakurallj/mysql -f mysql/Dockerfile .
docker build --tag sakurallj/php7 -f php7/Dockerfile .
docker build --tag sakurallj/php7-swoole -f php7-swoole/Dockerfile .
docker build --tag sakurallj/php7-xdebug -f php7-xdebug/Dockerfile . //需要把里面的remote_host对应的ip换为IDE对应的ip
docker build --tag sakurallj/nginx -f nginx/Dockerfile .
```
## PHPStorm xdebug 配置
>In Intellij/PHPStorm go to: Languages & Frameworks > PHP > Debug > DBGp Proxy and set the following settings:
>Host: your IP address
>Port: 9000
![这里写图片描述](https://github.com/sakurallj/docker-lnmp/images/1506582725591.jpg)
![这里写图片描述](https://github.com/sakurallj/docker-lnmp/images/1506582813543.jpg)
![这里写图片描述](https://github.com/sakurallj/docker-lnmp/images/1506582842657.jpg)
enjoy it
![这里写图片描述](https://github.com/sakurallj/docker-lnmp/images/1506582873299.jpg)
[参考 Debug your PHP in Docker with Intellij/PHPStorm and Xdebug](https://gist.github.com/chadrien/c90927ec2d160ffea9c4)
## 运行
``` shell
$ docker run --name mysql -p 8800:3306 -v mysql的数据文件放在你本机的路径(如：/home/sakurallj/data/mysql):/var/lib/mysql -e MYSQL_ROOT_PASSWORD=你随便输入字符作为root用户的密码 -it sakurallj/mysql
$ docker run --name php7 -p 9000:9000 -v 你本机的php代码路径（如：/home/sakurallj/personDoc/dockerSpace/nginx/html）:/usr/local/nginx/html --link mysql:mysql -it sakurallj/php7
$ docker run --name nginx -p 80:80 -v 你本机的php代码路径（如：/home/sakurallj/personDoc/dockerSpace/nginx/html）:/usr/local/nginx/html --link php7:php7 -it sakurallj/nginx
```

## 测试
把[test.php](https://github.com/sakurallj/docker-lnmp/blob/master/lnmp/php7/test.php)放到/home/sakurallj/personDoc/dockerSpace/nginx/html下，然后访问http://127.0.0.1:8700/test.php


## 常用命令

```
$ docker exec -it php7或container id //进入container内部
$ docker ps -al //查看所有container 包含 运行、停止的
$ docker ps //查看运行中的container
$ docker rm $(docker ps -al)  //批量删除 container
$ docker rmi  xxx//image id  //镜像id

```
## 参考
[Docker多容器部署LNMP环境](http://www.jianshu.com/p/fcd0e542a6b2)

## LICENSE
随兴用