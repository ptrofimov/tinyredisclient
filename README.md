# TinyRedisClient

*TinyRedisClient - the most lightweight Redis client written in PHP*

**Key points**

* *Full-featured:* supports all Redis commands
* *Simple:* just Redis protocol, nothing more
* *Really tiny:* only 48 lines of code
* Requires nothing: pure PHP implementation

**Usage example**

```php
$client = new TinyRedisClient( 'host:port' );
$client->set( 'key', 'value' );
$value = $client->get( 'key' );
```

Full list of commands you can see on http://redis.io/commands

Enjoy!