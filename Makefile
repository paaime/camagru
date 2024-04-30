NAME				= camagru
YML_FILE		= docker-compose.yml

all: build

build:
	docker-compose -p $(NAME) -f $(YML_FILE) up --build --remove-orphans

stop:
	docker-compose -p $(NAME) -f $(YML_FILE) stop

up:
	docker-compose -p $(NAME) -f $(YML_FILE) up

down:
	docker-compose -p $(NAME) -f $(YML_FILE) down

clean: stop
	docker system prune -af
	docker volume prune -f

.PHONY: all build stop up down clean