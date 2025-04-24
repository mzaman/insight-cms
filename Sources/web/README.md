## Installation

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