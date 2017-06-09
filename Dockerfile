FROM phusion/baseimage:0.9.18
MAINTAINER Vora Vor <voravor@gmail.com>

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update

#utilities
RUN apt-get -y install nano curl zip unzip

# install ffmpeg
RUN add-apt-repository -y ppa:mc3man/trusty-media
RUN	apt-get update
RUN apt-get -y dist-upgrade ffmpeg

# apache, php some php extensions
RUN apt-get -y install \
	apache2 php5 libapache2-mod-php5 php5-mcrypt php5-mysql php5-curl php5-gd php-apc php5-json && \
    apt-get clean && \
    update-rc.d apache2 defaults && \
    php5enmod mcrypt && \
    rm -rf /var/www/html

#php memcached
RUN apt-get -y install php5-memcached php5-memcache

#mod_rewrite
RUN a2enmod rewrite
RUN a2enmod ssl

#vhost
COPY config/apache.conf /etc/apache2/sites-available/000-default.conf
COPY config/php.ini /etc/php5/apache2/php.ini

#certs
COPY config/ssl /etc/apache2/ssl

EXPOSE 80 443

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
