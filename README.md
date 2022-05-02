# Ikariam Clone

## Preface

This is a fork of the [ikariam](https://github.com/advocaite/ikariam) clone.
I have fixed most of parts of the code that broke over the
years (syntax and language changes,removed and deprecated function, etc.)
There are still things missing from this clone:

* Barbarian village
* Battles

## Installation

You will need `docker` and `docker-compose` in order to build and run game.

To build the image run:

```sh
cd docker_image
docker build . -t ikariam
```

To run the server run:

```sh
docker-compose up
```