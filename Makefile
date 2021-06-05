build:
	docker build -t php-blockchain .
	docker run --rm -it -v $(PWD):/app -w /app php-blockchain composer install

destroy:
	docker rm php-blockchain

up:
	docker run --rm --name blockchain -p 8080:8080 -p 3030:3030 -v $(PWD):/app -w /app php-blockchain bash -c "php bin/node"

bash:
	docker run --rm -it --net=host -v $(PWD):/app -w /app php-blockchain bash


build:
	docker run --rm -it --net=host -v $(PWD):/app -w /app php-blockchain composer build
