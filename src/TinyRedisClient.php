<?php
/**
 * TinyRedisClient - the most lightweight Redis client written in PHP
 *
 * Usage example:
 * $client = new TinyRedisClient( 'host:port' );
 * $client->set( 'key', 'value' );
 * $value = $client->get( 'key' );
 *
 * Full list of commands you can see on http://redis.io/commands
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov
 */
class TinyRedisClient_Exception extends Exception
{
}

class TinyRedisClient
{
    /**
     * Socket connection
     *
     * @var resource
     */
    private $_socket;

    /**
     * Constructor
     *
     * @param string $server e.g. "localhost:6379"
     */
    public function __construct($server)
    {
        $this->_socket = stream_socket_client($server);
    }

    public function __call($method, array $args)
    {
        array_unshift($args, $method);
        $cmd = '*' . count($args) . "\r\n";
        foreach ($args as $item) {
            $cmd .= '$' . strlen($item) . "\r\n" . $item . "\r\n";
        }
        fwrite($this->_socket, $cmd);
        return $this->_parseResponse();
    }

    private function _parseResponse()
    {
        $line = fgets($this->_socket);
        list($type, $result) = array($line[0], substr($line, 1, strlen($line) - 3));
        if ($type == '-') // error message
        {
            throw new TinyRedisClient_Exception($result);
        } elseif ($type == '$') // bulk reply
        {
            if ($result == -1)
                $result = null;
            else {
                $line = fread($this->_socket, $result + 2);
                $result = substr($line, 0, strlen($line) - 2);
            }
        } elseif ($type == '*') // multi-bulk reply
        {
            $count = ( int ) $result;
            for ($i = 0, $result = array(); $i < $count; $i++) {
                $result[] = $this->_parseResponse();
            }
        }
        return $result;
    }
}
