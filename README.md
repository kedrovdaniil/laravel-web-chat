# Installation (Ubuntu, Debian)
1.  Install PHP with Apache
    ```
    sudo apt update
    sudo apt install php libapache2-mod-php
    sudo systemctl restart apache2
    ```
2.  Install Composer (php package manager)
    ```
    sudo apt update
    sudo apt install php-cli unzip git curl
    
    // download composer intaller file 
    cd ~
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    HASH=`curl -sS https://composer.github.io/installer.sig`
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    
    // check
    composer
    ```
    If message equals to `Installer verified` composer was installed successfuly.
    
    For global installation of composer you need to enter a follow command:
    ```
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    ```
   
3.  Install Laravel
    ```
    sudo apt update
    composer install
    
    // check
    php artisan -V
    ```
4.  Install Redis
    ```
    sudo apt update
    sudo apt install redis-server
    
    // open config and change derictive "supervised" to "systemd". The supervised directive is set to "no" by default.
    sudo nano /etc/redis/redis.conf
    // save changes with "Ctrl + S" shortcuts and close the file
    sudo systemctl enable redis
    sudo systemctl restart redis
    ```
5.  Install Node.js with `laravel-echo-server`.
    Follow the [installation guide](https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-20-04-ru).
    After installation of the Node.js make follow command:
    ```
    npm install -g laravel-echo-server
    
    // generate config file in you project  
    laravel-echo-server init
    ```
    The config file should contain host & port for redis and an authHost with auth endpoint. Also it should have appId and key.
    Example:
    ```
    {
        "authHost": "http://localhost:8000",
        "authEndpoint": "/broadcasting/auth",
        "clients": [
            {
                "appId": "0113145e5900838e",
                "key": "109e466d59409e1311d43d6c9d600718"
            }
        ],
        "database": "redis",
        "databaseConfig": {
            "redis": {
                "host": "127.0.0.1",
                "port": "6379"
            },
            "sqlite": {
                "databasePath": "/database/laravel-echo-server.sqlite"
            }
        },
        "devMode": true,
        "host": null,
        "port": "6001",
        "protocol": "http",
        "socketio": {},
        "secureOptions": 67108864,
        "sslCertPath": "",
        "sslKeyPath": "",
        "sslCertChainPath": "",
        "sslPassphrase": "",
        "subscribers": {
            "http": true,
            "redis": true
        },
        "apiOriginAllow": {
            "allowCors": true,
            "allowOrigin": "http://localhost:3000",
            "allowMethods": "GET, POST",
            "allowHeaders": "Origin, Content-Type, X-Auth-Token, X-Requested-With, Accept, Authorization, X-CSRF-TOKEN, X-Socket-Id"
        }
    }  
    ```

6. Setup Laravel environment
Open a directory with the project, copy .evn.example file with the command "cp .env.example .env", then setup you environment.
For example you can use the example environment below:
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:q+hS5H7YbKu3cWIRalTDRxmcw0pGvx6P5Ow5x4FPWxo=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=chats
DB_USERNAME=postgres
DB_PASSWORD=123

BROADCAST_DRIVER=redis
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_PREFIX=

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```
    
6. Start the project
```angular2html
// start a frontend part
yarn run start // or npm run start

// start a backend part
php artisan serve

// start a laravel-echo-server
laravel-echo-server start

// start a queue
php artisan queue:work
```

7. Open two instances of a different browsers to http://localhost:3000
    - First account credentials:
       - email: qwe@qwe.qwe
       - password: qweqwe
    - Second account:
       - email: asd@asd.asd
       - password: asdasd
   
8. Try to enter a message and send it. It should work through WebSockets.
