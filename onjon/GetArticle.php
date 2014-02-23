<?php
final class GetArticle {
    
    // Users Total Articles 
    public static function getTotalArticle( $a ) {
        $s = mysql_query( "SELECT article_id FROM article_data WHERE user_id='".$a."' " );
        $res = mysql_num_rows( $s );
        return $res ; 
    }
    
    
    // Users Today's Articles 
    public static function getTodaysArticle( $a ) {
        $today = date( "Y-m-d" );
        $s = mysql_query( "SELECT article_id FROM article_data WHERE user_id='".$a."' AND dt='".$today."' " );
        $res = mysql_num_rows( $s );
        return $res ; 
    }
    
    // Users This Months Articles 
    public static function getMonthlyArticles( $a ) {
        $thisMonth = date( "Y-m" );
        $s = mysql_query( "SELECT article_id FROM article_data WHERE user_id='".$a."' AND dt LIKE '%".$thisMonth."%' " );
        $res = mysql_num_rows( $s );
        return $res; 
    }
    
    // Users Total Article By Search Result 
    public static function getSearchArticles( $a , $b , $c ) {
        $s = mysql_query( "SELECT article_id FROM article_data WHERE user_id='".$a."' AND dt >= '".$b."' AND dt <= '".$c."' " );
        $res = mysql_num_rows( $s );
        return $res ; 
    }
    
}
?>