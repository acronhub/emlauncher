# Develop EMLauncher on docker containers

## How to run

1. Setup libraries

    ```sh
    git submodule init
    git submodule update
    ```

1. Modify configs

    ```sh
    cp config/emlauncher_config{_sample,}.php
    cp config/mfw_serverenv_config{_sample,}.php

    # set your aws keys and s3 bucket name.
    vim config/emlauncher_config.php
    ```

1. Build docker

    ```sh
    docker-compose build
    ```

1. Composer Install

    ```sh
    docker-compose up -d
    docker-compose exec web bash
    cd /repo/; composer install
    ```

1. Add EMLauncher user

    ```sh
    docker-compose exec db mysql -uroot -ppassword emlauncher -e 'INSERT INTO user_pass (mail) VALUES ("your-name@example.com");'
    ```

1. Open EMLauncher in a browser

    "http://localhost:10080"
