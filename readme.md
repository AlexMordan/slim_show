# Doctrine commands
```bash
vendor/bin/doctrine                Show list all commands
orm:schema-tool:create             Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output
orm:schema-tool:drop               Drop the complete database schema of EntityManager Storage Connection or generate the corresponding SQL output
orm:schema-tool:update             Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata
```
# Test data
Run scripts in folder `src/Console/`
```bash
add_test_users.php      Add 50 test users
```


# Task List
- Редирект на страницу при успешной авторизации
- Оптимизация CSS
- Вынос валидации а отдельные сущности
- Переписать пути `$app->appPath` получает путь к папке `src`
- Допиать `update profile`
- Logout через форму
- CSRF Protection (cross-site request forgery)
- Кастомные заглушки ошибок
- Вынос адреса в отдельную сущность