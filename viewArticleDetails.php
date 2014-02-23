<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if( !isset( $_SESSION[ 'userid' ] ) ) {
    header( "Location: index.php" );
    exit();
}
include('process/processor.php');
$access = new processor();


// Get User ID and Type 
$user_id = $_SESSION['userid'] ;
$user_type = $_SESSION[ 'access' ];

// Restrict Users 
if( $user_id != $_GET[ 'userId' ] && $user_type != "admin" ) {
    header( "Location: index.php" );
    exit();
}

?>

<?php
// Onjon Code Start 
if( !isset( $_GET[ 'userId' ] ) || !isset( $_GET[ 'date' ] ) ) {
    die( "Invalid Request!!!" );
}

$reqUserId = mysql_real_escape_string( $_GET[ 'userId' ] );
$reqArticleDate = mysql_real_escape_string( $_GET[ 'date' ] );
$reqArticleDate = date( "Y-m-d" , strtotime( $reqArticleDate ) );

if( !is_numeric( $reqUserId ) ) {
    die( "Invalid User Id!!!" );
}

// Connection Set 
include('process/dbconnect.php');
$conn = new dbconnect();
$conn -> onjonCon(); 

// Get User Name 
include( "onjon/GetUserName.php" );

// Get Function for Download Documents 
include( "process/GetDocument.php" );
$getDoc = new GetDocument();
$getDoc -> setData( $reqUserId , $reqArticleDate );
$getDocRes = $getDoc -> getResult();
if( $getDocRes == 1 ) {
    $article_ids = $getDoc -> getId();
    $article_titles = $getDoc -> getTitle();
    $article_details = $getDoc -> getDetails();
    $article_city = $getDoc -> getCity();
    
    $total_articles = sizeof( $article_ids );
}
// Onjon Code End 
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
    <script src="js/base64.js"></script>
    <script src="check/LongestCommonSubsequence.js"></script>
    <script src="check/ArticleStringDataEstimatedMatchingAlgorithm.js"></script>
    <script type="text/javascript">
		var localUserId ;
		localUserId = '<?php echo $user_id ; ?>' ;
	</script>
    <script src="check/ArticleManagementModule.js"></script>
	
	<!-- Loading JS Files this way is not recommended! Merge them but keep their order -->
	
	<!-- some basic functions -->
    <!--
	<script src="js/functions.js"></script>
    -->
    <script>
        function updateArticle( a ) {
            window.location = "updateArticle.php?articleId=" + a ; 
        }
    </script>
</head>
<body onload="getAllData() ;">
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
        <?php include('files/usermenu.php'); ?>
    </nav>
    <section id="content">    
        <div class="g12 nodrop">
            <h1>View Articles </h1> 
        </div>
        <div class="g12 widgets">
            Displaying <b><?=GetUserName::getName($user_id);?></b>'s Articles of <b>21 February, 2014</b>
            <br/>
            <br/>
            <br/>
            <?php
            if( $getDocRes  == 1 ) {
                for( $i = 0 ; $i < $total_articles ; $i++ ) {
            ?>
            <br/>Title : <b><?=$article_titles[ $i ];?></b><br/>
            City : <b><?=$article_city[ $i ];?></b><br/>
            <br/>
            <b><?=$article_details[ $i ];?></b><br/>
            <button type="submit" onClick="Javascript:updateArticle(<?=$article_ids[ $i ];?>);" >Update</button>
            <br/>
            --------------------------------------
            <?php
                }
            ?>
            <?php
            }
            else {
            ?>
            <h2>
                <font color='red'>No Articles Found!!!</font>
            </h2>
            <?php
            }
            ?>
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
<!--
	<script src="js/wl_File.js"></script>
-->
	<script src="js/wl_Dialog.js"></script>
	<script src="js/wl_Fileexplorer.js"></script>
<!--
	<script src="js/wl_Form.js"></script>
--->
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