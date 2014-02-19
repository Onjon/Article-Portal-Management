/**
 * Provides a solution to the problem of 
 * matching the relevancy between articles.
 * Checks whether the article has a significant 
 * amount of similar matches from previously stored articles.
 * @author      S. M. Ijaz-ul-Amin Chowdhury
 * @requires	LongestCommonSubsequence.js
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

function ArticleStringDataEstimatedMatchingAlgorithm() {
    /**
     * Holds the current data string which will be
     * used against all the previously collected dataset
     * to check the similarity.
     * 
     * @var         string
     */
    var currentDataString ;
    
	/**
     * Contains list of words that will be filtered out
     * from the given data string. These filters are also 
     * applied the dataset that works as sample dataset
     * for the revelancy checking.
     *
     * @var         2-dimensional array
     */
    var filterWordList ;
    
	/**
     * Contains list of delimiters that seperates the sentences
     * in the data string.
     *
     * @var         array
     */
    var sentenceDelimiterList ;
	
	var lcsObj ;
	var articleList ;
	var sentenceList ;
	var wordList ;
	
	this.currentDataString = "" ; 
	this.lcsObj = new LongestCommonSubsequence() ;	
	this.articleList = new Array() ;
	this.sentenceList = new Array() ;
	this.wordList = new Array() ;

	this.printArray = function ( arr ) {
		var i , sz ;
		sz = arr.length ;
		for( i = 0 ; i < sz ; i++ ) {
			console.log( arr[ i ] + "...." ) ;
		}
	}
	
	this.setRunableString = function ( currentDataStringParam ) {
        this.currentDataString = currentDataStringParam ;
	}
    
	this.initFilterList = function () {
		var i ;
        this.sentenceDelimiterList = new Array() ;
		this.sentenceDelimiterList.push( '?' ) ;
        this.sentenceDelimiterList.push( ',' ) ;
        this.sentenceDelimiterList.push( ':' ) ;
        this.sentenceDelimiterList.push( '.' ) ;
        this.sentenceDelimiterList.push( ';' ) ;
		this.sentenceDelimiterList.push( '!' ) ;
        
        this.filterWordList = new Array() ;
        for( i = 0 ; i <= 10 ; i++ ) {
            this.filterWordList.push( new Array() ) ;
        }
        this.filterWordList[ 1 ].push( "i" ) ;
        this.filterWordList[ 2 ].push( "is" ) ;
        this.filterWordList[ 2 ].push( "am" ) ;
		this.filterWordList[ 2 ].push( "he" ) ;
		this.filterWordList[ 3 ].push( "she" ) ;
        this.filterWordList[ 3 ].push( "are" ) ;
        this.filterWordList[ 3 ].push( "the" ) ;
    }
	
	this.toLowerCaseString = function ( arr ) {
		return arr.toLowerCase() ;
	}
	
	this.breakDownArticleToSentence = function ( arr ) {
		var i , brr , localSentence , len , sz , fl , j ;
		brr = new Array() ;
		localSentence = "" ;
		len = arr.length ;
		sz = this.sentenceDelimiterList.length ;
		for( i = 0 ; i < len ; i++ ) {
			fl = 0 ;
			for( j = 0 ; j < sz ; j++ ) {
				if( arr[ i ] == this.sentenceDelimiterList[ j ] ) {
					fl = 1 ;
					break ;
				}
			}
			if( fl == 0 ) {
				localSentence += arr[ i ] ;
			}
			else {
				if( localSentence != "" ) {
					brr.push( localSentence ) ;
				}
				localSentence = "" ;
			}
		}		
		return brr ;
	}
	
	this.checkWordValidity = function ( arr ) {
		var i , len ;
		len = arr.length ;
		for( i = 0 ; i < len ; i++ ) {
			if( ! ( ( arr[ i ] >= 'a' && arr[ i ] <= 'z' ) || ( arr[ i ] >= 'A' && arr[ i ] <= 'Z' ) ) ) {
				return false ;
			}
		}
		return true ;
	}
	
	this.isSet = function ( arr ) {
		if( arr != null || arr != '' || arr != 'undefined' ) {
			return false ;
		}
		return true ;
	}	
	
	this.breakDownSentenceToWord = function ( arr ) {
		var arr , len , brr , localWord , i ;
		arr += "." ;
		len = arr.length ;
		brr = new Array() ;
		localWord = "" ;		
		for( i = 0 ; i < len ; i++ ) {
			if( ( arr[ i ] >= 'a' && arr[ i ] <= 'z' ) || ( arr[ i ] >= 'A' && arr[ i ] <= 'Z' ) ) {
				localWord += arr[ i ] ;
			}
			else {
				localWord = this.toLowerCaseString( localWord ) ;
				if( localWord != "" && this.checkWordValidity( localWord ) == true ) {									
					fl = 1 ;
					if( this.isSet( this.filterWordList[ localWord.length ] ) == true ) {						
						sz = this.filterWordList[ localWord.length ].length ;
						for( j = 0 ; j < sz ; j++ ) {
							if( this.filterWordList[ localWord.length ][ j ] == localWord ) {
								fl = 0 ;
								break ;
							}
						}						
					}
					if( fl == 1 ) {
						brr.push( localWord ) ;
					}
				}
				localWord = "" ;
			}
		}
		return brr ;
	}
	
	this.stripQuotationAndAddDelimeterAtTheEnd = function ( arr ) {
		var len , brr , i ;
		len = arr.length ;
		brr = "" ;
		for( i = 0 ; i < len ; i++ ) {
			if( arr[ i ] == '"' || arr[ i ] == '\'' ) {				
			}
			else {
				brr += arr[ i ] ;
			}
		}
		brr += "." ;
		return brr ;
	}
	
	this.addNewSampleTrainArticle = function ( arr ) {
		var brr , sz , i , idx ;
		arr = this.stripQuotationAndAddDelimeterAtTheEnd( arr ) ;
		this.articleList.push( arr ) ;
		this.sentenceList.push( new Array() ) ;
		idx = this.sentenceList.length - 1 ;
		brr = this.breakDownArticleToSentence( arr ) ;
		sz = brr.length ;		
		for( i = 0 ; i < sz ; i++ ) {			
			this.sentenceList[ idx ].push( brr[ i ] ) ;
		}
	}
	
	this.breakDownAllToWords = function () {
		var sz1 , sz2 , sz3 , i , j , k , arr ;
		this.wordList = new Array() ;
		sz1 = this.articleList.length ;		
		for( i = 0 ; i < sz1 ; i++ ) {
			this.wordList.push( new Array() ) ;
			sz2 = this.sentenceList[ i ].length ;
			for( j = 0 ; j < sz2 ; j++ ) {
				this.wordList[ i ].push( new Array() ) ;				
				arr = this.breakDownSentenceToWord( this.sentenceList[ i ][ j ] ) ;
				sz3 = arr.length ;
				for( k = 0 ; k < sz3 ; k++ ) {
					this.wordList[ i ][ j ].push( arr[ k ] ) ;
				}
			}
		}
	}
	
	this.generateTwoIntegerArrayFromTwoWordArrays = function ( arr , brr ) {
		var cn , i , j , k , crr , drr , err , frr , sz1 , sz2 , sz3 , fl ;
		cn = 1 ;
		sz1 = arr.length ;
		sz2 = brr.length ;
		crr = new Array() ;
		drr = new Array() ;
		err = new Array() ;
		frr = new Array() ;
		//arr is the main string and brr is the to run string
		for( i = 0 ; i < sz1 ; i++ ) {
			fl = 0 ;
			for( j = 0 ; j < i ; j++ ) {
				if( arr[ i ] == arr[ j ] ) {
					fl = 1 ;
					break ;
				}
			}
			if( fl == 0 ) {
				crr.push( arr[ i ] ) ;
				drr.push( cn++ ) ;
			}
		}
		sz1 = crr.length ;
		for( i = 0 ; i < sz2 ; i++ ) {
			fl = -1 ;
			for( j = 0 ; j < sz1 ; j++ ) {
				if( crr[ j ] == brr[ i ] ) {
					fl = j ;
					break ;
				}
			}
			if( fl == -1 ) {
				err.push( cn ) ;
			}
			else {
				err.push( drr[ fl ] ) ;
			}
		}
		frr.push( drr ) ;
		frr.push( err ) ;
		return frr ;
	}
    
	this.checkTheArticle = function () {
		var res , r1 , averagePercentage , sumOfPercentage , maximumMatchPercentage , overallMaxPercentage , sz1 , sz2 , sz3 , brr , crr , drr , i , j , k ;
		maximumMatchPercentage = 0.00 ;
		checkAgainstString = this.stripQuotationAndAddDelimeterAtTheEnd( this.currentDataString ) ;
		brr = this.breakDownArticleToSentence( checkAgainstString ) ;
        sz1 = this.articleList.length ;
		sz3 = brr.length ;
		overallMaxPercentage = 0.0 ;
		for( i = 0 ; i < sz1 ; i++ ) {//list of total articles		
			sz2 = this.sentenceList[ i ].length ;
			sumOfPercentage = 0.0 ;
			for( k = 0 ; k < sz3 ; k++ ) {//list of sentences of 'on check against' article				
				crr = this.breakDownSentenceToWord( brr[ k ] ) ;
				res = 0 ;
				for( j = 0 ; j < sz2 ; j++ ) {//list of sentences of each article					
					drr = this.generateTwoIntegerArrayFromTwoWordArrays( this.wordList[ i ][ j ] , crr ) ;
					this.lcsObj.initArrays() ;
					this.lcsObj.addFirstArray( drr[ 0 ] ) ;
					this.lcsObj.addSecondArray( drr[ 1 ] ) ;
					r1 = this.lcsObj.runLcs() ;
					res = Math.max( res , r1 ) ;
				}
				localPercentage = ( res / crr.length ) * 100.0 ;
				sumOfPercentage += localPercentage ;
            }
			averagePercentage = sumOfPercentage / sz3 ;
			overallMaxPercentage = Math.max( overallMaxPercentage , averagePercentage ) ;			
        }
		return overallMaxPercentage ;
    }
}


/**
 * Sample usage description:
 * 



var res , asdemsObj ;
asdemsObj = new ArticleStringDataEstimatedMatchingAlgorithm() ;
asdemsObj.initFilterList() ;
asdemsObj.addNewSampleTrainArticle( "hello, how are you? hope it is good." ) ;
asdemsObj.addNewSampleTrainArticle( "good day to you sir." ) ;
asdemsObj.addNewSampleTrainArticle( "nice weather." ) ;
asdemsObj.breakDownAllToWords() ;
asdemsObj.setRunableString( "maye suzume! hello, good day. move forward!" ) ;
res = asdemsObj.checkTheArticle() ;
console.log( parseInt( res ) ) ;

 
*/