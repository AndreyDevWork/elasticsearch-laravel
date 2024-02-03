build:
	docker-compose up -d --build

run:
	docker compose up -d

down:
	docker compose down

composer-i:
	docker-compose exec app composer install

db-migrate:
	docker-compose exec app php artisan migrate

db-fresh:
	docker-compose exec app php artisan migrate:fresh

db-seed:
	docker-compose exec app php artisan db:seed

passport-keys:
	docker-compose exec app php artisan passport:client --password

chmod:
	sudo chmod 777 -R ./
