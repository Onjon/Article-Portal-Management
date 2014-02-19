<?php
/**
 * Provides a solution to the problem of 
 * matching the relevancy between articles.
 * Checks whether the article has a significant 
 * amount of similar matches from previously stored articles.
 * @author      S. M. Ijaz-ul-Amin Chowdhury
 * @requires	LongestCommonSubsequence.php
 * @framework	PEIN Framework
 * @license     This program is free software; you can redistribute it and/or
 *              modify it under the terms of the GNU General Public License
 *              as published by the Free Software Foundation; either version 2
 *              of the License, or any later version.
 * 
 *              This program is distributed in the hope that it will be useful,
 *              but WITHOUT ANY WARRANTY; without even the implied warranty of
 *              MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *              GNU General Public License for more details.

 *              You should have received a copy of the GNU General Public License
 *              along with this program; if not, visit the following link to get the 
 *              full citation of the license: http://www.gnu.org/licenses/gpl-2.0.txt
 */

include( 'LongestCommonSubsequence.php' ) ;

final class ArticleStringDataEstimatedMatchingAlgorithm {
    /**
     * Holds the current data string which will be
     * used against all the previously collected dataset
     * to check the similarity.
     * 
     * @access      private
     * @var         string
     */
    private $currentDataString ;
    
	/**
     * Contains list of words that will be filtered out
     * from the given data string. These filters are also 
     * applied the dataset that works as sample dataset
     * for the revelancy checking.
     *
     * @access      private
     * @var         2-dimensional array
     */
    private $filterWordList ;
    
	/**
     * Contains list of delimiters that seperates the sentences
     * in the data string.
     *
     * @access      private
     * @var         array
     */
    private $sentenceDelimiterList ;
	
	private $lcsObj ;
	private $articleList ;
	private $sentenceList ;
	private $wordList ;
	
	private function printArray( $arr ) {
		echo "<pre>" ;
		var_dump( $arr ) ;
		echo "</pre>" ;
	}
    
    public function __construct() {
        $this -> currentDataString = "" ; 
		$this -> lcsObj = new LongestCommonSubsequence() ;	
		$this -> articleList = array() ;
		$this -> sentenceList = array() ;
		$this -> wordList = array() ;
        $this -> initFilterList() ;
    }
	
	public function setRunableString( $currentDataStringParam ) {
        $this -> currentDataString = $currentDataStringParam ;
	}
    
    private function initFilterList() {
        $this -> sentenceDelimiterList = array() ;
		$this -> sentenceDelimiterList[] = '?' ;
        $this -> sentenceDelimiterList[] = ',' ;
        $this -> sentenceDelimiterList[] = ':' ;
        $this -> sentenceDelimiterList[] = '.' ;
        $this -> sentenceDelimiterList[] = ';' ;
		$this -> sentenceDelimiterList[] = '!' ;
        
        $this -> filterWordList = array() ;
        for( $i = 0 ; $i <= 10 ; $i++ ) {
            $this -> filterWordList[] = array() ;
        }
        $this -> filterWordList[ 1 ][] = "i" ;
        $this -> filterWordList[ 2 ][] = "is" ;
        $this -> filterWordList[ 2 ][] = "am" ;
		$this -> filterWordList[ 2 ][] = "he" ;
		$this -> filterWordList[ 3 ][] = "she" ;
        $this -> filterWordList[ 3 ][] = "are" ;
        $this -> filterWordList[ 3 ][] = "the" ;
    }
	
	private function toLowerCase( $arr ) {
		return strtolower( $arr ) ;
	}
	
	private function breakDownArticleToSentence( $arr ) {
		$brr = array() ;
		$localSentence = "" ;
		$len = strlen( $arr ) ;
		$sz = sizeof( $this -> sentenceDelimiterList ) ;
		for( $i = 0 ; $i < $len ; $i++ ) {
			$fl = 0 ;
			for( $j = 0 ; $j < $sz ; $j++ ) {
				if( $arr[ $i ] == $this -> sentenceDelimiterList[ $j ] ) {
					$fl = 1 ;
					break ;
				}
			}
			if( $fl == 0 ) {
				$localSentence .= $arr[ $i ] ;
			}
			else {
				if( strcmp( $localSentence , "" ) != 0 ) {
					$brr[] = $localSentence ;
				}
				$localSentence = "" ;
			}
		}		
		return $brr ;
	}
	
