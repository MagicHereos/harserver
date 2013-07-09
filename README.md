Harserver
=========

Introduction
------------
Harserver is standalone webserver which allows you host your own API service locally. It's useful, if you need to use Harvester library, but your application is not written in PHP.

Get started
-----------
You can [download out of the box package](http://harvester.erpk.org/archive/), or clone repository and install dependencies manually through [Composer](http://getcomposer.org/).

To run your API webserver, execute following command:
```
php ./app/server.php run --email="your_erepublik_email" --password="your_erepublik_password" --port=1337
```
Now you can access resources under `http://localhost:1337/`
List of resources can be found in `src/API/routing.yml`

Examples
--------

```
http://localhost:1337/citizen/profile/123456.json
http://localhost:1337/citizen/profile/123456.xml
http://localhost:1337/citizen/search/romper/1.json
http://localhost:1337/market/PL/weapons/7/1.xml
```
