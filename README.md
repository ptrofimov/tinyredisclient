# TinyRedisClient ![English version](http://upload.wikimedia.org/wikipedia/en/thumb/a/ae/Flag_of_the_United_Kingdom.svg/22px-Flag_of_the_United_Kingdom.svg.png)

*TinyRedisClient is the most lightweight Redis client written in PHP*

**Key points**

* *Full-featured:* supports all Redis commands
* *Simple:* just Redis protocol, nothing more
* *Really tiny:* only 50 lines of code
* *Requires nothing:* pure PHP implementation

**Usage example**

```php
$client = new TinyRedisClient( 'host:port' );
$client->set( 'key', 'value' );
$value = $client->get( 'key' );
```

Full list of commands you can see on http://redis.io/commands

[Download](https://github.com/ptrofimov/tinyredisclient/archive/master.zip) and enjoy!

--------------------------------------------------

# TinyRedisClient ![Русская версия](http://upload.wikimedia.org/wikipedia/en/thumb/f/f3/Flag_of_Russia.svg/22px-Flag_of_Russia.svg.png)

*TinyRedisClient - самый легковесный клиент для Redis, написанный на PHP*

**Основные моменты**

* *Полнофункциональный:* поддерживает все команды Redis
* *Простой:* только протокол Redis, ничего лишнего
* *Крошечный:* всего 50 строк кода
* *Нетребовательный:* написан на чистом PHP

**Пример использования**

```php
$client = new TinyRedisClient( 'хост:порт' );
$client->set( 'ключ', 'значение' );
$value = $client->get( 'ключ' );
```

Полный список команд Redis вы можете найти на http://redis.io/commands

[Скачивайте](https://github.com/ptrofimov/tinyredisclient/archive/master.zip) и наслаждайтесь!

--------------------------------------------------

Keywords: redis, storage, nosql, php, client, lightweight, light, easy, simple, small, tiny, protocol