	private function checkWordValidity( $arr ) {
		$len = strlen( $arr ) ;
		for( $i = 0 ; $i < $len ; $i++ ) {
			if( ! ( ( $arr[ $i ] >= 'a' && $arr[ $i ] <= 'z' ) || ( $arr[ $i ] >= 'A' && $arr[ $i ] <= 'Z' ) ) ) {
				return false ;
			}
		}
		return true ;
	}
	
	private function breakDownSentenceToWord( $arr ) {
		$arr .= "." ;
		$len = strlen( $arr ) ;
		$brr = array() ;
		$localWord = "" ;		
		for( $i = 0 ; $i < $len ; $i++ ) {
			if( ( $arr[ $i ] >= 'a' && $arr[ $i ] <= 'z' ) || ( $arr[ $i ] >= 'A' && $arr[ $i ] <= 'Z' ) ) {
				$localWord .= $arr[ $i ] ;
			}
			else {
				$localWord = $this ->toLowerCase( $localWord ) ;
				if( strcmp( $localWord , "" ) != 0 && $this -> checkWordValidity( $localWord ) == true ) {									
					$fl = 1 ;
					if( isset( $this -> filterWordList[ strlen( $localWord ) ] ) == true ) {						
						$sz = sizeof( $this -> filterWordList[ strlen( $localWord ) ] ) ;
						for( $j = 0 ; $j < $sz ; $j++ ) {
							if( strcmp( $this -> filterWordList[ strlen( $localWord ) ][ $j ] , $localWord ) == 0 ) {
								$fl = 0 ;
								break ;
							}
						}						
					}
					if( $fl == 1 ) {
						$brr[] = $localWord ;
					}
				}
				$localWord = "" ;
			}
		}		
		return $brr ;
	}
	
	private function stripQuotationAndAddDelimeterAtTheEnd( $arr ) {
		$len = strlen( $arr ) ;
		$brr = "" ;
		for( $i = 0 ; $i < $len ; $i++ ) {
			if( $arr[ $i ] == '"' || $arr[ $i ] == '\'' ) {				
			}
			else {
				$brr .= $arr[ $i ] ;
			}			
		}
		$brr .= "." ;
		return $brr ;
	}
	
	public function addNewSampleTrainArticle( $arr ) {
		$arr = $this -> stripQuotationAndAddDelimeterAtTheEnd( $arr ) ;
		$this -> articleList[] = $arr ;
		$this -> sentenceList[] = array() ;
		$idx = sizeof( $this -> sentenceList ) - 1 ;
		$brr = $this -> breakDownArticleToSentence( $arr ) ;
		$sz = sizeof( $brr ) ;
		for( $i = 0 ; $i < $sz ; $i++ ) {
			$this -> sentenceList[ $idx ][] = $brr[ $i ] ;
		}	
	}
	
	public function breakDownAllToWords() {
		$this -> wordList = array() ;
		$sz1 = sizeof( $this -> articleList ) ;
		for( $i = 0 ; $i < $sz1 ; $i++ ) {
			$this -> wordList[] = array() ;			
			$sz2 = sizeof( $this -> sentenceList[ $i ] ) ;
			for( $j = 0 ; $j < $sz2 ; $j++ ) {
				$this -> wordList[ $i ][] = array() ;
				$arr = $this -> breakDownSentenceToWord( $this -> sentenceList[ $i ][ $j ] ) ;
				$sz3 = sizeof( $arr ) ;
				for( $k = 0 ; $k < $sz3 ; $k++ ) {
					$this -> wordList[ $i ][ $j ][] = $arr[ $k ] ;
				}				
			}
		}		
		//$this -> printArray( $this -> wordList ) ;
	}
	
