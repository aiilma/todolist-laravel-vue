build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

ps:
	docker compose ps

composer:
	docker compose run --rm php composer $(arg)

art:
	docker compose run --rm php php artisan $(arg)

db-migrate:
	docker compose run --rm php php artisan migrate

db-seed:
	docker compose run --rm php php artisan db:seed