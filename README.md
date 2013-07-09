Harserver
=========

Introduction
------------
Harserver is standalone webserver which allows you host your own API service locally. It's useful, if you need to use Harvester library, but your application is not written in PHP.

Harserver can also work with **Apache2 or nginx**.

Get started
-----------
###Standalone application
Download [latest .phar archive](http://dev.erpk.org/downloads), or clone repository and install dependencies manually through [Composer](http://getcomposer.org/).

To run your API webserver, execute following command:
```bash
php ./server.phar run --email="your_erepublik_email" --password="your_erepublik_password" --port=1337
```
...or if you installed dependencies manually:
```bash
php ./app/server.php run --email="your_erepublik_email" --password="your_erepublik_password" --port=1337
```

Now you can access resources under `http://localhost:1337/`

###With webserver (Apache/nginx)
Download [latest .tar archive](http://dev.erpk.org/downloads), or clone repository and install dependencies manually through [Composer](http://getcomposer.org/).

Fill configuration file `web/config.json`. Example:
```json
{
    "email": "your_erepublik_email",
    "password": "your_erepublik_password",
    "userAgent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36"
}
```
Now you can access resources under `http://localhost/harserver/web/public/index.php`

Examples
--------
List of resources can be found in `src/API/routing.yml`
```
standalone:
http://localhost:1337/citizen/profile/123456.json
http://localhost:1337/citizen/profile/123456.xml
http://localhost:1337/citizen/search/romper/1.json
http://localhost:1337/market/PL/weapons/7/1.xml

webserver:
http://localhost/harserver/web/public/index.php/citizen/profile/123456.json
http://localhost/harserver/web/public/index.php/citizen/profile/123456.xml
http://localhost/harserver/web/public/index.php/citizen/search/romper/1.json
http://localhost/harserver/web/public/index.php/market/PL/weapons/7/1.xml
```
