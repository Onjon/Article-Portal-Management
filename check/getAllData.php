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
    if( isset( $_POST[ 'a' ] ) && isset( $_POST[ 'b' ] ) ) {
        if( $_POST[ 'a' ] == $arr[ $i ][ 1 ] && $_POST[ 'b' ] == $arr[ $i ][ 2 ] ) {
            continue ;
        }
        if( $_POST[ 'a' ] == $arr[ $i ][ 2 ] && $_POST[ 'b' ] == $arr[ $i ][ 1 ] ) {
            continue ;
        }
    }
	$crr[] = $arr[ $i ][ 1 ] ;
	$crr[] = $arr[ $i ][ 2 ] ; 
	$brr[] = $crr ;
}

echo json_encode( $brr ) ;

?>