<?php
final class GetDocument {
    private $id ;
    private $title ; 
    private $details ; 
    private $city ; 
    private $fl ; 
    
    public function setData( $userIdParam , $dateParam ) {
        $s = mysql_query( "SELECT article_id AS id , article_data AS a , article_title AS b , city AS c FROM article_data WHERE user_id='".$userIdParam."' AND dt = '".$dateParam."' " );
        
        if( mysql_num_rows( $s ) > 0 ) {
            $this -> fl = 1 ;

            $this -> id = array();
            $this -> title = array();
            $this -> details = array();
            $this -> city = array();
            
            while( $f = mysql_fetch_array( $s ) ) {
                $this -> id[] = $f[ 'id' ];
                $this -> title[] = $f[ 'b' ];
                $this -> details[] = $f[ 'a' ];
                $this -> city[] = $f[ 'c' ];
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
    
    public function getTitle() {
        return $this -> title ; 
    }
    
    public function getDetails() {
        return $this -> details ; 
    }
    
    public function getCity() {
        return $this -> city ; 
    }
}
?>