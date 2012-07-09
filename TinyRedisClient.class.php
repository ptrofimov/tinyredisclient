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
 *  @author ptrofimov
 */
class TinyRedisClient
{
	private $_socket;
	
	public function __construct( $server )
	{
		$this->_socket = stream_socket_client( $server );
	}
	
	public function __call( $method, array $args )
	{
		array_unshift( $args, $method );
		$cmd = '*' . count( $args ) . "\r\n";
		foreach ( $args as $item )
		{
			$cmd .= '$' . strlen( $item ) . "\r\n" . $item . "\r\n";
		}
		fwrite( $this->_socket, $cmd );
		$line = fgets( $this->_socket );
		list( $type, $result ) = array( $line[ 0 ], substr( $line, 1, strlen( $line ) - 3 ) );
		if ( $type == '-' )
		{
			throw new Exception( $result );
		}
		elseif ( $type == '$' )
		{
			if ( $result == -1 )
				$result = null;
			else
			{
				$line = fread( $this->_socket, $result + 2 );
				$result = substr( $line, 0, strlen( $line ) - 2 );
			}
		}
		elseif ( $type == '*' )
		{
			$count = ( int ) $result;
			$result = array();
			for( $i = 0; $i < $count; $i++ )
			{
				$line = fgets( $this->_socket );
				$length = ( int ) substr( $line, 1, strlen( $line ) - 3 );
				$line = fread( $this->_socket, $length + 2 );
				$result[] = substr( $line, 0, strlen( $line ) - 2 );
			}
		}
		return $result;
	}
}
