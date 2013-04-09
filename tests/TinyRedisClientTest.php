<?php
/**
 * Unit-tests for TinyRedisClient class
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov
 */
class TinyRedisClientTest extends PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $client = new TinyRedisClient('localhost:6379');

        $this->assertTrue(is_object($client));
        $this->assertTrue($client instanceof TinyRedisClient);

        return $client;
    }

    /**
     * @depends testInstance
     */
    public function testStrings($client)
    {
        $client->del('test:key');

        $this->assertSame('OK', $client->set('test:key', 'value'));
        $this->assertSame('value', $client->get('test:key'));
        $this->assertSame('1', $client->del('test:key'));
        $this->assertSame(null, $client->get('test:key'));

        return $client;
    }

    /**
     * @depends testStrings
     */
    public function testSets($client)
    {
        $client->del('test:key');

        $this->assertSame('1', $client->sadd('test:key', 'item1'));
        $this->assertSame('1', $client->sadd('test:key', 'item2'));
        $this->assertSame(array('item1', 'item2'), $client->smembers('test:key'));
        $this->assertSame('2', $client->scard('test:key'));
        $this->assertSame('1', $client->del('test:key'));
        $this->assertSame('0', $client->scard('test:key'));
        $this->assertSame(array(), $client->smembers('test:key'));

        return $client;
    }

    /**
     * @depends testSets
     */
    public function testMulti($client)
    {
        $client->del('test:key');

        $this->assertSame('1', $client->sadd('test:key', 'item1'));
        $this->assertSame('1', $client->sadd('test:key', 'item2'));
        $this->assertSame('OK', $client->multi());
        $this->assertSame('QUEUED', $client->smembers('test:key'));
        $this->assertSame('QUEUED', $client->smembers('test:key'));
        $this->assertSame(array(array('item1', 'item2'), array('item1', 'item2')), $client->exec());

        return $client;
    }

    /**
     * @depends testMulti
     */
    public function testException($client)
    {
        $this->setExpectedException('TinyRedisClient_Exception');

        $this->assertSame('OK', $client->set('test:key', 'value'));
        $client->sadd('test:key', 'item1', 'item2');
    }
}
