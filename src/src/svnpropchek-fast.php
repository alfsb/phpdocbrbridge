<?php

if ( count ( $argv ) < 2 )
{
	print "Use: " . $argv[0] . " path\n";
	return -1;
}

$path = $argv[1];

$cmd = '/usr/bin/svn proplist -R ' . escapeshellarg( $path );
$out = shell_exec( $cmd );
$lines = explode( "\n" , $out );

$filename = "";
$props = [];

foreach ( $lines as $line )
{
    if ( strlen( $line ) == 0 ) continue;
    
    if ( $line[0] != ' ' )
    {
        CheckProps( $filename , $props );
        
        $pos = strpos( $line , "'" );
        $filename = substr( $line , $pos + 1 );
        $filename = substr( $filename , 0, strlen( $filename ) -1 );
        $props = [];
    }
    else
    {
        $props[] = trim( $line );
    }
}

function CheckProps( $filename , $props )
{
    if ( substr( $filename , -4 ) != '.xml' )
        return;
    
    //echo "# $filename\n";
    
    if ( in_array( "svn:eol-style" , $props ) == false )
        echo "svn propset svn:eol-style 'native' $filename\n";
    
    if ( in_array( "svn:keywords" , $props ) == false )
        echo "svn propset svn:keywords 'Revision' $filename\n";
}
