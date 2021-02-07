<?php

error_reporting ( E_ALL );
ini_set( 'display_errors' , TRUE );
set_error_handler( function( $errno , $errstr , $errfile , $errline , array $errcontext )
{
	if ( 0 === error_reporting() ) { return false; }
	throw new ErrorException( $errstr , 0 , $errno , $errfile , $errline );
} );

if ( count ( $argv ) < 2 )
{
	print "Use: " . $argv[0] . " [lang]\n";
	return -1;
}

ScanRecurse( $argv[1] );
return;

function ScanRecurse( $lang )
{
	if ( substr( $lang , -1 ) == DIRECTORY_SEPARATOR )
		$lang = substr( $lang , 0 , strlen( $lang ) -1 );
	
	if ( ! is_dir( $lang ) )
		throw new Exception( 'Not a directory: ' . $lang );
	
	$dirs[] = $lang;
	$files = [];
	
	while( count( $dirs ) > 0 )
	{
		$dir = array_pop( $dirs );
		
		$entrys = scandir( $dir );
		foreach( $entrys as $entry )
		{
			if ( $entry[0] == "." )
				continue;
			
			$path = $dir . DIRECTORY_SEPARATOR . $entry;
			if ( is_dir( $path ) )
			{
				array_push( $dirs, $path );
			}
			else
			{
				if ( substr( $entry , -4 ) != '.xml' )
					continue;
				if ( substr( $entry , 0, strlen( "entities." ) ) == "entities." )
					continue;
				
				$files[] = $path;
			}
		}
	}
	
	foreach( $files as $file2 )
	{
		$file1 = 'en' . substr( $file2 , strlen( $lang ) );
		
		if ( ! file_exists( $file1 ) )
		{
			print "Not in EN: $file1\n";
			continue;
		}
		
		# Original revision
		
		$nOrigLin = 0;
		$nOrigRev = 0;
		
		$lines = file( $file1 );
		for ( $n = 0 ; $n < min( 10 , count( $lines ) ) ; $n++ )
		{
			$parts = explode( ' ' , normalize_space( $lines[$n] ) );
			if ( count( $parts ) < 3 ) continue;
			if ( $parts[1] == '$Revision:' )
			{
				$nOrigLin = $n;
				$nOrigRev = (int) $parts[2];
				break;
			}
		}
		if ( $nOrigRev == 0 )
		{
			print "Failed to read original revision: $file1\n";
			continue;
		}
		
		# Translation revision
		
		$nTrnsLin = 0;
		$nTrnsRev = 0;
		
		$lines = file( $file2 );
		for ( $n = 0 ; $n < min( 10 , count( $lines ) ) ; $n++ )
		{
			$parts = explode( ' ' , normalize_space( $lines[$n] ) );
			if ( count( $parts ) < 3 ) continue;
			if ( $parts[1] == 'EN-Revision:' )
			{
				$nTrnsLin = $n;
				$nTrnsRev = $parts[2];
				break;
			}
		}
		
		if ( $nTrnsRev == 'n/a' )
			continue;
		
		$nTrnsRev = (int) $nTrnsRev;
		if ( $nTrnsRev == 0 )
		{
			print "Failed to read translation revision: $file2\n";
			continue;
		}
		
		if ( $nTrnsRev > $nOrigRev )
		{
			print "Translation ahead of original: $file2\n";
			continue;
		}
		
		if ( $nTrnsRev == $nOrigRev )
			continue;
		
		# Compare file contents, sans mutant line
		
		$url = null;
		$lines = explode( "\n" , shell_exec( "/usr/bin/svn info " . $file1 ) );
		foreach ( $lines as $line )
		{
			if ( substr( $line , 0 , 5 ) == "URL: " )
			{
				$url = substr( $line , 5 );
				break;
			}
		}
		if ( $url == null )
		{
			print "Failed to get URL of: $file1\n";
			continue;
		}
		
		$dir = "tmp";
		TmpDirReadKill( $dir );
		shell_exec( "/usr/bin/svn export --non-interactive --revision $nTrnsRev " . escapeshellarg( $url ) . " " . escapeshellarg( $dir ) );
		
		$linesOld = TmpDirReadKill( $dir );
		$linesNew = file( $file1 );
		
		//if ( count( $linesOld ) == 0 )
		//{
		//	print "Failed to get contents of revision $nTrnsRev of: $file1\n";
		//	continue;
		//}
		if ( count( $linesOld ) != count( $linesNew ) )
			continue;
		
		$diff = 0;
		for( $n = 0 ; $n < count( $linesOld ) ; $n++ )
		{
			if ( $n == $nOrigLin )
				continue;
			if( trim( $linesOld[$n] ) == trim( $linesNew[$n] ) )
				continue;
			$diff++;
		}
		
		if ( $diff == 0 )
		{
			print "FILE BUMP $nTrnsRev to $nOrigRev on $file2\n";
			
			$lines = file( $file2 );
			$line = normalize_space( $lines[$nTrnsLin] );
			$parts = explode( ' ' , $line );
			$parts[2] = $nOrigRev;
			$line = implode( ' ' , $parts );
			$lines[$nTrnsLin] = $line;
			file_put_contents( $file2 , $lines );
		}
	}
}

function TmpDirReadKill( $dir )
{
	$lines = [];
	
	if ( ! file_exists( $dir ) )
		mkdir( $dir );
	
	$entrys = scandir( $dir );
	foreach( $entrys as $entry )
	{
		if ( $entry == '.' ) continue;
		if ( $entry == '..' ) continue;
		
		$filename = $dir . DIRECTORY_SEPARATOR . $entry;
		$lines = file( $filename );
		unlink( $filename );
	}
	
	return $lines;
}

function normalize_space( $line )
{
	while ( true )
	{
		$before = strlen( $line );
		
		$line = ltrim( $line );
		$line = str_replace( '  ' , ' ' , $line );
		$after = strlen( $line );
		
		if ( $before == $after )
			return $line;
	}
}
