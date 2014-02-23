<?php
final class GetCityName {
    public static function getCity() {
        $res = array();
        $s = mysql_query( "SELECT city_name AS a FROM us_city_info ORDER BY a ASC " );
        if( mysql_num_rows( $s ) >= 1 ) {
            $res[ 0 ][] = 1 ; 
            while( $f = mysql_fetch_array( $s ) ) {
                $res[ 1 ][] = $f[ 'a' ] ; 
            }
        }
        else {
            $res[ 0 ][] = 0 ; 
            $res[ 1 ][] = "" ; 
        }
        return $res ; 
    }
    
    public static function getSelectedCity( $cityParam , $userIdParam ) {
        $s = mysql_query( "SELECT article_id FROM article_data WHERE dt='".date('Y-m-d')."' AND user_id='".$userIdParam."' AND city='".$cityParam."' " );
        if( mysql_num_rows( $s ) >= 1 ) {
             // Skip 
            return 1 ; 
        }
        else {
            // Okay 
            return 0 ; 
        }
    }
    
    public static function getSelectedCityUpdate ( $cityParam , $userIdParam , $articleIdParam ) {
        $s = mysql_query( "SELECT article_id FROM article_data WHERE dt='".date('Y-m-d')."' AND user_id='".$userIdParam."' AND city='".$cityParam."' AND article_id <> '".$articleIdParam."' " );
        if( mysql_num_rows( $s ) >= 1 ) {
             // Skip 
            return 1 ; 
        }
        else {
            // Okay 
            return 0 ; 
        }
    }
    
    public static function getTotalArticle( $userIdParam ) {
        $s = mysql_query( "SELECT COUNT(article_id) AS a FROM article_data WHERE dt='".date('Y-m-d')."' AND user_id='".$userIdParam."' " );
        $f = mysql_fetch_array( $s );
        return $f[ 'a' ];
    }

}
?>