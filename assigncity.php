<?php

session_start();
error_reporting(E_ALL ^ E_NOTICE);
include('process/authentication.php');
include('process/processor.php');
$access = new processor();
//echo $_GET['userid'];
$arr = $access -> getAllCity() ;
$sz = sizeof( $arr ) ;

if( isset( $_POST[ 'cityname' ] ) ) {
	$access -> insertCity( mysql_real_escape_string( $_POST[ 'cityname' ] ) , '' ) ;
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
		
	
	
	
</head>
<body>

	<header>
		<div id="logo">
			<a href="index.php">Always Constant</a>
		</div>
		<div id="header">
			<!--<ul id="headernav">
				<li><ul>
					<li><a href="icons.html">To</a><span>300+</span></li>
					<li><a href="#">Submenu</a><span>4</span>
						<ul>
							<li><a href="#">Just</a></li>
							<li><a href="#">another</a></li>
							<li><a href="#">Dropdown</a></li>
							<li><a href="#">Menu</a></li>
						</ul>
					</li>
					<li><a href="login.html">Login</a></li>
					<li><a href="wizard.html">Wizard</a><span>Bonus</span></li>
					<li><a href="#">Errorpage</a><span>new</span>
						<ul>
							<li><a href="error-403.html">403</a></li>
							<li><a href="error-404.html">404</a></li>
							<li><a href="error-405.html">405</a></li>
							<li><a href="error-500.html">500</a></li>
							<li><a href="error-503.html">503</a></li>
						</ul>
					</li>
				</ul></li>
			</ul>-->
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
            <h1>Define City for User</h1>
        </div>	
    
        <div class="g12 widgets">
            <form id="cityadd" action="assigncity.php" method="post" autocomplete="off">
                <fieldset>
                <label>Add City</label>
                <section><label for="text_field">City Name</label>
                    <div><input type="text" id="cityname" name="cityname" required></div>
                </section>
                
                <section>
                    <div>
                    <button class="reset">Reset</button>
                    <button class="submit" name="submitbuttonname" value="submitbuttonvalue">Submit</button></div>
                </section>
                </fieldset>
                
            </form>
        </div>
        <div class="g12 widgets">
        	<form id="assigncity">
            	<fieldset>
                	<section>
                        <label for="multiselect">Multiple Select<br>
                        <span>use ctrl + shift key. The selection(right) is sortable with drag n' drop</span></label>
                        <div>					
                        <select name="multiselect" id="multiselect" multiple>
                        		<?php
									for( $i = 0 ; $i < $sz ; $i++ ) {
										echo '<option value="' . $arr[ $i ][ 1 ] . '">' . $arr[ $i ][ 1 ] . '</option>' ;
										echo "\n" ;
									}
								?>
                        		<!--
                                <option value="artichoke">Artichoke</option>
                                <option value="beans">Beans</option>
                                <option value="broccoli">Broccoli</option>
                                <option value="carrot">Carrot</option>
                                <option value="corn">Corn</option>
                                <option value="chicory">Chicory</option>
                                <option value="kohlrabi">Kohlrabi</option>
                                <option value="melon">Melon</option>
                                <option value="onion">Onion</option>
                                <option value="potato">Potato</option>
                                <option value="pumpkin">Pumpkin</option>
                                <option value="spinach">Spinach</option>
                                <option value="tomato">Tomato</option>
                                -->
                        </select>
                        <br/>
                        <br/>
                        <button class="submit" name="submitbuttonname2" >Assign to the current user</button>
                        </div>
                    </section>
                </fieldset>
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
    <!--
	<script src="js/wl_Form.js"></script>
    -->
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