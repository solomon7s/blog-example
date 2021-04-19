FROM nginx:1.19-alpine

COPY ./docker/config/default.conf /etc/nginx/conf.d/default.conf

# Set working directory
WORKDIR /var/www

# Expose port 80 for nginx seerver
EXPOSE 80
