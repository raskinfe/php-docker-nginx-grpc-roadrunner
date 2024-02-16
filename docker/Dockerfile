FROM nginx:alpine

WORKDIR /var/www/html/
# Remove the default Nginx configuration
RUN rm /etc/nginx/conf.d/default.conf

# Copy your custom Nginx configuration file
COPY nginx.conf /etc/nginx/nginx.conf

COPY ./ /var/www/html/
# Expose port 8000 for Nginx
EXPOSE 8000