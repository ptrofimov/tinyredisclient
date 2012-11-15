<?php
/**
 * Unit-tests for TinyRedisClient class
 * 
 * @author Petr Trofimov <petrofimov@yandex.ru>
 * @see https://github.com/ptrofimov
 */
require_once __DIR__ . '/../TinyRedisClient.php';

class TinyRedisClientTest extends PHPUnit_Framework_TestCase
{
	public function testInstance()
	{
		$client = new TinyRedisClient( 'localhost:6379' );

		$this->assertTrue( is_object( $client ) );
		$this->assertTrue( $client instanceof TinyRedisClient );

		return $client;
	}
}