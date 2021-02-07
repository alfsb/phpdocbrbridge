<?php

error_reporting ( E_ALL );
ini_set( 'display_errors' , TRUE );

set_error_handler( function( $errno , $errstr , $errfile , $errline , array $errcontext )
{
    if ( 0 === error_reporting() ) { return false; }
    throw new ErrorException( $errstr , 0 , $errno , $errfile , $errline );
} );

