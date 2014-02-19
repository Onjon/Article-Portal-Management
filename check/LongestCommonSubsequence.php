<?php

final class LongestCommonSubsequence {
	private $arr , $brr , $lim , $memo , $done , $cc , $len1 , $len2 ;
	
	public function __construct() {
		$this -> lim = 800 ;
		$this -> cc = 1 ;
		$this -> memo = array() ;
		$this -> done = array() ;
		$this -> initArrays() ;
	}
	
	private function initArrays() {
		for( $i = 0 ; $i < $this -> lim ; $i++ ) {
			$this -> memo[ $i ] = array() ;
			$this -> done[ $i ] = array() ;
			for( $j = 0 ; $j < $this -> lim ; $j++ ) {
				$this -> memo[ $i ][] = 0 ;
				$this -> done[ $i ][] = 0 ;
			}
		}
	}
	
	public function addFirstString( $arrParam ) {
		$this -> arr = $arrParam ;
		$this -> len1 = strlen( $this -> arr ) ;
	}
	
	public function addFirstArray( $arrParam ) {
		$this -> arr = $arrParam ;
		$this -> len1 = sizeof( $this -> arr ) ;
	}
	
	public function addSecondString( $arrParam ) {
		$this -> brr = $arrParam ;
		$this -> len2 = strlen( $this -> brr ) ;
	}
	
	public function addSecondArray( $arrParam ) {
		$this -> brr = $arrParam ;
		$this -> len2 = sizeof( $this -> brr ) ;
	}
	
	private function dp( $i , $j ) {
		if( $i >= $this -> len1 || $j >= $this -> len2 ) {
			return 0 ;
		}
		$res = $this -> memo[ $i ][ $j ] ;
		$re = $this -> done[ $i ][ $j ] ;
		if( $re == $this -> cc ) {
			return $res ;
		}
		$this -> done[ $i ][ $j ] = $this -> cc ;
		$res = 0 ;		
		if( $this -> arr[ $i ] == $this -> brr[ $j ] ) {
			$r1 = $this -> dp( $i + 1 , $j + 1 ) + 1 ;
			$res = max( $r1 , $res ) ;
		}
		$r1 = $this -> dp( $i + 1 , $j ) ;
		$res = max( $r1 , $res ) ;
		$r1 = $this -> dp( $i , $j + 1 ) ;
		$res = max( $r1 , $res ) ;
		$this -> memo[ $i ][ $j ] = $res ;
		return $res ;
	}
	
	public function runLcs() {
		$this -> cc++ ;
		$res = $this -> dp( 0 , 0 ) ;
		return $res ;
	}
}

/**
*	Sample Usage:

$str1 = "dip" ;
$str2 = "asipdyyyz" ;
$lcsObj = new LongestCommonSubsequence() ;
$lcsObj -> addFirstString( $str1 ) ;
$lcsObj -> addSecondString( $str2 ) ;
$res = $lcsObj -> runLcs() ;

echo "<pre>" ;
echo $res ;
echo "</pre>" ;

*/
?>