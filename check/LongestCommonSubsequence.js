function LongestCommonSubsequence() {
	var arr , brr , lim , memo , done , cc , len1 , len2 ;
	this.lim = 800 ;
	this.cc = 1 ;
	this.memo = new Array( this.lim ) ;
	this.done = new Array( this.lim ) ;
	
	this.initArrays = function () {
		var i ;
		for( i = 0 ; i < this.lim ; i++ ) {
			this.memo[ i ] = new Array( this.lim ) ;
			this.done[ i ] = new Array( this.lim ) ;
			for( j = 0 ; j < this.lim ; j++ ) {
				this.memo[ i ][ j ] = 0 ;
				this.done[ i ][ j ] = 0 ;
			}
		}
	}
	
	this.addFirstString = function ( arrParam ) {
		this.arr = arrParam ;
		this.len1 = this.arr.length ;
	}
	
	this.addFirstArray = function ( arrParam ) {
		this.arr = arrParam ;
		this.len1 = this.arr.length ;
	}
	
	this.addSecondString = function ( arrParam ) {
		this.brr = arrParam ;
		this.len2 = this.brr.length ;
	}
	
	this.addSecondArray = function ( arrParam ) {
		this.brr = arrParam ;
		this.len2 = this.brr.length ;
	}
	
	this.dp = function ( i , j ) {
		if( i >= this.len1 || j >= this.len2 ) {
			return 0 ;
		}
		var res , re , r1 ;
		res = this.memo[ i ][ j ] ;
		re = this.done[ i ][ j ] ;
		if( re == this.cc ) {
			return res ;
		}
		this.done[ i ][ j ] = this.cc ;
		res = 0 ;		
		if( this.arr[ i ] == this.brr[ j ] ) {
			r1 = this.dp( i + 1 , j + 1 ) + 1 ;
			res = Math.max( r1 , res ) ;
		}
		r1 = this.dp( i + 1 , j ) ;
		res = Math.max( r1 , res ) ;
		r1 = this.dp( i , j + 1 ) ;
		res = Math.max( r1 , res ) ;
		this.memo[ i ][ j ] = res ;
		return res ;
	}
	
	this.runLcs = function () {
		var res ;
		this.cc++ ;		
		res = this.dp( 0 , 0 ) ;
		return res ;
	}
}

/**
*	Sample Usage:

var str1 , str2 , lcsObj , res ;
str1 = "onjonisamarriedperson!mindit!" ;
str2 = "zzzzdhoiramarrzz" ;
lcsObj = new LongestCommonSubsequence() ;
lcsObj.initArrays() ;
lcsObj.addFirstString( str1 ) ;
lcsObj.addSecondString( str2 ) ;
res = lcsObj.runLcs() ;
console.log( res ) ;

*/
