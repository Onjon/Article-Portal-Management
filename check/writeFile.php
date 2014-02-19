<?php


if( ! isset( $_POST[ 'a' ] ) ) {
	echo "image data not found!" ;	
	exit() ;
}

if( ! isset( $_POST[ 'user_id' ] ) ) {
	echo "user id not found!" ;	
	exit() ;
}

$user_id = $_POST[ 'user_id' ] ;

$arr = array() ;
$brr = array() ;
$cn = 0 ;
$brr[ $cn++ ] = 'a' ;
$brr[ $cn++ ] = 'b' ;
$brr[ $cn++ ] = 'c' ;
$brr[ $cn++ ] = 'd' ;
$brr[ $cn++ ] = 'e' ;
$brr[ $cn++ ] = 'f' ;
$brr[ $cn++ ] = 'g' ;
$brr[ $cn++ ] = 'h' ;
$brr[ $cn++ ] = 'i' ;
$brr[ $cn++ ] = 'j' ;
$brr[ $cn++ ] = 'k' ;
$brr[ $cn++ ] = 'l' ;
$brr[ $cn++ ] = 'm' ;
$brr[ $cn++ ] = 'n' ;
$brr[ $cn++ ] = 'o' ;
$brr[ $cn++ ] = 'p' ;
$brr[ $cn++ ] = 'q' ;
$brr[ $cn++ ] = 'r' ;
$brr[ $cn++ ] = 's' ;
$brr[ $cn++ ] = 't' ;
$brr[ $cn++ ] = 'u' ;
$brr[ $cn++ ] = 'v' ;
$brr[ $cn++ ] = 'w' ;
$brr[ $cn++ ] = 'x' ;
$brr[ $cn++ ] = 'y' ;
$brr[ $cn++ ] = 'z' ;

$j = 0 ;
for( $i = 0 ; $i < sizeof( $brr ) ; $i++ ) {
	if( ! isset( $_POST[ $brr[ $i ] ] ) || ! isset( $_POST[ $brr[ $i ] . "_fileName" ] ) ) {		
		break ;
	}
	$j = $i ;
}
echo "everything ok!" ;

for( $i = 0 ; $i <= $j ; $i++ ) {
	$data =  $_POST[ $brr[ $i ] ] ;
	$fileName =  $_POST[ $brr[ $i ] . "_fileName" ] ;
	$pathToDirectory = "[" . $user_id . "@" . date( 'd-m-Y' ) . "]" ;
	if( ! file_exists( $pathToDirectory ) ) {
		mkdir( $pathToDirectory , 0777 , true ) ;
	}
	$fo = fopen( $pathToDirectory . "/" . $fileName , 'w' ) ;
	$data = rawurldecode( $data ) ;
	fwrite( $fo , base64_decode( $data ) ) ;
	fclose( $fo ) ;
}


?>