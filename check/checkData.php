<?php

include( 'ArticleStringDataEstimatedMatchingAlgorithm.php' ) ;
include( '../process/processor.php' ) ;

if( ! isset( $_POST[ 'a' ] ) || ! isset( $_POST[ 'b' ] ) || ! isset( $_POST[ 'city' ] ) ) {
	echo "Parameter Mismatch!" ;
	exit() ;
}

$article = $_POST[ 'a' ] ;
$title = $_POST[ 'b' ] ;
$city = $_POST[ 'city' ] ;

$asdemsObj = new ArticleStringDataEstimatedMatchingAlgorithm() ;

$pc = new processor() ;
$arr = $pc -> getArticleData() ;

$sz = sizeof( $arr ) ;
for( $i = 0 ; $i < $sz ; $i++ ) {
	$asdemsObj -> addNewSampleTrainArticle( $arr[ $i ][ 'article_data' ] ) ;
}

$asdemsObj -> breakDownAllToWords() ;
$asdemsObj -> setRunableString( $article ) ;
$res = ( int ) $asdemsObj -> checkTheArticle() ;

if( $res < 80 ) {
	$pc -> insertArticle( $article , $title , $city ) ;
	echo "Successfully added article onto the database!" ;
    // echo "<meta HTTP-EQUIV='refresh' content='0;url='>";
}
else {
	echo "Article has failed the designated percentage of unique content comparison test!" ;
}


?>