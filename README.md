harserver
=========

Introduction
------------
Harserver is standalone webserver which allows you host your own API service locally. It's useful, if you need to use Harvester library, but your application is not written in PHP.

Harserver can also work with **Apache2 or nginx**.

Installation
-----------
###Quick method
Download out of the box application [here](http://dev.erpk.org/downloads) and unpack compressed archive.

###Recommended method
* Download latest [composer.phar](http://getcomposer.org/)
* Run command ```php composer.phar create-project --stability=dev erpk/harserver harserver/```

Composer will check your PHP configuration and download required dependencies. It may take several minutes.

Get started
-----------
###Configuration
Firstly, you need configure your eRepublik account.
Run command below and follow the instructions:
```bash
php ./bin/app.php config
```
When finished, it create `config.json` in main application directory.

###Use as standalone application
To run your API webserver, execute following command:
```bash
php ./bin/app.php run --port=1337
```

Now you can access resources under `http://localhost:1337/`

###Use with webserver (Apache/nginx)
You can access resources under `http://localhost/harserver/web/public/index.php`

Examples
--------
List of resources can be found in `src/Erpk/Harserver/routing.yml`
```
standalone:
http://localhost:1337/citizen/profile/123456.json
http://localhost:1337/citizen/profile/123456.xml
http://localhost:1337/citizen/search/romper/1.json
http://localhost:1337/market/PL/weapons/7/1.xml

webserver:
http://localhost/harserver/web/app.php/citizen/profile/123456.json
http://localhost/harserver/web/app.php/citizen/profile/123456.xml
http://localhost/harserver/web/app.php/citizen/search/romper/1.json
http://localhost/harserver/web/app.php/market/PL/weapons/7/1.xml
```
