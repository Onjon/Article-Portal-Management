<?php
final class GetUserName {
    public static function getName( $a ) {
        $s = mysql_query( "SELECT fname AS a , lname AS b FROM tbl_user WHERE id='".$a."' " );
        if( mysql_num_rows( $s ) == 1 ) {
            $f = mysql_fetch_array( $s );
            $res = $f[ 'a' ] . " " . $f[ 'b' ] ;
        }
        else {
            $res = "Unknown" ;
        }
        return $res ; 
    }
}
?>