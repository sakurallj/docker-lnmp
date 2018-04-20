#
# Dockerfile for building gitlab images
# 
# https://github.com/sakurallj/docker-lnmp.git
#

FROM hub.c.163.com/library/ubuntu:latest
MAINTAINER sakurallj <liaolingjia@163.com>


RUN apt-get update
RUN apt-get install -y curl openssh-server ca-certificates

RUN apt-get install -y postfix

RUN curl https://packages.gitlab.com/install/repositories/gitlab/gitlab-ee/script.deb.sh |   bash

RUN EXTERNAL_URL="http://127.0.0.1:9000" apt-get install gitlab-ee



EXPOSE 9000



