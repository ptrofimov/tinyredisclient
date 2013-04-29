<?php
/**
 * TinyRedisClient - the most lightweight Redis client written in PHP
 *
 * Usage example:
 * $client = new TinyRedisClient("host:port");
 * $client->set("key", "value");
 * $value = $client->get("key");
 *
 * Full list of commands you can see on http://redis.io/commands
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov
 */
class TinyRedisClient
{
    /** @var string */
    private $server;
    /** @var resource */
    private $socket;

    public function __construct($server = 'localhost:6379')
    {
        $this->server = $server;
    }

    public function __call($method, array $args)
    {
        array_unshift($args, $method);
        $cmd = '*' . count($args) . "\r\n";
        foreach ($args as $item) {
            $cmd .= '$' . strlen($item) . "\r\n" . $item . "\r\n";
        }
        fwrite($this->getSocket(), $cmd);

        return $this->parseResponse();
    }

    private function getSocket()
    {
        return $this->socket
            ? $this->socket
            : ($this->socket = stream_socket_client($this->server));
    }

    private function parseResponse()
    {
        $line = fgets($this->getSocket());
        list($type, $result) = array($line[0], substr($line, 1, strlen($line) - 3));
        if ($type == '-') { // error message
            throw new Exception($result);
        } elseif ($type == '$') { // bulk reply
            if ($result == -1) {
                $result = null;
            } else {
                $line = fread($this->getSocket(), $result + 2);
                $result = substr($line, 0, strlen($line) - 2);
            }
        } elseif ($type == '*') { // multi-bulk reply
            $count = ( int ) $result;
            for ($i = 0, $result = array(); $i < $count; $i++) {
                $result[] = $this->parseResponse();
            }
        }

        return $result;
    }
}
