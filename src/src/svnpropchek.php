<?php

function ScanRecurse( $path )
{
    $dirs = [];
    $files = [];
    
    if ( is_dir( $path ) )
        $dirs[] = $path;
    else
        $files[] = $path;
    
    for ( $n = 0 ; $n < count( $dirs ) ; $n++ )
    {
        $dir = $dirs[$n];
        $entrys = scandir( $dir );
        foreach( $entrys as $entry )
        {
            if ( $entry[0] == "." )
                continue;
            
            $path = realpath( $dir . DIRECTORY_SEPARATOR . $entry );
            if ( is_dir( $path ) )
            {
                $dirs[] = $path;
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
    
    foreach( $files as $filename )
    {
        SvnPropCheckDel( $filename , 'svn:mime-type', 'application/xml' );
        SvnPropCheckSet( $filename , 'svn:eol-style', 'native' );
        SvnPropCheckSet( $filename , 'svn:keywords', 'Id Rev Revision Date LastChangedDate LastChangedRevision Author LastChangedBy HeadURL URL' );
    }
}

function SvnPropCheckDel( $filename , $property , $value )
{
    $out = trim( shell_exec( "/usr/bin/svn propget $property " . escapeshellarg( $filename ) ) );
    
    if ( $out != $value )
        return;
    
    //print "# $property '$value' -> '' (DELETE)\n";
    print "svn propdel $property $filename\n";
}

function SvnPropCheckSet( $filename , $property , $value )
{
    $out = trim( shell_exec( "/usr/bin/svn propget $property " . escapeshellarg( $filename ) ) );
    
    if ( $out == $value )
        return;
    
    //print "# $property '$out' -> '$value'\n";
    print "svn propset $property '$value' $filename\n";
}

if ( count ( $argv ) < 2 )
{
	print "Use: " . $argv[0] . " path\n";
	return -1;
}

ScanRecurse( $argv[1] );
return;
