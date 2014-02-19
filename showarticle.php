<?php

session_start();
error_reporting( 0 );
include('process/authentication.php');
include('process/processor.php');
$access = new processor();
$result = $access->show_active_user();

// Onjon Code Start 

// Connection Set 
$conn = new dbconnect();
$conn -> onjonCon(); 

// Set A Varialbe so that no one can have the access to "natasha.php"
$message = "Natasha I Love You!!!" ;
include( "natasha.php" );

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
    	<!-- Download Request Handler Start -->
        <center>
    <?php 
        // Prefix 
        $prefix = "check/" ;
        
        // Declarer Files 
        $folder_name = showFolders( $prefix );
        // Get Total Folders 
        $totalFolder = sizeof( $folder_name );  
        // Check Submit or Not 
        if( $fl == 1 ) {
            // Set A Counter 
            $c = 1 ; 
            
            // Get Folder Name and Senitize 
            // $folderName = mysql_real_escape_string( $_POST[ 'folder_name' ] ); 
            $reqUserId = mysql_real_escape_string( $_POST[ 'doc_user_id' ] );
            $reqDate = mysql_real_escape_string( $_POST[ 'doc_date' ] );
            $reqDate1 = date( 'd-m-Y' , strtotime( $reqDate ) );
            $folderName = "[".$reqUserId."@".$reqDate1."]" ; 
            if( file_exists( "check/" . $folderName ) ) {
            
                // Create Article Doc 
                $getDoc -> setData( $reqUserId , date( 'Y-m-d' , strtotime( $reqDate ) ) );
                // Get Data 
                $art_res = $getDoc -> getResult();
                if( $art_res == 1 ) {
                    $art_title = $getDoc -> getTitle();
                    $art_details = $getDoc -> getDetails();
                    $art_city = $getDoc -> getCity();
                    
                    $total_art = sizeof( $art_title );
                    // File Write 
                    $my_file_doc = "check/" . $folderName . "/articles.doc" ;
                    $handle = fopen($my_file_doc, 'w') ;
                    
                    $data = "" ; 
                    for( $i = 0 ; $i < $total_art ; $i++ ) {
                        $data .= "Title: " . $art_title[ $i ] . "\r\n" ;
                        $data .= "City: " . $art_city[ $i ] . "\r\n" ;
                        $data .= "\r\n" . $art_details[ $i ] . "\r\n" ;
                        $data .= "------------------------------------------\r\n" ;
                        $data .= "\r\n" ;
                    }
                    // Now Write into Doc File 
                    fwrite($handle, $data);
                    fclose( $handle );
                    // Call Files Crawler 
                    $files = showFiles( $prefix . $folderName . "/" );
                    
                    // Set Source and Destination 
                    $source = $prefix . $folderName ;
                    $destination = 'temp/' ;
                    
                    // Create Zip 
                    $zipResult = $makeZip -> compress( $source , $destination );
                    if( strlen( $zipResult ) >= 1 ) {
                        
                        // Encrypt File Name 
                        $aa = base64_encode( getFileName( $zipResult ) );
                        // Set Download URL with File Name 
                        $donwloadURL = "temp/download.php?file_name=" . $aa ; 
                        // Redirect for Download 
                        echo "<meta HTTP-EQUIV='refresh' content='0;url=".$donwloadURL."'>";
                        unlink( $my_file_doc );
                        
                    }
                }
                else {
                    echo "<font color='red'>No Article Found!!!</font>";
                }
            }
            else {
                echo "<font color='red'>No Articles Available!!!</font>";
            }
        }
        ?>
        </center>
    <!-- Download Request End -->
        <div class="g12 widgets">
            <table class="datatable">
				<thead>
					<tr>
                    	<th>Date</th>
                        <th>Number of Artcle</th>
                        <th>View</th>
					</tr>
				</thead>
				<tbody>
                    <!-- 
					<?php
						while($row = mysql_fetch_array($result))
						{
						echo '  <tr class="gradeX">
                                <td>'.date('d-m-Y').'</td>
                                <td>'.$row['fname'].' '.$row['lname'].'</td>
                                <td>'.$row['email'].'</td>
                                <td>'.$row['rate'].'</td>
                                <td class="c">20 <a href="#"> /Show all</a></td>
                                <td class="c"><button type="button" onClick="doSubmit( '.$row['id'].' , \''.date('Y-m-d').'\' );" >Download</button></td>';
                                
                            echo '</tr>';
						}
					?>
                    -->
                    <?php  
                    if( $getShortDocRes == 1 ) {
                        $getShortDate = $getShortDoc -> getDT();
                        $getTotalDocPerDay = $getShortDoc -> getTotal();
                        
                        $totalDoc = sizeof( $getShortDate );
                        for( $i = 0 ; $i < $totalDoc ; $i++ ) {
                    ?>
                      <tr class="gradeX">
                        <td><?=$getShortDate[ $i ];?></td>
                        <td><b><?=$getTotalDocPerDay[ $i ];?></b></td>
                        <td><button type="button" onClick="showDoc( '<?=$getShortDate[ $i ];?>' );">View All</button></td>
                        <!-- <td class="c"><button type="button" onClick="doSubmit( 31 , '2014-02-19' );" >Download</button></td> -->
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            
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