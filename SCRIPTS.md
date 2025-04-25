
# Script Usage and Descriptions

### `art`
**Usage**: `./art <command>`  
**Description**: This script is a wrapper for `php artisan`. It allows you to execute any Artisan command inside a Laravel project running within a Docker container. You can run commands like `migrate`, `optimize:clear`, and others using this script.  
**Example**:  
```bash
./art migrate --seed
```
This command runs `php artisan migrate --seed`, which migrates the database and seeds it with data.

Another example:  
```bash
./art optimize:clear
```
This will clear and cache the Laravel configuration, routes, and views.

---

### `artisan`
**Usage**: `./artisan <command>`  
**Description**: This script is another alias for running `php artisan` commands inside a Docker container. It is functionally the same as `./art`, executing any Artisan command inside the Laravel Docker container.  
**Example**:  
```bash
./artisan optimize:clear
```
This command clears cached configuration, routes, and views, improving Laravel's performance.

---

### `bash`
**Usage**: `./bash <container_name> [command]`  
**Description**: This script is used to execute any bash command inside the specified container. If no command is provided, it opens an interactive bash shell inside the container (e.g., `workspace`).  
**Example**:  
```bash
./bash workspace "composer install"
```
This will run `composer install` inside the `workspace` container to install PHP dependencies.

If no command is provided:
```bash
./bash workspace
```
This will open a bash shell inside the `workspace` container.

---

### `clear`
**Usage**: `./clear <command>`  
**Description**: This script is used to execute any bash command (like `ls`, `pwd`, or others) inside a Docker container. It's useful for checking the environment or clearing terminal output.  
**Example**:  
```bash
./clear ls -l
```
This runs the `ls -l` command to list files in the current directory inside the container.

---

### `composer`
**Usage**: `./composer <command>`  
**Description**: This script runs Composer commands inside the Docker container's `workspace` environment. It can execute all Composer commands like `composer install`, `composer update`, and more.  
**Example**:  
```bash
./composer install
```
This command runs `composer install` inside the Docker container to install PHP dependencies.

Another example:  
```bash
./composer update
```
This command runs `composer update` to update the PHP dependencies.

---

### `container`
**Usage**: `./container <container_name> [command]`  
**Description**: Similar to the `bash` and `exec` scripts, this script allows you to run any command inside the specified Docker container, not limited to Artisan or Composer commands.  
**Example**:  
```bash
./container workspace "php artisan migrate"
```
This runs `php artisan migrate` inside the `workspace` container to run database migrations.

---

### `down`
**Usage**: `./down`  
**Description**: This script stops and removes Docker containers using `docker-compose down`. It is useful to gracefully shut down the environment and clean up resources.  
**Example**:  
```bash
./down
```
This stops and removes all containers, networks, and volumes created by `docker-compose`.

---

### `exec`
**Usage**: `./exec <container_name> <command>`  
**Description**: This script allows you to execute a command inside a specified running Docker container. It uses `docker-compose exec` to run the command inside the container.  
**Example**:  
```bash
./exec workspace "php artisan migrate"
```
This will run `php artisan migrate` inside the `workspace` container to execute migrations.

---

### `rebuild`
**Usage**: `./rebuild`  
**Description**: This script rebuilds the Docker containers using `docker-compose up --build`. It is typically used when you make changes to the Dockerfiles or application dependencies.  
**Example**:  
```bash
./rebuild
```
This command rebuilds and restarts the Docker containers with the latest changes.

---

### `restart`
**Usage**: `./restart`  
**Description**: This script restarts the Docker containers using `docker-compose restart`. It is used when you need to restart containers without bringing them down completely.  
**Example**:  
```bash
./restart
```
This restarts all the containers defined in `docker-compose.yml`.

---

### `stop`
**Usage**: `./stop`  
**Description**: This script stops the running Docker containers using `docker-compose stop`. It allows for a graceful stop without removing the containers.  
**Example**:  
```bash
./stop
```
This stops all the running containers without removing them.

---

### `up`
**Usage**: `./up`  
**Description**: This script starts or restarts the Docker containers by running `docker-compose up`. It is used to bring the containers up based on the configuration in `docker-compose.yml`.  
**Example**:  
```bash
./up
```
This command starts or restarts all the containers as defined in `docker-compose.yml`.

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
