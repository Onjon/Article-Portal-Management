<?php

function doCheckDateLeftSmall( $left , $right ) {
    $year1 = date( 'Y' , strtotime( $left ) ) ;
    $year2 = date( 'Y' , strtotime( $right ) ) ;
    if( $year1 < $year2 ) {
        return true ;
    }
    if( $year1 > $year2 ) {
        return false ;
    }
    $month1 = date( 'm' , strtotime( $left ) ) ;
    $month2 = date( 'm' , strtotime( $right ) ) ;
    if( $month1 < $month2 ) {
        return true ;
    }
    if( $month1 > $month2 ) {
        return false ;
    }
    $day1 = date( 'd' , strtotime( $left ) ) ;
    $day2 = date( 'd' , strtotime( $right ) ) ;
    if( $day1 < $day2 ) {
        return true ;
    }
    if( $day1 > $day2 ) {
        return false ;
    }
    return true ;
}
session_start();
error_reporting( 0 );
include('process/authenticationuser.php');
include('process/processor.php');
$access = new processor();
$result = $access->show_active_user();

// Onjon Code Start 

// Connection Set 
$conn = new dbconnect();
$conn -> onjonCon(); 


// Prevent CSRF Attack 
// Set A Flag 
$fl = 0 ; 
if( isset( $_POST[ 'download_key' ] ) && isset( $_SESSION[ 'key' ] ) ) {
    if( $_POST[ 'download_key' ] == $_SESSION[ 'key' ] ) {
        $fl = 1 ; 
    }
}

// Set Key Value 
$_SESSION[ 'key' ] = rand( 10 , 1000 );
$download_key = $_SESSION[ 'key' ] ;
// Onjon Code End 


// Get User Id 
$userId = $_SESSION['userid'] ; 

// Get Short File Details GROUP BY Date
include( "onjon/GetDocShortUser.php" );
$getShortDoc = new GetDocShortUser( $userId );
$getShortDocRes = $getShortDoc -> getResult();

include( "process/GetDocument.php" );
$getDoc = new GetDocument();
?>
<!doctype html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	
	<title>Constant</title>
	
	<meta name="description" content="">
	<meta name="author" content="revaxarts.com">
	
	
	<!-- Google Font and style definitions -->
	<link rel="stylesheet" href="css/style.css">
	
	<!-- include the skins (change to dark if you like) -->
	<link rel="stylesheet" href="css/light/theme.css" id="themestyle">
	<!-- <link rel="stylesheet" href="css/dark/theme.css" id="themestyle"> -->
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link rel="stylesheet" href="css/ie.css">
	<![endif]-->
	
	
	<!-- Apple iOS and Android stuff - don't remove! -->
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1">
	
	<!-- Use Google CDN for jQuery and jQuery UI -->
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	
	<!-- Loading JS Files this way is not recommended! Merge them but keep their order -->
	
	<!-- some basic functions -->
	<script src="js/functions.js"></script>
		
	<script type="text/javascript">
        function doSubmit( userIdParam , dateParam ) {
            var a , b , key ; 
            key = document.getElementById( "download_key" ).value ; 
            a = document.getElementById( "doc_user_id" ).value = userIdParam ; 
            b = document.getElementById( "doc_date" ).value = dateParam ; 
            if( key != "" && a != "" && b != "" ) {
                document.get_files.submit(); 
            }
        }
	</script>
	<script type="text/javascript">
        function showDoc( a ) {
            window.open( "viewDoc.php?articleDate="+a ); 
        }
	</script>
    <script>
        function doSubmit() {
            document.chose_date.submit(); 
        }
    </script>
	
