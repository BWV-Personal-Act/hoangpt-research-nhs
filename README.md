# NHS-admin



## Table of contents

* [Usage](#usage)
* [Environment variables](#environment-variables)
* [License](#license)

## Usage

### Environment settings

- Install docker
```
sudo yum install -y docker

sudo systemctl start docker

sudo systemctl enable docker

sudo usermod -aG docker ${USER}
```
Logout and login again

- Install docker-compose (for ARM server)
```
sudo yum install -y python37 python3-devel.$(uname -m) libpython3.7-dev libffi-devel openssl-devel

sudo yum groupinstall -y "Development Tools"

sudo python3 -m pip install -U pip

pip3 install docker-compose

sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

docker-compose --version
```

- Add swap (You can skip it)
```
sudo dd if=/dev/zero of=/swapfile bs=512M count=8

sudo chmod 600 /swapfile

sudo mkswap /swapfile

sudo swapon /swapfile

sudo swapon -s

sudo nano /etc/fstab

Add to the end of file
/swapfile swap swap defaults 0 0
```

- Clone source code
```
sudo mkdir -p /var/www/html

cd /var/www/html

sudo git clone [git url]
```

- Run docker-compose
```
cd /var/www/html/nhs-admin

sudo cp .env.example .env

docker-compose up -d --build nhs-ihs-admin
```
```
sudo chown -R ${USER}:docker /var/log/docker-log/

sudo chown -R ${USER}:docker /var/www/html
```

### Update code on server

- Move to folder

```
cd /var/www/html/nhs-admin
```

- Run sh file to automatic pull code and build new docker image

```
sh ./docker-start.sh
```

Select the branch you want to pull the code from. Here, the default will be the pull code from the develop branch. 

### Run batch manually
```
docker exec -it nhs-ihs-admin php artisan batch:{batch name here}
```
Example
```
docker exec -it nhs-ihs-admin php artisan batch:BAT-010
```

### Run database migration

On local
```
php artisan migrate
```
On server (have to run docker-start.sh to deploy docker first)
```
docker exec -it nhs-ihs-admin php artisan migrate
```

### Run project in localhost

- Copy `.env.example` file to `.env` and edit database information

- Run this command to build docker container
```
docker-compose up --build -d nhs-ihs-admin-dev
```
- Go to docker container command line
```
docker exec -it nhs-ihs-admin-dev bash
```
- If first time run project, please run that command
```
composer install

npm i
```
- Create key (run this when first time)
```
php artisan key:generate
```
- Run `npm run watch`

## Environment variables

| Name                             | Required | Value           | Purpose                              |
| -------------------------------- | -------- | --------------- | ------------------------------------ |
| `APP_NAME`                       | true     | nhs-ihs-admin   | The name of your application         |
| `APP_ENV`                        | true     | local, test, production | The "environment" your application |
| `APP_KEY`                        | true     |                 | Encryption Key                       |
| `APP_DEBUG`                      | true     | false           | Is enable Laravel Debugbar           |
| `APP_URL`                        | true     |                 | Application URL                      |
| `LOG_CHANNEL`                    | true     | stack           | Log channel                          |
| `LOG_LEVEL`                      | true     | info            | The minimum "level" a message must be in order to be logged |
| `DB_CONNECTION`                  | true     | mysql           | DB Type                              |
| `DB_HOST`                        | true     |                 | MySQL hostname or IP                 |
| `DB_PORT`                        | true     |                 | MySQL Port                           |
| `DB_DATABASE`                    | true     |                 | MySQL database name                  |
| `DB_USERNAME`                    | true     |                 | MySQL username                       |
| `DB_PASSWORD`                    | true     |                 | MySQL password                       |
| `SESSION_DRIVER`                 | true     | database        | Session driver                       |
| `SESSION_LIFETIME`               | true     | 120             | Session time out                     |
| `MAIL_MAILER`                    | true     | smtp            | Mail drivers                         |
| `MAIL_HOST`                      | true     |                 | Mail host                            |
| `MAIL_PORT`                      | true     | 587             | Mail port                            |
| `MAIL_USERNAME`                  | true     |                 | Mail username                        |
| `MAIL_PASSWORD`                  | true     |                 | Mail password                        |
| `MAIL_ENCRYPTION`                | true     | tls             | Mail encryption                      |
| `MAIL_FROM_ADDRESS`              | true     |                 | Mail from address                    |
| `MAIL_FROM_NAME`                 | true     |                 | Mail from name                       |
| `SYSTEM_ADMIN_MAIL`              | true     |                 | System admin mail use for BCC        |
| `AWS_ACCESS_KEY_ID`              | false    |                 | AWS S3 access key                    |
| `AWS_SECRET_ACCESS_KEY`          | false    |                 | AWS S3 secret key                    |
| `AWS_DEFAULT_REGION`             | true     | ap-northeast-1  | AWS S3 default region                |
| `AWS_BUCKET`                     | true     |                 | AWS S3 default bucket                |
| `ENV_COLOR`                      | false    |                 | Set color for different environments |
| `BATCH_SCHEDULE`                 | true     |                 | Is schedule batch                    |
| `BATCH_UPDATE`                   | true     |                 | Is update batch to DB                |
| `FCM_SERVER_KEY`                 | true     |                 | Firebase Cloud Messaging server key. Use for send push notification |
| `BAT_MST_CUSTOMER`               | true     |                 | Set time to check data from db (ex: 1910 (hour, minute))    |
| `BAT_MST_HOLIDAY`                | true     |                 | Set time to check data from db (ex: 1910 (hour, minute))    |
| `BAT_MST_ITEM`                   | true     |                 | Set time to check data from db (ex: 1920 (hour, minute))    |
| `BAT_MST_ITEM_OFFICE`            | true     |                 | Set time to check data from db (ex: 1920 (hour, minute))    |
| `BAT_MST_ITEM_DETAIL`            | true     |                 | Set time to check data from db (ex: 1920 (hour, minute))    |
| `BAT_MST_PRICE`                  | true     |                 | Set time to check data from db (ex: 1940 (hour, minute))    |
| `BAT_MST_PRICE_ADVANCE`          | true     |                 | Set time to check data from db (ex: 1940 (hour, minute))    |

## License

UNLICENSED
