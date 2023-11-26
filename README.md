# Ikariam Clone

## Preface

This is a fork of the [ikariam](https://github.com/advocaite/ikariam) clone.
I have fixed most of parts of the code that broke over the
years (syntax and language changes,removed and deprecated function, etc.)
There are still things missing from this clone:

* Barbarian village
* Battles

## Prerequisites

* docker
* Compose V2

## Setting up the server

To run the server:
```sh
docker compose build
docker-compose up
```

To initializae the database:
```sh
mysql -u root -S ./mysql/mysql.sock -e 'create database ik_game'
mysql -u root -S ./mysql/mysql.sock ik_game < sql.sql
```
