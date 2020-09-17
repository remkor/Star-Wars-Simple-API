Star Wars Simple API
=====================

### **Installation**
```x-sh
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load --no-interaction
```

### **Tests**
```x-sh
./vendor/bin/simple-phpunit
```

### **Swagger**

- /api/doc
- /api/doc.json
