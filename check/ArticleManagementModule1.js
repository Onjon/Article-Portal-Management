
		var listOfImageData , listOfImageNames , listOfAllArticleData , asdemsObjArticle , asdemsObjTitle ;
		function wordCount( arr ) {
			var len , cn , i , brr ;
			cn = 0 ;
			brr = "" ;
			arr += " " ;
			len = arr.length ;
			for( i = 0 ; i < len ; i++ ) {
				if( ( arr[ i ] >= 'A' && arr[ i ] <= 'Z' ) || ( arr[ i ] >= 'a' && arr[ i ] <= 'z' ) ) {
					brr += arr[ i ] ;
				}
				else {
					if( brr != "" ) {
						cn++ ;
					}
					brr = "" ;
				}
			}
			return cn ;
		}
		function checkNull( str ) {
			if( str == null || str == 'undefind' || str == '' ) {
				return true ;
			}
			return false ;
		}
        
        function doDeleteMe() {
            alert( "Article Added Successfully!!!!" );
        }
		
		function doSecondAjaxRequest( urlWithoutParams , params ) {
			var xmlhttp ;
			if( window.XMLHttpRequest ) {
				xmlhttp = new XMLHttpRequest() ;
			}
			else {
			  	xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" ) ;
			}
			xmlhttp.onreadystatechange = function() {
				if( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
					console.log( xmlhttp.responseText ) ;
                    doDeleteMe() ;
				}
			}
			xmlhttp.open( "POST" , urlWithoutParams , true ) ;
			xmlhttp.setRequestHeader( "Content-type" , "application/x-www-form-urlencoded; charset=UTF-8" ) ;
			xmlhttp.send( params ) ;
		}
		
		function parseName( arr ) {
			var len , i , brr , j ;
			len = arr.length ;
			brr = "" ;
			j = 0 ;
			for( i = len - 1 ; i >= 0 ; i-- ) {
				if( arr[ i ] == '/' || arr[ i ] == '\\' ) {
					break ;
				}
				j = i ;
			}
			for( i = j ; i < len ; i++ ) {
				brr += arr[ i ] ;
			}
			return brr ;
		}
		
		function checkarticle() {			
			var a , b , c , d , e , f1 , f2 , f3 , arrayOfFiles , len , sz , i , j , xmlhttp , fileReader , imgData , tempFileName ;
			a = document.getElementById( 'textarea_wysiwyg' ).value ;
			b = document.getElementById( 'text_field' ).value ;
            d = document.getElementById( 'autocomplete' ).value ;
            e = document.getElementById( 'set_city' ).value ;
            /*
			f1 = document.getElementById( 'file_upload_1' ) ;
			f2 = document.getElementById( 'file_upload_2' ) ;
			f3 = document.getElementById( 'file_upload_3' ) ;
            */
			arrayOfFiles = new Array() ;
			if( checkNull( a ) == true ) {
				alert( 'Please provide the article data!' ) ;
				return false ;
			}
			if( checkNull( b ) == true ) {
				alert( 'Please provide the article title!' ) ;
				return false ;
			}
            if( e == 0 || checkNull( d ) == true ) {
				alert( 'Please provide the city!' ) ;
				return false ;
			}
            /*
			if( checkNull( f1.value ) == true && checkNull( f2.value ) == true && checkNull( f3.value ) == true ) {
				alert( 'Please provide at least 1 photo!' ) ;
				return false ;
			}
            */
			if( ! ( titleOnkeyUp() == true && articleOnkeyUp() == true ) ) {
				alert( 'Article minimum uniqueness not fullfilled!' ) ;
				return false ;
			}
            /*
			if( checkNull( f1.value ) == false ) {
				arrayOfFiles.push( f1.files[ 0 ] ) ;
			}
			if( checkNull( f2.value ) == false ) {
				arrayOfFiles.push( f2.files[ 0 ] ) ;
			}
			if( checkNull( f3.value ) == false ) {
				arrayOfFiles.push( f3.files[ 0 ] ) ;
			}
			sz = arrayOfFiles.length ;
			listOfImageData = new Array() ;
			listOfImageNames = new Array() ;
			for( i = 0 ; i < sz ; i++ ) {
				fileReader = new FileReader() ;
				fileReader.onload = function( event ) {
					imgData = event.target.result ;
					imgData = base64_encode( imgData ) ;
					imgData = encodeURIComponent( imgData ) ;
					listOfImageData.push( imgData ) ;
				}
				fileReader.readAsBinaryString( arrayOfFiles[ i ] ) ;
				tempFileName = parseName( arrayOfFiles[ i ].name ) ;
				for( j = 0 ; j < listOfImageNames.length ; j++ ) {
					if( listOfImageNames[ j ] == tempFileName ) {
						tempFileName = tempFileName + Math.random() ;
						break ;
					}
				}
				listOfImageNames.push( tempFileName ) ;
			}
            */
			if( window.XMLHttpRequest ) {
				xmlhttp = new XMLHttpRequest() ;
			}
			else {
			  	xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" ) ;
			}
			xmlhttp.onreadystatechange = function() {
				if( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
					var resultDiv , a , paramString , j , i , b ;
					a = xmlhttp.responseText ;
					resultDiv = document.getElementById( "responseText" ) ;
					resultDiv.innerHTML = a ;
                    //console.log( a ) ;
                    /*
					if( a == 'Successfully added article onto the database!' ) {
						sz = listOfImageData.length ;
						paramString = "user_id=" + localUserId ;
                        paramString += "&city=" + document.getElementById( "autocomplete" ).value ;
						for( i = 0 ; i < sz ; i++ ) {
							paramString += "&" ;
							b = 'a' ;							
							for( j = 0 ; j < i ; j++ ) {
								b = "" + String.fromCharCode( b.charCodeAt( 0 ) + 1 ) ;
							}
							paramString += b ;
							paramString += "=" + listOfImageData[ i ] ;
							paramString += "&" ;
							paramString += b + "_fileName" ;
							paramString += "=" + listOfImageNames[ i ] ;
						}
						doSecondAjaxRequest( "check/writeFile.php" , paramString ) ;
					}
                    */
				}
			}
			xmlhttp.open( "POST" , "check/checkData1.php" , true ) ;
			xmlhttp.setRequestHeader( "Content-type" , "application/x-www-form-urlencoded; charset=UTF-8" ) ;
			xmlhttp.send( "a=" + a + "&b=" + b + "&city=" + document.getElementById( "autocomplete" ).value + "&article_id=" + articleTableDataId ) ;
		}
		
		function articleOnkeyUp() {
			var res , i , sz , localData , wCount ;
			sz = listOfAllArticleData.length ;
			if( sz == 0 ) {
				console.log( "Data not ready!" ) ;
				return ;
			}
			localData = document.getElementById( "textarea_wysiwyg" ).value ;
            wCount = wordCount( localData ) ;
            if( wCount >= 0 && wCount <= 100000000 ) {
                document.getElementById( "articlenNumberOfWords" ).innerHTML = "Number of words typed: " + wCount ;
            }
			asdemsObjArticle.breakDownAllToWords() ;
			asdemsObjArticle.setRunableString( localData ) ;
			res = asdemsObjArticle.checkTheArticle() ;
			res = parseInt( res ) ;
            //console.log( res ) ;
			if( res <= 80 && wCount >= 10 && wCount <= 200 ) {
				return true ;
			}
			//console.log( "Article maximum percentage match: " + res ) ;
			//console.log( "Article word count: " + wordCount( localData ) ) ;
			return false ;
		}
        
        function articleOnkeyUpEvent() {
			var res , i , sz , localData , wCount ;
			sz = listOfAllArticleData.length ;
			if( sz == 0 ) {
				console.log( "Data not ready!" ) ;
				return ;
			}
			localData = document.getElementById( "textarea_wysiwyg" ).value ;
            wCount = wordCount( localData ) ;
            if( wCount >= 0 && wCount <= 100000000 ) {
                document.getElementById( "articlenNumberOfWords" ).innerHTML = "Number of words typed: " + wCount ;
            }
		}
		
		function titleOnkeyUp() {
			var res , i , sz , localData , wCount ;
			sz = listOfAllArticleData.length ;
			if( sz == 0 ) {
				console.log( "Data not ready!" ) ;
				return ;
			}
			localData = document.getElementById( "text_field" ).value ;
            wCount = wordCount( localData ) ;
            if( wCount >= 0 && wCount <= 100000000 ) {
                document.getElementById( "titlenNumberOfWords" ).innerHTML = "Number of words typed: " + wCount ;
            }
			asdemsObjTitle.breakDownAllToWords() ;
			asdemsObjTitle.setRunableString( localData ) ;
			res = asdemsObjTitle.checkTheArticle() ;
			res = parseInt( res ) ;
            //console.log( res ) ;
			if( res <= 50 && wCount >= 5 && wCount <= 20 ) {
				return true ;
			}
			//console.log( "Title maximum percentage match: " + res ) ;
			//console.log( "Title word count: " + wordCount( localData ) ) ;
			return false ;
		}
        
        function titleOnkeyUpEvent() {
			var res , i , sz , localData , wCount ;
			sz = listOfAllArticleData.length ;
			if( sz == 0 ) {
				console.log( "Data not ready!" ) ;
				return ;
			}
			localData = document.getElementById( "text_field" ).value ;
            wCount = wordCount( localData ) ;
            if( wCount >= 0 && wCount <= 100000000 ) {
                document.getElementById( "titlenNumberOfWords" ).innerHTML = "Number of words typed: " + wCount ;
            }
		}
		
		function populateLocalDataSet() {
			var i , sz ;
			sz = listOfAllArticleData.length ;
			if( sz == 0 ) {
				console.log( "Data not ready!" ) ;
				return ;
			}
			asdemsObjArticle = new ArticleStringDataEstimatedMatchingAlgorithm() ;
			asdemsObjTitle = new ArticleStringDataEstimatedMatchingAlgorithm() ;
			asdemsObjArticle.initFilterList() ;
			asdemsObjTitle.initFilterList() ;
			for( i = 0 ; i < sz ; i++ ) {
				asdemsObjArticle.addNewSampleTrainArticle( listOfAllArticleData[ i ][ 0 ] ) ;
				asdemsObjTitle.addNewSampleTrainArticle( listOfAllArticleData[ i ][ 1 ] ) ;
			}
			console.log( "data loaded!" ) ;
		}
		
		function getAllData() {
			var xmlhttp , a , b ;
			if( window.XMLHttpRequest ) {
				xmlhttp = new XMLHttpRequest() ;
			}
			else {
			  	xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" ) ;
			}
			xmlhttp.onreadystatechange = function() {
				var arr , i , j ;
				if( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
					arr = JSON.parse( xmlhttp.responseText ) ;
                    //console.log( arr ) ;
					listOfAllArticleData = arr ;
					populateLocalDataSet() ;
				}
			}
            a = document.getElementById( 'textarea_wysiwyg' ).value ;
			b = document.getElementById( 'text_field' ).value ;
            console.log( a + "...." + b ) ;
			xmlhttp.open( "POST" , "check/getAllData.php" , true ) ;
			xmlhttp.setRequestHeader( "Content-type" , "application/x-www-form-urlencoded; charset=UTF-8" ) ;
			xmlhttp.send( "a=" + a + "&b=" + b ) ;
		}