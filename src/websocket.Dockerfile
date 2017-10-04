FROM node:6

MAINTAINER Delve Labs Inc. <info@delvelabs.ca>

WORKDIR /home/node/app

# Copy source code
COPY ./src/websocket/* /home/node/app/

RUN npm install

EXPOSE 8181

CMD [ "npm", "start" ]
