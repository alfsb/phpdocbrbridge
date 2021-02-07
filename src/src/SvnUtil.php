<?php

require_once dirname( __FILE__ ) . '/console-strict-errors.php';

define( "AUTO_SYNC_MESSAGE" , "Automatic synchronization (bridge)" );

class SvnUtil
{
	static $Verbose = false;

	static function Checkout( $url , $path )
	{
		$cmd = "/usr/bin/svn checkout " . escapeshellarg( $url ) . " " . escapeshellarg( $path );

		$ret = self::Execute( $cmd );
		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );
	}

	static function InfoSummary( $path )
	{
		$cmd = "/usr/bin/svn info --config-option servers:global:http-timeout=60000 --xml " . escapeshellarg( $path );
		$xml = shell_exec( $cmd );
		$xml = simplexml_load_string( $xml );

		$ret = new StdClass;
		$ret->Revision = $xml->entry['revision']->__toString();
		$ret->Url =      $xml->entry->url->__toString();

		return $ret;
	}

	static function Status( $path )
	{
		$cmd = "/usr/bin/svn status --xml " . escapeshellarg( $path );
		$xml = shell_exec( $cmd );
		$xml = simplexml_load_string( $xml );

		$ret = new StdClass;
		$ret->Files = array();

		$target = isset( $xml->target ) ? $xml->target : array();
		foreach ( $target->entry as $entry )
		{
			$file = new StdClass;
			$file->Path = $entry['path']->__toString();
			$ret->Files[] = $file;
		}

		return $ret;
	}

	static function MessageOfRevision( $url , $revision )
	{
		$cmd = "/usr/bin/svn log --xml --verbose --revision $revision " . escapeshellarg( $url );
		$xml = shell_exec( $cmd );
		$xml = simplexml_load_string( $xml );

		if ( ! isset( $xml->logentry[0] ) )
			return null;

		return $xml->logentry[0]->msg->__toString();
	}

	static function Diff( $path , $revPrev , $revNext )
	{
		$old = getcwd();
		chdir( $path );

		$out = $old . "/" . self::FlatFileNameOfPath( $path ) . "_{$revPrev}_{$revNext}.diff";

		$cmd = "/usr/bin/svn diff --revision $revPrev:$revNext > $out";
		$ret = self::Execute( $cmd );
		chdir( $old );

		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );

		return $out;
	}

	static function DiffContents( $path , $revPrev , $revNext )
	{
		$old = getcwd();
		chdir( $path );

		$out = $old . "/" . self::FlatFileNameOfPath( $path ) . "_{$revPrev}_{$revNext}.diff";

		$cmd = "/usr/bin/svn diff --patch-compatible --revision $revPrev:$revNext > $out";
		$ret = self::Execute( $cmd );
		chdir( $old );

		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );

		return $out;
	}

	static function DiffSummary( $path , $revPrev , $revNext )
	{
		$old = getcwd();
		chdir( $path );

		$out = $old . "/" . self::FlatFileNameOfPath( $path ) . "_{$revPrev}_{$revNext}.summary";
		$cmd = "/usr/bin/svn diff --summarize --revision $revPrev:$revNext > $out";
		$ret = self::Execute( $cmd );
		chdir( $old );

		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );

		return $out;
	}

	static function Update( $path , $revision = 0 )
	{
		$cmd = "/usr/bin/svn update " . ( $revision != 0 ? "--revision $revision " : "" ) . escapeshellarg( $path ) . " 2>&1";
		$ret = self::Execute( $cmd );
		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );
	}

	static function Patch( $path , $diffFile )
	{
		$old = getcwd(); chdir( $path );

		$cmd = "/usr/bin/svn --non-interactive patch " . escapeshellarg( $diffFile );
		$ret = self::Execute( $cmd );
		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );

		chdir( $old );
	}

	static function Commit( $path , $message = "" )
	{
		$cmd = "/usr/bin/svn --non-interactive commit --message " . escapeshellarg( $message ) . " " . escapeshellarg( $path );
		$ret = self::Execute( $cmd );
		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );
	}

	static function CleanUp( $path )
	{
		$cmd = "/usr/bin/svn --non-interactive cleanup " . escapeshellarg( $path );
		$ret = self::Execute( $cmd );
		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );
	}

	static function Revert( $path , $recurse = false )
	{
		if ( $recurse ) $recurse = ' --recursive ';

		$cmd = "/usr/bin/svn --non-interactive revert $recurse " . escapeshellarg( $path );
		$ret = self::Execute( $cmd );
		if ( $ret != 0 )
			throw new Exception( "[$ret] $cmd\n" );
	}

	static function FlatFileNameOfPath( $path )
	{
		$path = trim( $path );
		$path = trim( $path , "\\/" );
		$path = str_replace( "\\" , '_' , $path );
		$path = str_replace( "/" , '_' , $path );
		return $path;
	}

	static function Execute( $cmd )
	{
		$ret = 0;

		if ( self::$Verbose )
		{
			print $cmd . "\n";
			passthru( $cmd , $ret );
			if ( $ret != 0 )
				print "[$ret] $cmd\n";
		}
		else
		{
			passthru( $cmd , $ret );
		}

		return $ret;
	}

	static function LogDebug( $message )
	{
		if ( self::$Verbose )
		{
			print $message . "\n";
		}
	}
}
