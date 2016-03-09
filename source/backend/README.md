# Backend Server

---

## Prerequisites

- Docker
	- **Linux**: https://docs.docker.com/engine/installation/
	- **OSX**: docker on OSX is more difficult than in linux. Dont use the recommended method for installation, its flawed. OSX  tries to make you use a VM for all of this kind of stuff. Do the following for OSX:
		- Install Homebrew
		- `brew install docker`
		- `brew install dlite`
		  - `sudo dlite install`
		- `dlite start`
		- Use docker normally...
- Docker-compose
	- **Linux**: `sudo apt-get install docker-compose`
	- **OSX**: It should come pre-installed when you `brew install docker`

## Why Docker?

Docker is pretty great. As an example, lets discuss PHP. To install and run PHP locally, you need to install Apachi, PHP, and Mysql then configure them all manually so that they work together. If you change machines, rinse and repeat.

Docker allows developers to configure the server once, then deploy it on many machines. It utilizes virtual containers to house the applications. Because of this, once the container is running, you can ssh into it, ping it, etc. The server configuration settings carry over to each machine. After the initial setup, to deploy and run on another server requires 1 line of code, assuming Docker is already installed.

## Installation

Navigate to this folder and type: 

```
MYSQLPASS=somepass docker-compose up -d
```

Replace `somepass` with the password you would like to use for the mysql instance

Then give it a minute for the server to come up, then navigate to: http://ip-address/app/install.php

### View It
Use `docker ps` to find the ip address of the web server. Note that 0.0.0.0 and 127.0.0.1 is localhost.

## Rebuild With New Code

There is another way... I can setup a volume so that rebuilding is not necessary. I will look into this.. later.

**If you used the automatic install method:**

```
docker-compose build && MYSQLPASS=somepass docker-compose up -d
```

Replace `somepass` with the password you would like to use for the mysql instance

## Stop & Remove the container

**!!!IMPORTANT!!!** Because the mysql server utilizes a volume so that things can be stopped, started, updated, etc, it is imperitive that you do NOT use `docker-compose kill` OR `docker kill`. This WILL cause **corruption** on the database.

**If you used the automatic install method:**

```bash
docker-compose down
```

## Other Docker Commands

```
docker ps                        # view containers
docker images                    # view images
docker rmi image-label           # remove image
docker rm container-label        # remove container
docker inspect container-label   # container properties
```