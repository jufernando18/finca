FROM jufernando18/finca-base:1.0.0
COPY . /var/www/html/finca
RUN rm -r /var/www/html/finca/.git
RUN cd /var/www/html/finca
#RUN composer update
RUN sed -i '/<\/VirtualHost>/d' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/# vim/d' /etc/apache2/sites-available/000-default.conf
RUN sed -i '$d' /etc/apache2/sites-available/000-default.conf
COPY enable-finca-site enable-finca-site
RUN cat enable-finca-site >> /etc/apache2/sites-available/000-default.conf
#RUN a2enmod rewrite
RUN a2enmod rewrite
#RUN service apache2 restart
#RUN chown -R nobody: /var/www/html/finca
#USER nobody
