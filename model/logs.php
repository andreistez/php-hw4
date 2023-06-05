<?php

function getCurrentLogPath(): string { return 'logs/' . date( 'Y-m-d' ) . '.log'; }

function checkLogExtension( string $file_name ): bool
{
	if( ! $file_name ) return false;

	return !! preg_match( '/^.*\.log$/i', $file_name );
}

function getFileNameWithoutExtension( string $file_name ): ?string
{
	if( ! $file_name ) return null;

	return preg_replace( '/\.[^.]+$/', '', $file_name );
}

function checkLogName( string $name ): bool
{
	return !! preg_match( '/^\d{4}-\d{2}-\d{2}\.log$/', $name );
}

function checkLogFileExists( string $file_name ): bool
{
	return checkLogName( $file_name ) && file_exists( "logs/$file_name" );
}

function writeLog(): bool
{
	$time			= date( 'H:i:s' );
	$ip				= isset( $_SERVER['REMOTE_ADDR'] ) ? "|{$_SERVER['REMOTE_ADDR']}" : '';
	$validateQuery	= ! isset( $_SERVER['QUERY_STRING'] ) || checkQueryParams( $_SERVER['QUERY_STRING'] );
	$uri			= $_SERVER['REQUEST_URI'] ?? '';
	$uri			= ( $uri && ! $validateQuery ) ? "|<span style='color: red'>{$uri}</span>" : "|{$uri}";
	$ref			= isset( $_SERVER['HTTP_REFERER'] ) ? "|{$_SERVER['HTTP_REFERER']}" : '';
	$line			= $time . $ip . $uri . $ref . "\n";

	$f = fopen( getCurrentLogPath(), 'a' );
	$write = fwrite( $f, $line );
	fclose( $f );

	if( ! $write ) return false;

	return true;
}

function getLogsFiles(): array
{
	$files = scandir( 'logs' );

	return array_filter( $files, function( $f ){
		return ( is_file( "logs/$f" ) && checkLogExtension( $f ) );
	} );
}

function getLogFileContent( string $log_name ): ?array
{
	if( ! checkLogFileExists( $log_name ) ) return null;

	if( ! $contents = file( "logs/$log_name", FILE_IGNORE_NEW_LINES ) ) return [];

	return $contents;
}

function checkQueryParams( string $query ): bool
{
	parse_str( $query, $params );
	$allowedParams = ['id', 'name'];

	foreach( $params as $key => $param ){
		$found = false;

		foreach( $allowedParams as $allowed ){
			if( $key === $allowed ){
				$found = true;
				break;
			}
		}

		// One of the current params not found in allowed params list.
		if( ! $found ) return false;
	}

	return true;
}

