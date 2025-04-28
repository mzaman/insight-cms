
# Insight CMS

This project provides a streamlined Docker-based development environment for Laravel using Docker. It includes setup scripts and handy Docker shortcut commands to simplify local development.

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
├── cmd
│   ├── art
│   ├── artisan
│   ├── bash
│   ├── clear
│   ├── composer
│   ├── container
│   ├── down
│   ├── exec
│   ├── rebuild
│   ├── restart
│   ├── stop
│   ├── up
│   ├── workspace
├── Setup
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

### 1. Clone the repository:

```bash
git clone git@github.com:mzaman/insight-cms.git
```

### 2. Navigate to the project directory:

```bash
cd insight-cms
```

### 3. Environment Installation
Run the setup script:

```bash
chmod +x Setup/install.sh && ./Setup/install.sh
```

### 4. Edit the `/etc/hosts` file

```bash
sudo nano /etc/hosts
```

Add the following line:
```
127.0.0.1 web.test
```

This `install.sh` script will create a `.env` file with default values and set up the necessary Docker containers.
The installation script will fully automate the setup process, including the configuration of all Docker services, installation of necessary dependencies, Laravel framework setup with specific configurations, database initialization, and seeding of initial data. With this single-step operation, everything will be up and running in just a few minutes. In most cases, you won’t need to manually verify or test any of the setup steps unless there are special circumstances that require attention.

Running the install.sh script multiple times consecutively poses no issues for the proposed project. Each execution will synchronize the necessary setup steps, securely skipping any previously completed processes. It will ensure that the setup progresses from the initial scratch state through the various build stages, ultimately reaching the live application status, even if some parts of the process have already been completed.

And this is the simple installation process — setting everything up effortlessly, so you can get started in no time!


## Docker Shortcut Scripts

| Script     | Description                          | Example Usage                       |
|------------|--------------------------------------|-------------------------------------|
| `workspace`| Enters workspace containers          | `./workspace`                       |
| `up`       | Starts Docker containers             | `./up`                              |
| `stop`     | Stops Docker containers              | `./stop`                            |
| `down`     | Stops and removes containers         | `./down`                            |
| `restart`  | Restarts containers                  | `./restart`                         |
| `rebuild`  | Rebuilds containers with no cache    | `./rebuild`                         |
| `art`      | Runs Laravel Artisan in container    | `./art optimize:clear`              |
| `artisan`  | Runs Laravel Artisan in container    | `./artisan optimize:clear`          |

Make them executable:

```bash
chmod +x cmd/*
```

## Other Example Usages

1. Enter `cmd` directory:

```bash
cd cmd
```

2. Run `./up` to start the containers.

3. Run `./workspace` to enter the workspace container where software is running.

4. Once inside the workspace container, enter `cd /var/www/web` or simply `cd web` to access the Laravel application. You can now run all Composer and Artisan commands.

### Cache Clearing

```bash
./art optimize:clear
```

### Install Composer dependencies

```bash
./composer install
```

Please see the [Scripts File](SCRIPTS.md) for more information.

**Docker yaml file location:** `Setup/docker/docker-compose.local.yml`

## Output

- Laravel code lives in: `Sources/web`
- Laradock lives in: `Docker/`

**Web URLs:**

- [Web](http://web.test)
- PhpMyAdmin: [http://localhost:8081](http://localhost:8081)
- Host: `mysql`
- Username: `root`
- Password: `root`

**Swagger test form:** [http://localhost:5555](http://localhost:5555)

**Swagger source file location:** `Setup/swagger/swagger.yaml`

**Swagger Editor:** [http://localhost:5151](http://localhost:5151)

## Project Installation

### Environment Variables
By default, the project is pre-configured with a JWT secret. If you experience any issues with JWT, generate a new JWT Secret:

```bash
cd cmd && ./art jwt:secret
```

Check your `.env` file. After running the `jwt:secret` command, ensure that the `.env` file contains the following line:

```bash
JWT_SECRET=your_generated_secret_key
```

### API Key (Important)
To use the News API, you will need to obtain an API key from a provider such as [NewsAPI](https://newsapi.org). Once obtained, set it as an environment variable in your `.env` file:

```bash
NEWS_API_KEY=62ca91a83b6a43b2b653ad424a34249d
```

To use a new API key, send a POST request to `/api/v1/api-key` with the required `service_name` and `api_key`. The API key will be securely stored and returned in the response.

**API endpoint:** [http://localhost:5555/#/default/post_api_v1_api_key](http://localhost:5555/#/default/post_api_v1_api_key)

### Database Seeding

To populate the database with dummy data, run the following command from the `cmd` directory:

```bash
./art migrate:refresh --seed
```

### Clearing Cached News

```bash
./clear
```

**NewsAPI** (api/v1/sync-news) endpoint is used to fetch news from NewsAPI and store it in the database. After the first fetch, the API will cache the news for 1 hour. The message on the API response will indicate that the news is being fetched from the cache for the specified time. After that, it will fetch the news from the API again, store it in the database, and cache it for another hour.

**API URL:** [http://localhost:5555/#/default/post_api_v1_sync_news](http://localhost:5555/#/default/post_api_v1_sync_news)

### Cron Job Endpoint
A cron job triggers the data synchronization every 1 hour. For testing, you can manually run it by sending a POST request to `api/v1/cli-sync-news`.

**API URL:** [http://web.test/api/v1/cli-sync-news](http://web.test/api/v1/cli-sync-news)

## Description

I encountered a CORS issue while testing in Chrome, which may be specific to the (Chrome) browser. This is usually a temporary issue during development, and the proper CORS configuration on the server should resolve it.

### User Roles
By default, there are four types of users:

- **Admin**: Can perform almost all actions, including managing users, roles, permissions, API keys, and posts.
  
- **Manager**:
  - **User Management**: Delete, View, Update Users
  - **Role Management**: Update, View, Assign Roles
  - **Permission Management**: Update, View, Assign Permissions
  - **API Key Management**: Manage, Create, Delete API Keys
  - **Post Management**: Read, Update, Archive Posts

- **Editor**:
  - **User Management**: View, Update Users
  - **Role Management**: View Roles
  - **Permission Management**: View, Assign Permissions
  - **Post Management**: Create, Update, Read, Publish, Sync Posts

- **Guest**:
  - **Post Management**: Read Posts

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

## API Test Form
URL: [http://localhost:5555](http://localhost:5555)

- REDIS UI URL: [http://localhost:9987](http://localhost:9987)
- Username: `laradock`
- Password: `laradock`


## Postman Collection

To use the Postman collection, follow these steps:

1. Import the **`./Insight CMS - REST API (v1).postman_collection.json`** file into Postman.
2. After logging in or registering, save the **Bearer Token** in the `Authorization` section. You can use this token for subsequent requests.

## License

MIT