	private function generateTwoIntegerArrayFromTwoWordArrays( $arr , $brr ) {
		$cn = 1 ;
		$sz1 = sizeof( $arr ) ;
		$sz2 = sizeof( $brr ) ;
		$crr = array() ;
		$drr = array() ;
		$err = array() ;
		$frr = array() ;
		//$arr is the main string and $brr is the to run string
		for( $i = 0 ; $i < $sz1 ; $i++ ) {
			$fl = 0 ;
			for( $j = 0 ; $j < $i ; $j++ ) {
				if( strcmp( $arr[ $i ] , $arr[ $j ] ) == 0 ) {
					$fl = 1 ;
					break ;
				}
			}
			if( $fl == 0 ) {
				$crr[] = $arr[ $i ] ;
				$drr[] = $cn++ ;
			}
		}
		$sz1 = sizeof( $crr ) ;
		for( $i = 0 ; $i < $sz2 ; $i++ ) {
			$fl = -1 ;
			for( $j = 0 ; $j < $sz1 ; $j++ ) {
				if( strcmp( $crr[ $j ] , $brr[ $i ] ) == 0 ) {
					$fl = $j ;
					break ;
				}
			}
			if( $fl == -1 ) {
				$err[] = $cn ;
			}
			else {
				$err[] = $drr[ $fl ] ;
			}
		}
		$frr[] = $drr ;
		$frr[] = $err ;
		return $frr ;
	}
    
    public function checkTheArticle() {		
		$maximumMatchPercentage = 0.00 ;
		$checkAgainstString = $this -> stripQuotationAndAddDelimeterAtTheEnd( $this -> currentDataString ) ;
		$brr = $this -> breakDownArticleToSentence( $checkAgainstString ) ;
        $sz1 = sizeof( $this -> articleList ) ;
		$sz3 = sizeof( $brr ) ;
		$overallMaxPercentage = 0.0 ;
		for( $i = 0 ; $i < $sz1 ; $i++ ) {//list of total articles		
			$sz2 = sizeof( $this -> sentenceList[ $i ] ) ;			
			$sumOfPercentage = 0.0 ;
			for( $k = 0 ; $k < $sz3 ; $k++ ) {//list of sentences of 'on check against' article				
				$crr = $this -> breakDownSentenceToWord( $brr[ $k ] ) ;
				$res = 0 ;
				for( $j = 0 ; $j < $sz2 ; $j++ ) {//list of sentences of each article					
					$drr = $this -> generateTwoIntegerArrayFromTwoWordArrays( $this -> wordList[ $i ][ $j ] , $crr ) ;
					$this -> lcsObj -> addFirstArray( $drr[ 0 ] ) ;
					$this -> lcsObj -> addSecondArray( $drr[ 1 ] ) ;
					$r1 = $this -> lcsObj -> runLcs() ;
					$res = max( $res , $r1 ) ;
				}
				$localPercentage = ( $res / sizeof( $crr ) ) * 100.0 ;
				$sumOfPercentage += $localPercentage ;
            }
			$averagePercentage = $sumOfPercentage / $sz3 ;
			$overallMaxPercentage = max( $overallMaxPercentage , $averagePercentage ) ;			
        }
		return $overallMaxPercentage ;
    }
}


/**
 * Sample usage description:
 * 


$asdemsObj = new ArticleStringDataEstimatedMatchingAlgorithm() ;
$asdemsObj -> addNewSampleTrainArticle( "hello, how are you?  hope it is good." ) ;
$asdemsObj -> addNewSampleTrainArticle( "good day to you sir." ) ;
$asdemsObj -> addNewSampleTrainArticle( "nice weather." ) ;
$asdemsObj -> breakDownAllToWords() ;
$asdemsObj -> setRunableString( "first day to you sir of your life!" ) ;
echo ( int ) $asdemsObj -> checkTheArticle() ;

 
*/
?>