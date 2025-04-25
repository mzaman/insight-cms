
# Script Usage and Descriptions

### `art`
**Usage**: `./art <command>`  
**Description**: This script is used to execute Artisan commands inside a Laravel project running within a Docker container. It helps automate common Artisan tasks such as `migrate`, `optimize:clear`, and others.  
**Example**:  
```bash
./art migrate --seed
```
This command runs the `migrate --seed` command in your Laravel application to run the migrations and seed the database.

---

### `artisan`
**Usage**: `./artisan <command>`  
**Description**: This script provides an easy way to run Artisan commands inside a Laravel Docker container. It's used to execute commands like `php artisan optimize:clear` or `php artisan migrate`.  
**Example**:  
```bash
./artisan optimize:clear
```
This command clears and caches the Laravel configuration, routes, and views.

---

### `bash`
**Usage**: `./bash <container_name> [command]`  
**Description**: This script is used to execute a given bash command inside the `workspace` container. If no command is provided, it opens an interactive bash shell inside the container.  
**Example**:  
```bash
./bash composer install
```
This will run the `composer install` command inside the `workspace` container to install PHP dependencies.

---

### `clear`
**Usage**: `./clear <command>`  
**Description**: This script is used to run bash commands (like `clear` or other commands) inside a Docker container. It can be used to execute general bash commands that you might want to run in the container's environment.  
**Example**:  
```bash
./clear ls -l
```
This runs the `ls -l` command to list the contents of the current directory in the Docker container.

---

### `composer`
**Usage**: `./composer <container_name> [command]`  
**Description**: This script runs Composer commands inside the Docker container's `workspace` environment. It's typically used for running Composer commands like `composer install` or `composer update` to manage PHP dependencies.  
**Example**:  
```bash
./composer install
```
This command installs PHP dependencies inside the Docker container using Composer.

---

### `container`
**Usage**: `./container <container_name> [command]`  
**Description**: Similar to the `bash` and `exec` scripts, this runs a command inside the container, which is useful for running any arbitrary command within the Docker container environment.  
**Example**:  
```bash
./container php artisan migrate
```
This runs the `php artisan migrate` command inside the Docker container to perform database migrations.

---

### `down`
**Usage**: `./down`  
**Description**: This script is used to bring down the Docker containers. It runs `docker-compose down` to stop and remove the containers defined in the `docker-compose.yml` file.  
**Example**:  
```bash
./down
```
This command stops and removes all containers, networks, and volumes created by `docker-compose`.

---

### `exec`
**Usage**: `./exec <container_name> <command>`  
**Description**: This script is used to execute commands inside a specified Docker container. It uses `docker-compose exec` to run the command inside a running container.  
**Example**:  
```bash
./exec workspace php artisan migrate
```
This runs `php artisan migrate` inside the `workspace` container to run database migrations.

---

### `rebuild`
**Usage**: `./rebuild`  
**Description**: This script is used to rebuild the Docker containers. It typically runs `docker-compose up --build` to rebuild the containers if there were changes to the Dockerfile or dependencies.  
**Example**:  
```bash
./rebuild
```
This command rebuilds the Docker containers and restarts them.

---

### `restart`
**Usage**: `./restart`  
**Description**: This script is used to restart the Docker containers. It typically runs `docker-compose restart` to restart the running containers.  
**Example**:  
```bash
./restart
```
This command restarts all the containers as defined in `docker-compose.yml`.

---

### `stop`
**Usage**: `./stop`  
**Description**: This script stops the running Docker containers using `docker-compose stop`. It's used to gracefully stop all containers without removing them.  
**Example**:  
```bash
./stop
```
This command stops all running containers without removing them.

---

### `up`
**Usage**: `./up`  
**Description**: This script starts or restarts the Docker containers by running `docker-compose up`. It brings up all the containers defined in the `docker-compose.yml` file.  
**Example**:  
```bash
./up
```
This command starts all the containers as defined in `docker-compose.yml`.

---

### Summary Table:

| Script      | Description                                                                                      | Example Usage                                        |
|-------------|--------------------------------------------------------------------------------------------------|------------------------------------------------------|
| `art`       | Executes Artisan commands inside the container.                                                  | `./art migrate --seed`                               |
| `artisan`   | Executes Artisan commands inside the container.                                                  | `./artisan optimize:clear`                           |
| `bash`      | Runs bash commands or opens a bash shell inside the container.                                    | `./bash composer install`                            |
| `clear`     | Executes any bash command inside the container.                                                  | `./clear ls -l`                                      |
| `composer`  | Executes Composer commands inside the container (e.g., `install`, `update`).                      | `./composer install`                                 |
| `container` | Executes commands inside the container (similar to bash and exec scripts).                        | `./container php artisan migrate`                    |
| `down`      | Stops and removes the Docker containers using `docker-compose down`.                             | `./down`                                             |
| `exec`      | Executes a specified command inside a specified container.                                       | `./exec workspace php artisan migrate`               |
| `rebuild`   | Rebuilds the Docker containers using `docker-compose up --build`.                                 | `./rebuild`                                          |
| `restart`   | Restarts the Docker containers using `docker-compose restart`.                                   | `./restart`                                          |
| `stop`      | Stops the Docker containers using `docker-compose stop`.                                         | `./stop`                                             |
| `up`        | Starts or restarts the Docker containers using `docker-compose up`.                              | `./up`                                               |

---

# How to Download

You can download the markdown file from the link below:

[Download Script Usage Descriptions](sandbox:/mnt/data/script_usage_descriptions.md)

Let me know if you need further modifications!
