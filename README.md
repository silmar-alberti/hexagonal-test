# Laravel  API

poc of unique route api for testing implementation of 
hexagonal design pattern. 
## Requirements

+ Composer
+ Git
+ docker-composer 1.26+

## Setup project

### 1 - build container and install libraries 
```shell script
make setup

sudo chmod -R 777 storage/
```

### 2 - Configure your environment

open the file `.env` on root of project, and configure 3 env variables

```env
ARQUIVEI_API_BASE_URI=
ARQUIVEI_API_ID=
ARQUIVEI_API_KEY=
```

### 3 - Execute containers of project 
```env
make up 
```

### 4 - Run command of data loading

```
make load-database
```


### 5 - access the url
[project URL](http://127.0.0.1:5080/api/v1/nfe/value/54848546588)


## Project Commands

| command                      |                      description  |
|------------------------------|-----------------------------------|
| `make setup`                 | setup the project
| `make up`                    | execute project containers 
| `make build`                 | build project containers 
| `make stop`                  | stop project containers
| `make restart`               | restart project containes
| `make logs`                  | show logs of containers 
| `make php`                   | attach php container
| `make attach-database`       | open database cli interface
| `make apply-migrations`      | apply project migrations
| `make clear`                 | clear laravel cache
| `make load-database`         | load api data and storage on api database
| `make phpstan`               | run phpstan
| `make phpcs`                 | run code style verification
| `make phpcbf`                | fix code style 
| `make phpunit`               | run project tests 
| `make coverage`              | run project tests and generate coverage html report 
| `make composer`              | open container with instaled php and composer
| `make composer-install`      | install project dependencies
