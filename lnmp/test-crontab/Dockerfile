#
# Dockerfile for building PHP7 images
# 
# https://github.com/sakurallj/docker-lnmp.git
#

FROM hub.c.163.com/library/centos:centos7
MAINTAINER sakurallj <liaolingjia@163.com>

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
RUN  yum install -y initscripts ; yum install -y vixie-cron;yum install -y crontabs;
EXPOSE 80
CMD ["/usr/sbin/init"]