# Laravel Dockerized Environment

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

## Installation

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


## License

MIT


