FROM nginx:1.25

USER root
RUN apt-get update && \
    apt-get install -y \
        net-tools
COPY ./* /etc/nginx/conf.d/

WORKDIR /transferencia-api
