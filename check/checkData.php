<?php

include( 'ArticleStringDataEstimatedMatchingAlgorithm.php' ) ;
include( '../process/processor.php' ) ;

if( ! isset( $_POST[ 'a' ] ) || ! isset( $_POST[ 'b' ] ) ) {
	echo "Parameter Mismatch!" ;
	exit() ;
}

$article = $_POST[ 'a' ] ;
$title = $_POST[ 'b' ] ;

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
	$pc -> insertArticle( $article , $title ) ;
	echo "Successfully added article onto the database!" ;
}
else {
	echo "Article has failed the designated percentage of unique content comparison test!" ;
}


?>