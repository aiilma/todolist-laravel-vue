# Use the official Nginx image as the base image
FROM nginx:alpine

# Copy custom Nginx configuration file
COPY ./docker/nginx/conf/default.conf /etc/nginx/conf.d/default.conf

# Copy application files
COPY ./src/api /var/www/html

# Set permissions for the web server
RUN chown -R nginx:nginx /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Start Nginx server
CMD ["nginx", "-g", "daemon off;"]