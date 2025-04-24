# Insight CMS

This project provides a streamlined Docker-based development environment for Laravel using Laradock. It includes setup scripts and handy Docker shortcut commands to simplify local development.

## Project Structure

```
├── README.md
├── cmd/
│   ├── artisan
│   ├── down
│   ├── rebuild
│   └── up
├── Setup/
│   ├── docker/
│   │   ├── docker-compose.local.yml
│   │   ├── mysql/
│   │   │   └── Dockerfile
│   │   ├── nginx/
│   │   │   └── sites/web.local.conf
│   │   └── workspace/
│   │       └── crontab/laradock
│   ├── install.sh
│   └── utils.sh
├── Sources/
└── Docker/
```

## Prerequisites

- Docker & Docker Compose installed
- Bash shell available
- Git installed
- SSH access if cloning a private repository

## Environment Installation

```bash
cd Setup
chmod +x install.sh
./install.sh
```

## Edit the /etc/hosts file

```bash
sudo nano /etc/hosts
```

Add the following line:
```
127.0.0.1 web.test
```

## Docker Shortcut Scripts

| Script    | Description                          | Example Usage                  |
|-----------|--------------------------------------|--------------------------------|
| `up`      | Starts Docker containers             | `./cmd/up.sh`                 |
| `down`    | Stops and removes containers         | `./cmd/down.sh`               |
| `rebuild` | Rebuilds containers with no cache    | `./cmd/rebuild.sh`            |
| `artisan` | Runs Laravel Artisan in container    | `./cmd/artisan.sh migrate`    |

Make them executable:
```bash
chmod +x cmd/*
```

## Output

- Laravel code lives in: `Sources/web`
- Laradock lives in: `Docker/`

Web URL:
http://web.test

PhpMyAdmin:
http://localhost:8081

Swagger test form:
http://localhost:5555

Swagger Editor:
http://localhost:5151


## Project Installation

## Environment Variables
Generate a JWT Secret (Important)
```bash
php artisan jwt:secret
```
 Check Your .env File
After running the jwt:secret command, ensure that the .env file contains the following line:
```bash
JWT_SECRET=your_generated_secret_key
```
## API Key (Important)
To use the News API, you will need to obtain an API key from a provider such as NewsAPI. Once you have obtained the API key, you can set it as an environment variable in your `.env` file if missing.
```bash
NEWS_API_KEY=4164b37f2e1a47a1a583003a70c420b3
```

To create a new API key, send a POST request to `/api/v1/api-key` with the required `service_name` and `api_key`. The API key will be securely stored and returned in the response.

To populate the database with dummy data, run the following command:

```bash
php artisan migrate:refresh --seed
```

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

- **Guest**:
  - **Email**: `guest@mail.com`
  - **Password**: `password`

## Postman Instructions

To use the Postman collection, follow these steps:

1. Import the **`roles-permissions.postman_collection.json`** file into Postman.
2. After logging in or registering, save the **Bearer Token** in the `Authorization` section of the `roles-permissions` request.



## License

MIT


