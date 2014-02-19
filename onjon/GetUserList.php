<?php
final class GetUserList {
    private $id ; 
    private $name ; 
    private $email ;
    private $rate ;
    private $fl ;
    
    public function __CONSTRUCT() {
        $s = mysql_query( "SELECT id AS a ,fname AS b , lname AS c , email AS d , rate AS e FROM tbl_user " );
        if( mysql_num_rows( $s ) >= 1 ) {
            $this -> fl = 1 ;
            
            $this -> id = array();
            $this -> name = array();
            $this -> email = array();
            $this -> rate = array();
            
            while( $f = mysql_fetch_array( $s ) ) {
                $this -> id[] = $f[ 'a' ];
                $this -> name[] = $f[ 'b' ] . " " . $f[ 'c' ] ;
                $this -> email[] = $f[ 'd' ];
                $this -> rate[] = $f[ 'e' ];
            }
            
        }
        else {
            $this -> fl = 0 ; 
        }
    }
    
    public function getResult() {
        return $this -> fl ; 
    }
    
    public function getId() {
        return $this -> id ; 
    }
    
    public function getName() {
        return $this -> name ;
    }
    
    public function getEmail() {
        return $this -> email ;
    }
    
    public function getRate() {
        return $this -> rate ; 
    }
}
?>