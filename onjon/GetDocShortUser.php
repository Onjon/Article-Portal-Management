<?php
final class GetDocShortUser {
    private $id ; 
    private $dt ; 
    private $total ; 
    private $fl ; 
    
    public function __CONSTRUCT( $userIdParam ) {
        $s = mysql_query( "SELECT dt AS a , COUNT(article_id) AS b FROM article_data WHERE user_id='".$userIdParam."' GROUP BY dt ORDER BY a DESC " );
        if( mysql_num_rows( $s ) >= 1 ) {
            $this -> fl = 1 ; 
            
            $this -> dt = array();
            $this -> total = array();
            
            while( $f = mysql_fetch_array( $s ) ) {
                $this -> dt[] = $f[ 'a' ];
                $this -> total[] = $f[ 'b' ];
            }
        }
        else {
            $this -> fl = 0 ; 
        }
    }
    
    public function getResult() {
        return $this -> fl ; 
    }
    
    public function getDT() {
        return $this -> dt ; 
    }
    
    public function getTotal() {
        return $this -> total ; 
    }
    
}
?>