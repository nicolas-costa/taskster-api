FROM nginx:latest

COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /application

RUN chown -R www-data:www-data /application