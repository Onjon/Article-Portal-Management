<?php

session_start();
error_reporting(E_ALL ^ E_NOTICE);
include('process/authenticationuser.php');
include('process/processor.php');
$access = new processor();

$user_id = $_SESSION['userid'] ;

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
            <h1>USA City Names</h1>
        </div>
        <div class="g12 widgets">
        <table class="datatable">
				<thead>
					<tr>
                    	<th>City Name</th>
                        <th>State Name</th>
					</tr>
				</thead>
				<tbody>
            <?php
				$result = $access->showcity();
				while($row = mysql_fetch_array($result))
				{
					echo '<tr class="gradeX">
							<td>'.$row['city_name'].'</td>
							<td>'.$row['state_name'].'</td>';
						echo '</tr>';
					
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