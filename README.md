Карта городов с количеством объявлений (abramskaia-app-2)
=======================================================

## Описание ##

Одностраничное приложение с картой городов. При клике на город под картой появляется график изменения количества объявлений (обновляется раз в минуту).
+ добавила комманду для инициализации городов

## Требования ##

gir, docker, docker compose

## Короткая инструкция ##

Сначала удалить все из abramskaia-app

В терминале:

	git clone https://github.com/abramskama/abramskaia-app-2.git abramskaia-app-2 &&
	cd abramskaia-app-2 &&
	docker run --rm -v $(pwd):/app composer install --ignore-platform-reqs &&
	cd ..  &&
	sudo chown -R $USER:$USER abramskaia-app-2 &&
	cd abramskaia-app-2 &&
	docker-compose up -d &&
	docker-compose exec app php command.php init

В браузере:

	http://127.0.0.1:9998

