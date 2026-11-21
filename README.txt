ADIDAS STORE – учебный проект (PHP + JavaScript + MySQL)

ЗАПУСК (XAMPP):
1. Установи XAMPP, запусти Apache и MySQL в панели XAMPP.
2. Скопируй папку adidasproject в C:\xampp\htdocs\
3. Открой http://localhost/phpmyadmin -> вкладка "Импорт" -> выбери database.sql -> "Вперёд".
4. Если у MySQL есть пароль, впиши его в config.php (DB_PASS).
5. Открой в браузере: http://localhost/adidasproject/

КАРТИНКИ ТОВАРОВ:
- Положи файлы в assets/img/products/ (например ultraboost.jpg)
- В phpMyAdmin в таблице products впиши имя файла в колонку image.
- Пока картинки нет, показывается серая заглушка.

СТРУКТУРА:
index.php      – главная (hero + новые товары)
products.php   – каталог, поиск и фильтр по категории
cart.php       – корзина и оформление заказа
login.php / register.php / logout.php – аккаунты
api/cart.php   – JSON-API, его вызывает JavaScript
includes/      – общие части (шапка, подвал, функции)
config.php     – настройки базы данных
database.sql   – таблицы и 10 тестовых товаров
