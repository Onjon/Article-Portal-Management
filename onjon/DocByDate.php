<?php
final class DocByDate {
    private $total ; 
    private $user_id ; 
    private $fl ; 
    
    public function __CONSTRUCT( $dateParam ) {
        $s = mysql_query( "SELECT COUNT(article_id) AS a , user_id AS d FROM article_data WHERE dt = '".$dateParam."' GROUP BY user_id" );
        
        if( mysql_num_rows( $s ) > 0 ) {
            $this -> fl = 1 ;

            $this -> total = array();
            $this -> user_id = array();
            
            while( $f = mysql_fetch_array( $s ) ) {
                $this -> total[] = $f[ 'a' ];
                $this -> user_id[] = $f[ 'd' ];
            }
        }
        else {
            $this -> fl = 0 ; 
        }
    }
    
    public function getResult() {
        return $this -> fl ; 
    }
    
    public function getTotal() {
        return $this -> total ; 
    }
    
    public function getUserId() {
        return $this -> user_id ; 
    }
}
?>