</head>
<body>
    
    <form action='' method="POST" name="get_files" >
        <input type="hidden" id="download_key" name = "download_key" value="<?=$download_key;?>" />
        <input type="hidden" id="doc_user_id" name="doc_user_id" />
        <input type="hidden" id="doc_date" name="doc_date" />
    </form>    
	<header>
		<div id="logo">
			<a href="index.php">Always Constant</a>
		</div>
		<div id="header">
			<div id="searchbox">
				<form id="searchform" autocomplete="off">
					<input type="search" name="query" id="search" placeholder="Search">
				</form>
			</div>
			<ul id="searchboxresult">
			</ul>
		</div>
	</header>

    <nav>
        <?php include('files/menus.php'); ?>
    </nav>
		
			
		
    <section id="content">
        
        <div class="g12 nodrop">
            <h1>Written Articles</h1>
        </div>	
        
        <div class="g12 widgets">
            <table class="datatable">
				<thead>
					<tr>
                    	<th>Date</th>
                        <th>Number of Artcle</th>
                        <th>Option</th>
					</tr>
				</thead>
				<tbody>
                    
                    <?php  
                    $this_month = date( 'M' );
                    
                    if( $getShortDocRes == 1 ) {
                        $getShortDate = $getShortDoc -> getDT();
                        $getTotalDocPerDay = $getShortDoc -> getTotal();
                        
                        $req_fl = 0 ;
                        if( isset( $_POST[ 'start_date' ] ) ) {
                            $req_fl = 1 ;
                            // Start Date 
                            $date_start = mysql_real_escape_string( $_POST[ 'start_date' ] );
                            $date_start = date( 'd-m-Y' , strtotime( $date_start ) ); // Request Date 
                            // End Date 
                            $date_end = mysql_real_escape_string( $_POST[ 'end_date' ] );
                            $date_end = date( 'd-m-Y' , strtotime( $date_end ) );
                            
                            
                            echo "Displaying from : <b>" . $date_start . "</b> to <b>" . $date_end ."</b>";
                        }
                        else {
                            echo "<div style='float:right;margin-right:15px;'>Displaying the article for : <b>" . $this_month . "</b><br/></div>" ;
                        }
                        
                        $totalDoc = sizeof( $getShortDate );
                        for( $i = 0 ; $i < $totalDoc ; $i++ ) {
                            if( $req_fl == 0 ) {
                                if( $this_month != date( 'M' , strtotime( $getShortDate[ $i ] ) ) ) {
                                    continue;
                                }
                            }
                            else if( $req_fl == 1 ) {
                                $left = $date_start ;
                                $middle = date( 'd-m-Y' , strtotime( $getShortDate[ $i ] ) ) ;
                                $right = $date_end ;
                                if( ! ( doCheckDateLeftSmall( $left , $middle ) && doCheckDateLeftSmall( $middle , $right ) ) ) {
                                    continue;
                                }
                            }
                            
                    ?>
                      <tr class="gradeX">
                        <td><?=$getShortDate[ $i ];?></td>
                        <td><b><?=$getTotalDocPerDay[ $i ];?></b></td>
                        <td>
                            <?php
                            if( $_SESSION[ 'access' ] == "admin" ) {
                            ?>
                            <button type="button" onClick="showDoc( '<?=$getShortDate[ $i ];?>' );">View All</button>
                            <?php
                            }
                            else {
                            ?>
                            <a href="viewArticleDetails.php?userId=<?=$_SESSION[ 'userid' ];?>&&date=<?=$getShortDate[ $i ];?>" ><button type="button">View All</button></a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    
                </tbody>
            </table>
            <form action="show.php" method="POST" name="chose_date" > 
                Start From : <input type="date" name="start_date" required="true" <?php if( isset( $_POST[ 'start_date' ] ) ) { ?> value="<?=$_POST[ 'start_date' ]?>" <?php } ?>/>
                End At : <input type="date" name="end_date" required="true" <?php if( isset( $_POST[ 'end_date' ] ) ) { ?> value="<?=$_POST[ 'end_date' ]?>" <?php } ?> />
                <br/>
                <button type="submit" onClick="Javascript:doSubmit();" >Submit</button>
            </form>
        </div>	
    </section>
    
	<footer>Copyright by </footer>
</body>

<!-- all Third Party Plugins and Whitelabel Plugins -->
	<script src="js/plugins.js"></script>
	<script src="js/editor.js"></script>
	<script src="js/calendar.js"></script>
	<script src="js/flot.js"></script>
	<script src="js/elfinder.js"></script>
	<script src="js/datatables.js"></script>
	<script src="js/wl_Alert.js"></script>
	<script src="js/wl_Autocomplete.js"></script>
	<script src="js/wl_Breadcrumb.js"></script>
	<script src="js/wl_Calendar.js"></script>
	<script src="js/wl_Chart.js"></script>
	<script src="js/wl_Color.js"></script>
	<script src="js/wl_Date.js"></script>
	<script src="js/wl_Editor.js"></script>
	<script src="js/wl_File.js"></script>
	<script src="js/wl_Dialog.js"></script>

	<script src="js/wl_Fileexplorer.js"></script>
	<script src="js/wl_Form.js"></script>
	<script src="js/wl_Gallery.js"></script>
	<script src="js/wl_Multiselect.js"></script>
	<script src="js/wl_Number.js"></script>
	<script src="js/wl_Password.js"></script>
	<script src="js/wl_Slider.js"></script>
	<script src="js/wl_Store.js"></script>
	<script src="js/wl_Time.js"></script>
	<script src="js/wl_Valid.js"></script>
	<script src="js/wl_Widget.js"></script>
	
	<!-- configuration to overwrite settings -->
	<script src="js/config.js"></script>
		
	<!-- the script which handles all the access to plugins etc... -->
	<script src="js/script.js"></script>
</html>