<?php

include( 'ArticleStringDataEstimatedMatchingAlgorithm.php' ) ;
include( '../process/processor.php' ) ;

if( ! isset( $_POST[ 'a' ] ) || ! isset( $_POST[ 'b' ] ) || ! isset( $_POST[ 'city' ] ) || ! isset( $_POST[ 'article_id' ] ) ) {
	echo "Parameter Mismatch!" ;
	exit() ;
}

$article = $_POST[ 'a' ] ;
$title = $_POST[ 'b' ] ;
$city = $_POST[ 'city' ] ;
$article_id = $_POST[ 'article_id' ] ;

$asdemsObj = new ArticleStringDataEstimatedMatchingAlgorithm() ;

$pc = new processor() ;
$arr = $pc -> getArticleData() ;

$sz = sizeof( $arr ) ;
for( $i = 0 ; $i < $sz ; $i++ ) {
    if( $arr[ $i ][ 'article_id' ] == $_POST[ 'article_id' ] ) {
        continue ;
    }
	$asdemsObj -> addNewSampleTrainArticle( $arr[ $i ][ 'article_data' ] ) ;
}

$asdemsObj -> breakDownAllToWords() ;
$asdemsObj -> setRunableString( $article ) ;
$res = ( int ) $asdemsObj -> checkTheArticle() ;

if( $res < 80 ) {
	$pc -> updateArticle( $article_id , $article , $title , $city ) ;
	echo "Successfully updated article onto the database!" ;
    echo "<meta HTTP-EQUIV='refresh' content='0;url='>";
}
else {
	echo "Article has failed the designated percentage of unique content comparison test!" ;
}


?>
