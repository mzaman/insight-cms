
## Installation

For fill dummy data have to run ```php artisan migrate --seed```

## Description

There is three users by defaul Admin, Manager and Guest.<br />
Admin can create, delete and read posts.<br />
Manager has the rights to delete and read posts.<br />
Guest can only read posts.<br />

## Users credentials
Email and password for Admin, Manager and Guest according to<br />
"admin@mail.com", "password"<br />
"manager@mail.com", "password"<br />
"guest@mail.com", "password"<br />

## Postman instructions
Use file "roles-permissions.postman_collection.json" for import collection.<br />
After login or register save Bearer Token in section roles-permissions->Authorization.