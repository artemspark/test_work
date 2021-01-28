# test_work
## Запуск
Для запуска через докер выполнить команду

```docker-compose up --force-recreate -V --build```

После запуска докера развернется дамп базы с тестовыми данными. Порты, на которых работаю контейнеры можно изменить в файле <b>docker-compose.yml</b>
Конфиги соединения базой и т.д можно переопределить в файле <b>config.env</b> <br>
По умолчанию API будет доступно на <b>localhost</b>, phpmyadmin доступен на <b>localhost:8765</b> <br>

## Описание API
Проложенный роутинг
* GET: /advertisement - Получение объявления для открутки
* POST: /advertisement/create - Создание объявления
* POST: /advertisement/update/:id - Обновление объявления
