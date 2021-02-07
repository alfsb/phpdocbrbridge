<?php

require_once dirname( __FILE__ ) . '/SvnUtil.php';

if ( count ( $argv ) < 3 )
{
    print "Use: " . $argv[0] . " source_path dest_path\n";
    return -1;
}

SvnUtil::$Verbose = true;

$srce = $argv[1];
$dest = $argv[2];

SvnUtil::LogDebug( "autosync $srce -> $dest" );

$revLocal = SvnUtil::InfoSummary( $srce );
$revRepo =  SvnUtil::InfoSummary( $revLocal->Url );

if ( $revLocal->Revision > $revRepo->Revision )
    throw new Exception( "Local revision ahead of repository: " . $revLocal->Revision . " vs " . $revRepo->Revision . "." );

if ( $revLocal->Revision == $revRepo->Revision )
{
    SvnUtil::LogDebug( "No new revisions to synchronize.");
    diffPaths( $srce , $dest );
    finalize( 0 );
}

// Generate dest, diff from srce, apply on dest

$diff = SvnUtil::DiffContents( $srce , $revLocal->Revision , $revRepo->Revision );

if ( filesize( $diff ) == 0 )
{
    SvnUtil::LogDebug( "Nothing to transport, only update." );
    SvnUtil::Update( $srce , $revRepo->Revision );
    diffPaths( $srce , $dest );
    finalize( 0 );
}

try
{
    SvnUtil::$Verbose = true;
    SvnUtil::Update( $dest );
    SvnUtil::Patch( $dest , $diff );
    SvnUtil::Commit( $dest , AUTO_SYNC_MESSAGE );
    SvnUtil::Update( $srce , $revRepo->Revision );

    SvnUtil::LogDebug( "" );
    diffPaths( $srce , $dest );
    finalize( 0 );
}
catch ( Exception $e )
{
    print $e->getTraceAsString() . "\n\n";

    SvnUtil::CleanUp( $dest );
    SvnUtil::Revert( $dest , true );

    finalize( -1 );
}

function diffPaths( $source , $dest )
{
    $cmd = '/usr/bin/diff -r --exclude=".svn" --exclude="README.md" ' . escapeshellarg( $source ) . " " . escapeshellarg( $dest );
    $diff = shell_exec( $cmd );
    $diff = trim( $diff );
    if ( $diff != "" )
    {
        print "Differences:\n";
        print $diff . "\n";
        print "---\n";
    }
    else
        SvnUtil::LogDebug( "No residual file differences." );
}

function finalize( $returnCode )
{
    global $diff; if ( file_exists( $diff ) ) unlink( $diff );
    print "\n";
    exit ( 0 );
}

exit ( -2 );
