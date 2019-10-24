# php-set-schedule
A PHP webapp to set schedules to a Data Center

## Usage

Download and copy all files and folders structure.

The top level <code>index.html</code> file, is just a webpage with a link directing to the login page for users.

## Startup

Run the <code>startup.php</code> file to create/initialize the tables in the database. Database should be setup prior to run the app, and credentials should be added to the corresponding php file.

## Users access

```
.../app/login
```

Users will be directed from the start link to the users login page.

## Admin access

```
.../app/admin
```

System admin should open the admin login page. Access is different for the system administrator and users, due to the nature of the service. The user would not be able to create or modify its login/profile access or information, these should be setup an administrator from the IT Team serving the DataCenter.
