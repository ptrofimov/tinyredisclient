<?php
require_once dirname( __FILE__ ) . '/TinyRedisClient.class.php';

$client = new TinyRedisClient( $argv[ 1 ] );

/* start */

$client->del( 'test:key' );

/* strings */

assert( $client->set( 'test:key', 'value' ) === 'OK' );
assert( $client->get( 'test:key' ) === 'value' );
assert( $client->del( 'test:key' ) === '1' );
assert( $client->get( 'test:key' ) === null );

/* exceptions */

try
{
	$client->sadd( 'test:key', 'item1', 'item2' );
	assert( false );
}
catch ( Exception $ex )
{
}

/* sets */

assert( $client->sadd( 'test:key', 'item1' ) === '1' );
assert( $client->sadd( 'test:key', 'item2' ) === '1' );
assert( $client->smembers( 'test:key' ) === array( 'item1', 'item2' ) );
assert( $client->scard( 'test:key' ) === '2' );
assert( $client->del( 'test:key' ) === '1' );
assert( $client->scard( 'test:key' ) === '0' );
assert( $client->smembers( 'test:key' ) === array() );

/* multi */

assert( $client->sadd( 'test:key', 'item1' ) === '1' );
assert( $client->sadd( 'test:key', 'item2' ) === '1' );
assert( $client->multi() === 'OK' );
assert( $client->smembers( 'test:key' ) === 'QUEUED' );
assert( $client->smembers( 'test:key' ) === 'QUEUED' );
assert( $client->exec() === array( array( 'item1', 'item2' ), array( 'item1', 'item2' ) ) );

/* end */

$client->del( 'test:key' );

echo 'OK' . PHP_EOL;