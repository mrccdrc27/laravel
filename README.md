# LMS and Certification System Integration

## Project Overview
This project integrates a Learning Management System (LMS) and a Certification System (CS) using two separate Laravel projects.

## Required Libraries/Packages
- [Prerequisites](./Prerequisites.md)

## Code Guide
- [Codes](./code-explanation.md)
  
## Setup Instructions
1. Clone the repositories for both `lms-system` and `certification-system`.
2. Install dependencies:
   ```bash
   composer install
3. Configure .env of each project folders to your own system ***(Don't forget to use 'cd' to the folder you want to use)***

### _Example_:
  ```php
   APP_NAME=Certification-System
   APP_URL=http://localhost
   DB_CONNECTION=sqlsrv
   DB_HOST=DESKTOP-2QRCQSL
   DB_PORT=1433
   DB_DATABASE=test
   DB_USERNAME=
   DB_PASSWORD=
````
4. Type ``php artisan serve`` to run the laravel servers (optionally specify port number: `php artisan serve --port=8000`)
   
5. ``php artisan serve --host=0.0.0.0 --port=8000``  for hosting on the local network
   _(host=0.0.0.0 to bind server to all available network interface, otherwise assign your local IP address)_

## For problems with dependencies

1. For specific packages:
``composer require simplesoftwareio/simple-qrcode``
or
```bash
composer install
```
3. Then clear cached configuration and regenerate autoloader:
``php artisan config:cache 
  composer dump-autoload``

## Artisan Serve/Hosting Problems
### Check firewall settings on your computer, ensure the port is open and accessible
1. Open *Windows Defender -> Firewall -> Advanced Settings -> Inbound Rules
2.  Modify existing rule for port or... Add new rule for port
      2.1 For adding rules:
    
      2.2 Set rule type to Port
   
      2.3 Set as TCP and specify port number
  
     2.4 Allow connection & set to apply to all profiles
  
4. Check if your device's connection is set to Private/Public by going to *Settings->'name of connection'->Network Profile (Private/Public)
    _(Network profiles can have certain restrictions)_

## Database Connection Problems
### SQL Server Configuration Manager
1. Run **SQL Server Configuration Manager**
2. Right click on **SQL Server** (MSSQLSERVER) and set to start

### SQL Server TCP/IP Connections
1. Open **SQL Server Configuration Manager**
2. Navigate to *SQL Server Network Configuration* -> Protocols for MSSQLSERVER
3. Ensure TCP/IP is enabled
4. To allow SQL server to listen on a specific TCP port
   
   4.1 Open **SQL Server Configuration Manager**
   
   4.2 Under **Protocols** for MSSQLSERVER, double-click **TCP/IP**
   
   4.3 Enable and activate IP1 and IP2, ensure the same port number **_(IP1 is the first IP address SQL Server binds to)_**
   
   4.4 Leave TCP Dynamic Ports as Blank (for IPAII) **_(IPAII represents all settings that apply to all IP addresses)_**
   
     Leave TCP Dynamic Ports blank to make SQL Server listen to a specific port (1433 for defalt instances)


   ## Setup Instructions
1. Clone the repositories for both `lms-system` and `certification-system`.
2. Install dependencies:
