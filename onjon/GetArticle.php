<?php
final class GetArticle {

    public static function getTotalArticle( $a ) {
        $s = mysql_query( "SELECT article_id FROM article_data WHERE user_id='".$a."' " );
        $res = mysql_num_rows( $s );
        return $res ; 
    }
    
    public static function getTodaysArticle( $a ) {
        $today = date( "Y-m-d" );
        $s = mysql_query( "SELECT article_id FROM article_data WHERE user_id='".$a."' AND dt='".$today."' " );
        $res = mysql_num_rows( $s );
        return $res ; 
    }
    
}
?>