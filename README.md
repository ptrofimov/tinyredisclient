# TinyRedisClient

*TinyRedisClient - the most lightweight Redis client written in PHP*

**Key points**

* *Full-featured:* supports all Redis commands
* *Simple:* just Redis protocol, nothing more
* *Really tiny:* only 48 lines of code
* *Requires nothing:* pure PHP implementation

**Usage example**

```php
$client = new TinyRedisClient( 'host:port' );
$client->set( 'key', 'value' );
$value = $client->get( 'key' );
```

Full list of commands you can see on http://redis.io/commands

Enjoy!

--------------------------------------------------

# TinyRedisClient

*TinyRedisClient - самый легковесный клиент для Redis, написанный на PHP*

**Основные момента**

* *Полнофункциональный:* поддерживает все команды Redis
* *Простой:* только протокол Redis, ничего лишнего
* *Крошечный:* всего 48 строк кода
* *Нетребовательный:* написан на чистом PHP

**Пример использования**

```php
$client = new TinyRedisClient( 'хост:порт' );
$client->set( 'ключ', 'значение' );
$value = $client->get( 'ключ' );
```

Полный список команд Redis вы можете найти на http://redis.io/commands

Спасибо!