
Basic WP/Lamp/Memcached/FFMpeg/Docker project

First, generate self-signed ssl certs
openssl req \
    -newkey rsa:2048 \
    -x509 \
    -nodes \
    -keyout server.key \
    -new \
    -out server.crt \
    -subj /CN=dev.mycompany.com \
    -reqexts SAN \
    -extensions SAN \
    -config <(cat /System/Library/OpenSSL/openssl.cnf \
        <(printf '[SAN]\nsubjectAltName=DNS:dev.mycompany.com')) \
    -sha256 \
    -days 3650

2. Add your dev.mycompany.com record to /etc/hosts
3. Run docker-compose up -d to build the containers
4. Run composer install to install wordpress.
