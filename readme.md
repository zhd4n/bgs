# Установка
* git clone https://github.com/z-h-z-h/bgs.git bgs
* docker-compose up -d
* cp .env.example .env
* docker-compose run --rm composer install
* docker-compose run --rm artisan key:generate
* docker-compose run --rm artisan test - запустит тесты
* GET http://localhost:8080/api/install - засидирует в базу юзера, ивенты, создаст токен для авторизации
* Токен посылаем в заголовке вида Authorization: Bearer 1|Xwj7uyOMQHdq00UEygidsaHCDILmNwaLGsVLaZqZBh72iCN4jp4lduARZnemZbHbKv56pMdXnIjneFBG
* ??
* Profit!

# Эндпоинты
* GET http://localhost:8080/api/participants?event_id={event_id}
   * event_id - необязательный параметр, сидер добавляет 10 тестовых ивентов
* POST http://localhost:8080/api/participants
* PUT http://localhost:8080/api/participants/{participant_id}
* DELETE http://localhost:8080/api/participants/{participant_id}

# Редактируемые поля участника
* event_id
* first_name
* last_name
* email

## Примечание
Запуск тестов отчищает базу и если хочется после что-то тестировать в ручную, то можно запустить api/install ещё раз
