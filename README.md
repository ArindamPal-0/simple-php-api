# Simple PHP API

## Instructions

Make sure to download and install [xampp](https://www.apachefriends.org/download.html) and [composer](https://getcomposer.org/download/) in that order.

Setup a xampp mysql database with `stories` table with the following columns:

```sql
id INT PRIMARY KEY AUTO_INCREMENT,
title varchar(30) NOT NULL,
content text NOT NULL
```

Put/copy the project in the xampp installation directory under `htdocs/app`, i.e. `<xampp_install_dir>/htdocs/app`

Then install dependencies with the following command in the project directory.

```shell
composer update
```

Also set appropriate environment variables in `.env` file in project root.

```.env
DB_HOST = "localhost"
DB_USERNAME = "username"
DB_PASSWORD = "password"
DB_NAME = "tinytalks"
```

Then run the xampp apache and mysql server to start the api server.

now you can access the API server at the url `http://localhost/app/` or `http://127.0.0.1/app/`.

- To get all the stories: `http://localhost/app/stories/`
- To search a story with title containing `hello`: `http://localhost/app/stories/?search=hello`
- To get a story with particular id=`1`: `http://localhost/app/stories/?id=1`
