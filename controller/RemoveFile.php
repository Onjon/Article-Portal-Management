<?php
/*
@Author Name : Onjon Shahadat Hossain
@Email : onjon_sh@yahoo.com

@Project Name : Download Folder AS zip
@Version : 1.0.1
@Release Date : 18th February, 2014
*/ 

final class RemoveFile {
    // Create A Static Method 
    public static function remove( $fileParam ) {
        // Check File Exists 
        if( file_exists( $fileParam ) ) {
            // Remove The File
            unlink( $fileParam );
            echo "Okay";
        }
        else {
            echo "Not Okay ";
        }
    }
}
?>