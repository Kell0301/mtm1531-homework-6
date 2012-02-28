<?php

//gets an environment variable we created in the htaccess files
//this is the best way to keep usernames and passwords out of public github repos
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dsn = getenv('DB_DSN');

//opens a connecrtion to the database and stores it in a variable
//PDO allows us to connect to different types of databases, not just MySql
$db = new PDO($dsn, $user, $pass);

//Makes sure we talk to the database in utf-8, so we can support more than just english
$db->exec('SET NAMES utf8');