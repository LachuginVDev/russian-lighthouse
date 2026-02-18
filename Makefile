# Dev: Docker — бэкенд; Vite — на хосте (npm run dev)
.PHONY: up down shell migrate fresh install build

up:
	docker compose up -d

down:
	docker compose down

shell:
	docker compose exec app sh

migrate:
	docker compose exec app php artisan migrate

fresh:
	docker compose exec app php artisan migrate:fresh

install:
	docker compose exec app composer install
	npm install

build:
	npm run build
