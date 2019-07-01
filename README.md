Карта городов с количеством объявлений (abramskaia-app-2)
=======================================================

## Вопросы ##

При установке композера он ругается, что нет ext-mongodb, хотя все установлено. Делаю --ignore-platform-reqs, но хотелось бы понять почему так.
Собрала основную архитектуру и простое взаимодействие с монго.
В роутах есть testCreate (добавление города), testAll (просмотр коллекции городов), testAddOfferCount (добавление в массив offer_counts новой записи)

## Описание ##

Одностраничное приложение с картой городов. При клике на город под картой появляется график изменения количества объявлений (обновляется раз в минуту).

## Требования ##

gir, docker, docker compose

## Короткая инструкция ##

В терминале:

	git clone https://github.com/abramskama/abramskaia-app-2.git abramskaia-app-2 &&
	cd abramskaia-app-2 &&
	docker run --rm -v $(pwd):/app composer install --ignore-platform-reqs &&
	cd ..  &&
	sudo chown -R $USER:$USER abramskaia-app-2 &&
	cd abramskaia-app-2 &&
	docker-compose up -d

В браузере:

	http://127.0.0.1:9998


