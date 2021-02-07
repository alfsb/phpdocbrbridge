<?php

require_once dirname( __FILE__ ) . '/SvnUtil.php';

if ( count ( $argv ) < 3 )
{
	print "Use: " . $argv[0] . " diff_path repo_dir [strip]\n";
	return -1;
}

SvnUtil::$Verbose = true;

$diff = $argv[1];
$repo = $argv[2];
$strp = isset( $argv[3] ) ? (int) $argv[3] : 0;

$tmpfile = getcwd() . "/diff.tmp";

$stat = SvnUtil::Status( $repo );
if ( count( $stat->Files ) > 0 )
{
	print "Repositório local modificado, impossível continuar (status com " . count( $stat->Files ) . " registros).\n\n";
	die( 1 );
}

print "Download $diff\n";
{
	$curl = curl_init();
	curl_setopt( $curl , CURLOPT_AUTOREFERER , TRUE );
	curl_setopt( $curl , CURLOPT_HEADER , 0 );
	curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 ) ;
	curl_setopt( $curl , CURLOPT_URL , $diff );
	curl_setopt( $curl , CURLOPT_FOLLOWLOCATION , TRUE );
	$contents = curl_exec( $curl );
	curl_close( $curl );
	file_put_contents( $tmpfile , $contents );
}

print "Patch\n";
{
	$old = getcwd();
	chdir( $repo );

	$cmd = "/usr/bin/svn patch --strip " . $strp . " " . escapeshellarg( $tmpfile ) ;
	$out = array();
	$ext = -1;
	exec( $cmd , $out , $ext );

	chdir( $old );

	if ( $ext != 0 )
	{
		SvnUtil::CleanUp( $repo );
		SvnUtil::Revert( $repo );

		print "Falha de aplicação do patch [$ext]:\n\n";
		foreach( $out as $o ) print "> $o\n";
		print "\n";
		die ( 1 );
	}
}
unlink( $tmpfile );

print "Status\n";

$stat = SvnUtil::Status( $repo );
if ( count( $stat->Files ) == 0 )
{
	print "No modified.";
}
else
{
	passthru( "/usr/bin/svn status " . escapeshellarg( $repo ) );
}

print "\n";

