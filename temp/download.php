<?php
/*
@Author Name : Onjon Shahadat Hossain and S. M. Ijaz-ul-Amin Chowdhury
@Email : onjon_sh@yahoo.com

@Project Name : Download Folder AS zip
@Version : 1.0.1
@Release Date : 18th February, 2014
*/ 


if( !isset( $_GET[ 'file_name' ] ) ) {
    exit();
}
if( empty( $_GET[ 'file_name' ] ) ) {
    exit();
}
function getNewFolderName( $arr ) {
    $len = strlen( $arr ) ;
    $j = 0 ;
    for( $i = 1 ; $i < $len ; $i++ ) {
        if( $arr[ $i ] == '@' ) {
            break ;
        }
        $j = $i ;
    }
    $crr = "" ;
    for( $i = 1 ; $i <= $j ; $i++ ) {
        $crr .= $arr[ $i ] ;
    }
    $brr = "" ;
    for( $i = $j + 1 ; $i < $len ; $i++ ) {
        $brr .= $arr[ $i ] ;
    }
    $zrr = get_included_files() ;
    $fl = 0 ;
    $zz = 'processor.php' ;
    for( $i = 0 ; $i < sizeof( $zrr ) ; $i++ ) {
        if( $zrr == $zz ) {
            $fl = 1 ;
            break ;
        }
    }
    if( $fl == 0 ) {
        require_once("../process/" . $zz);
    }
    $prObj = new processor() ;
    $grr = $prObj -> getUserName( $crr ) ;
    return "[" . $grr[ 0 ] . $brr ;
}

function dipa( $a ) {
    $b = "" ;
    for( $i = 0 ; $i < strlen( $a ); $i++ ) {
        if( $a[ $i ] == " " ) {
            $b .= "-" ;
        }
        else {
            $b .= $a[ $i ];
        }
    }
    return $b ; 
}


$fileParam = base64_decode( $_GET[ 'file_name' ] );
$newFileName = dipa( getNewFolderName( $fileParam ) );

// Check File Exists 
if( file_exists( $fileParam ) ) {
// Start Download 
    header('Cache-Control: public' );
    header('Content-Description: File Transfer' );
    header('Content-Type: application/force-download');
    header('Content-Type: application/zip');
    header("Content-Disposition: attachment; filename={$newFileName}" );
    header('Content-Transfer-Encoding: binary' );
    ob_clean();
    flush();
    if( readfile( $fileParam ) ) {
        // Remove temp file 
        unlink( $fileParam );
        header( "Location: ../index.php" );
        exit();
    }
    else {
        die( "Could not download the File!!!" );
    }
// End Download 
}
else {
    die( "File Doesn't Exist!!!" );
}
?>