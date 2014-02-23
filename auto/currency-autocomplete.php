<?php
function currentPageName() {
    $page = "" ;
    $full_url = strrev( $_SERVER[ 'SCRIPT_NAME' ] );
    $len = strlen( $full_url );
    for( $i = 0 ; $i < $len ; $i++ ) {
        if( $full_url[ $i ] == "/" ) {
            break;
        }
        $page .= $full_url[ $i ] ;
    }
    $page = strrev( $page );
    return $page ; 
}
?>
<script>
$(function(){
  var currencies = [
    <?php
        if( $cityRes == 1 ) {
        $city_name = $cityList[ 1 ] ; 
        $totalCity = sizeof( $city_name );
            for( $i = 0 ; $i < $totalCity ; $i++ ) {
                if( currentPageName != "updateArticle.php" ) {
                    if( GetCityName::getSelectedCity( $city_name[ $i ] , $user_id ) == 1 ) {
                        continue;
                    }
                }
                else {
                    if( GetCityName::getSelectedCityUpdate( $city_name[ $i ] , $user_id , $article_id ) == 1 ) {
                        continue;
                    }
                }
                echo '{ value: "'.$city_name[ $i ].'", data: "'.$city_name[ $i ].'" }'; 
                if( $i != $totalCity - 1 ) {
                    echo "," ;
                }
            }
        }
        
    ?>
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies,
    onSelect: function (suggestion) {
    var data = suggestion.value ; 
    document.getElementById( "set_city" ).value = 1 ; 
    }
  });
  
    
  

});
</script>