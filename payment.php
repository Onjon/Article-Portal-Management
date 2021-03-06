<?php
session_start();
error_reporting(0);
include('process/authentication.php');
include('process/processor.php');
$access = new processor();
$result = $access->show_active_user();

// Onjon's Code Start Here 

// Set A Varialbe so that no one can have the access to "natasha.php"
$message = "Natasha I Love You!!!" ;
include( "natasha.php" );

// Connection Set 
$conn = new dbconnect();
$conn -> onjonCon(); 

// Get User List 
include( "onjon/GetUserList.php" );
$getUser = new GetUserList();
$getUserRes = $getUser -> getResult();

// Get Article List 
include( "onjon/GetArticle.php" );
// Onjon's Code End Here 
?>
<?php
// Send Search Request for Result Page 
if( isset( $_POST[ 'search' ] ) ) {
    if( !empty( $_POST[ 'start' ] ) && !empty( $_POST[ 'end' ] ) ) {
        $start = mysql_real_escape_string( $_POST[ 'start' ] );
        $end = mysql_real_escape_string( $_POST[ 'end' ] );
        
        $start = date( "Y-m-d" , strtotime( $start ) );
        $end = date( "Y-m-d" , strtotime( $end ) );
        
        $url = "payment_search.php?start=".$start."&&end=".$end." " ; 
        header( "Location: ".$url );
        exit();
    }
}
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
		
	<script>
        function doSearch() {
            var start_date , end_date , id ;
            id = document.getElementById( "search" ).value; 
            start_date = document.getElementById( "start" ).value; 
            end_date = document.getElementById( "end" ).value; 
            
            if( id != "" && start_date != "" && end_date != "" ) {
                 if( start_date <= end_date ) {
                    // Do Submit 
                    document.chose_date.submit();
                 }
                 else {
                    // show alert message 
                    alert( "Start Date can not be less than End Date!!!" );                    
                 }
            }
            else {
                alert( "Please insert Date" ); 
            }
        }
	</script>
	
	
</head>
<body>

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
            <h1>Payment Status</h1>
        </div>	
    	
        <div class="g12 widgets">
            <table class="datatable">
				<thead>
					<tr>
						<th>Name</th>
                        <th>Email</th>
                        <th>Rate</th>
                        <th>No. of Artcle(This Month)</th>
                        <th>This Month Income</th>
                        <th>Today Income</th>
                        <th>Total Income</th>
					</tr>
				</thead>
				<tbody>
                    <?php
                    if( $getUserRes == 1 ) {
                        $userIds = $getUser -> getId();
                        $userNames = $getUser -> getName();
                        $userEmails = $getUser -> getEmail();
                        $userRates = $getUser -> getRate();
                        
                        $totalUsers = sizeof( $userIds );
                        for( $i = 0 ; $i < $totalUsers ; $i++ ) {
                        $totalArticle = GetArticle::getTotalArticle( $userIds[ $i ] );
                        $totalArticleToday = GetArticle::getTodaysArticle( $userIds[ $i ] );
                        $totalArticleThisMonth = GetArticle::getMonthlyArticles( $userIds[ $i ] );
                        $userRatePerArticle = $userRates[ $i ] ;
                        
                        if( $userIds[ $i ] != $_SESSION[ 'userid' ] ) {
                            continue;
                        }
                    ?>
					<tr class="gradeX">
                        <td><?=$userNames[ $i ];?></td>
                        <td><?=$userEmails[ $i ];?></td>
                        <td><?=$userRatePerArticle;?></td>
                        <td><?=$totalArticleThisMonth;?></td>
                        <td><?=$totalArticleThisMonth * $userRatePerArticle ;?></td>
                        <td><?=$totalArticleToday * $userRatePerArticle;?></td>
                        <td class="c"><?=$totalArticle * $userRatePerArticle;?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            
            <form action="" method="POST" name="chose_date" > 
                <input type="hidden" name="search" id="search" value="<?=rand( 10 , 100 );?>" />
                Start From : <input type="date" name="start" id="start" />
                End At : <input type="date" name="end" id="end"/>
                <br/>
                <button type="submit" onClick="Javascript:doSearch();">Search</button>
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