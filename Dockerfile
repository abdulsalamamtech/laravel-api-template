# Dockerfile
# Use base image for container
FROM richarvey/nginx-php-fpm:3.1.6

# Copy all application code into your Docker container
COPY . .

RUN apk update

# Install the `npm` package
RUN apk add --no-cache npm

# Install NPM dependencies
# FROM node:19.5.0-alpine

# RUN npm install



# FROM node:10-alpine

# RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app

# WORKDIR /home/node/app

# COPY package*.json ./

# USER node


# FROM node:8.15.1-alpine as build-stage
# WORKDIR /var/www/html
# COPY . .
# RUN npm --verbose install
# RUN npm run build


# Build Vite assets
# RUN npm run build

CMD ["/start.sh"]
