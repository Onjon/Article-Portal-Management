<?php
final class GetDocumentSingles {
    private $user_id ;
    private $title ; 
    private $details ; 
    private $city ; 
    private $fl ; 
    
    public function setData( $articleIdParam ) {
        $s = mysql_query( "SELECT user_id , article_data AS a , article_title AS b , city AS c FROM article_data WHERE article_id='".$articleIdParam."' " );
        
        if( mysql_num_rows( $s ) > 0 ) {
            $this -> fl = 1 ;

            $f = mysql_fetch_array( $s );
            $this -> user_id = $f[ 'user_id' ];
            $this -> title = $f[ 'b' ];
            $this -> details = $f[ 'a' ];
            $this -> city = $f[ 'c' ];
        }
        else {
            $this -> fl = 0 ; 
        }
    }
    
    public function getResult() {
        return $this -> fl ; 
    }
    
    public function getUserId() {
        return $this -> user_id ; 
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