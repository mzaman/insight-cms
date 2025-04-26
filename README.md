# Insight CMS

This project provides a streamlined Docker-based development environment for Laravel using docker. It includes setup scripts and handy Docker shortcut commands to simplify local development.

## Prerequisites

- Docker & Docker Compose installed
- Bash shell available
- Git installed
- SSH access if cloning a private repository

## Project Structure

```
├── README.md
├── ARCHITECTURE.md
├── SCRIPTS.md
├── Insight CMS - REST API (v1).postman_collection.json
├── cmd
│   ├── art
│   ├── artisan
│   ├── artisan_output.log
│   ├── bash
│   ├── bash_output.log
│   ├── clear
│   ├── composer
│   ├── container
│   ├── down
│   ├── exec
│   ├── nginx_output.log
│   ├── rebuild
│   ├── restart
│   ├── stop
│   ├── up
│   ├── workspace
│   └── workspace_output.log
├── setup
│   ├── docker
│   │   ├── docker-compose.local.yml
│   │   ├── mysql
│   │   │   └── Dockerfile
│   │   ├── nginx
│   │   │   └── sites
│   │   │       └── web.local.conf
│   │   └── workspace
│   │       └── crontab
│   │           └── laradock
│   ├── install.sh
│   ├── swagger
│   │   └── swagger.yaml
│   └── utils.sh
└── Sources
    ├── public
    │   └── index.html
    └── web/app
```


## Getting Started

1. Clone the repository:

```bash
git clone git@github.com:mzaman/insight-cms.git
```

2. Navigate to the project directory:

```bash
cd insight-cms
```

3. Environment Installation
Run the setup script:

```bash
cd Setup
chmod +x install.sh
./install.sh
```

This script will create a `.env` file with default values and set up the necessary Docker containers.


4. Edit the /etc/hosts file

```bash
sudo nano /etc/hosts
```

Add the following line:
```
127.0.0.1 web.test
```

## Docker Shortcut Scripts

| Script    | Description                          | Example Usage                      |
|-----------|--------------------------------------|------------------------------------|
| `workspace` | Enters workspace containers                   | `./workspace`                    |
| `up`      | Starts Docker containers             | `./up`                      |
| `stop`    | Stops Docker containers              | `./stop`                    |
| `down`    | Stops and removes containers         | `./down`                    |
| `restart` | Restarts containers                  | `./restart`                 |
| `rebuild` | Rebuilds containers with no cache    | `./rebuild`                 |
| `art` | Runs Laravel Artisan in container    | `./art optimize:clear`  |
| `artisan` | Runs Laravel Artisan in container    | `./artisan optimize:clear`  |

Make them executable:
```bash
chmod +x cmd/*
```

## Usage
Enter cmd directory (`cd cmd`) and run `./up` to start the containers.:
1. Run `./up` to start the containers.
2. Run `./workspace` to enter the workspace container where softwares are running.
3. Run `./workspace` and then enter `cd /var/www/web` or simply `cd web` to change directory. It will enter you can run all Composer and Artisan commands.

Cache Clearing

```bash
./art optimize:clear
```

Cache Clearing

```bash
./bash composer install
```

Please see [Scripts File](SCRIPTS.md) for more information.

Docker yaml file location: `Setup/docker/docker-compose.local.yml`

## Output

- Laravel code lives in: `Sources/web`
- Laradock lives in: `Docker/`

Web URLs:
http://web.test

PhpMyAdmin:
http://localhost:8081

Host: mysql
Username: root
Password: root

Swagger test form:
http://localhost:5555

Swagger source file location: `Setup/swagger/swagger.yaml`

Swagger Editor:
http://localhost:5151

Postman colletion file: `./Insight CMS - REST API (v1).postman_collection.json`

## Project Installation

## Environment Variables
Initially its pre-configured with JWT secret that should work. but generate a JWT Secret if there is any issue with JWT.
```bash
cd cmd && ./art jwt:secret
```
 Check Your .env File
After running the jwt:secret command, ensure that the .env file contains the following line:
```bash
JWT_SECRET=your_generated_secret_key
```
## API Key (Important)
To use the News API, you will need to obtain an API key from a provider such as NewsAPI. Once you have obtained the API key, you can set it as an environment variable in your `.env` file if missing.
```bash
NEWS_API_KEY=62ca91a83b6a43b2b653ad424a34249d
```

Get a new API key from NewsAPI URL: https://newsapi.org

To use a new API key, send a POST request to `/api/v1/api-key` with the required `service_name` and `api_key`. The API key will be securely stored and returned in the response.
API endpoint: http://localhost:5555/#/default/post_api_v1_api_key


To populate the database with dummy data, run the following command from cmd directory:

```bash
./art migrate:refresh --seed
```

To clear cached news, run the following command from cmd directory:

```bash
./clear
```

NewsAPI (api/v1/sync-news) endpoint is used to fetch news from NewsAPI and store it in the database. After first fetch, the API will cached the news for 1 hour. The message on API response will show that the news is being fetched from the cache for the specified time. After that it will fetch the news from the API again and store it in the database and cache it for 1 hour. API URL: http://localhost:5555/#/default/post_api_v1_sync_news

There is endpoint that's prepared to be triggered by a cron job that runs every 1 hour. For testing purposes, you can run it manually by sending a POST request to `api/v1/cli-sync-news`. API URL: http://web.test/api/v1/cli-sync-news

## Description

By default, there are three types of users:

- **Admin**: Can create, delete, and read posts.
- **Manager**: Has the rights to delete and read posts.
- **Guest**: Can only read posts.

## User Credentials

Here are the default credentials for each user:

- **Admin**:
  - **Email**: `admin@mail.com`
  - **Password**: `password`

- **Manager**:
  - **Email**: `manager@mail.com`
  - **Password**: `password`
  
- **Editor**:
  - **Email**: `editor@mail.com`
  - **Password**: `password`

- **Guest**:
  - **Email**: `guest@mail.com`
  - **Password**: `password`

## Postman Instructions

To use the Postman collection, follow these steps:

1. Import the **`roles-permissions.postman_collection.json`** file into Postman.
2. After logging in or registering, save the **Bearer Token** in the `Authorization` section. You can use this token for subsequent requests.



## License

MIT


