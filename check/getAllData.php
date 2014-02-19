<?php

include( '../process/processor.php' ) ;

$pc = new processor() ;
$arr = $pc -> getArticleData() ;

$sz = sizeof( $arr ) ;
$brr = array() ;
for( $i = 0 ; $i < $sz ; $i++ ) {
	$crr = array() ;
	if( ! isset( $arr[ $i ][ 1 ] ) || ! isset( $arr[ $i ][ 2 ] ) || $arr[ $i ][ 2 ] == '' || $arr[ $i ][ 1 ] == '' ) {
		continue ;
	}
	$crr[] = $arr[ $i ][ 1 ] ;
	$crr[] = $arr[ $i ][ 2 ] ; 
	$brr[] = $crr ;
}

echo json_encode( $brr ) ;

?>