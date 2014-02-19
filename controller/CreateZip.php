<?php
/*
@Author Name : Onjon Shahadat Hossain
@Email : onjon_sh@yahoo.com

@Project Name : Download Folder AS zip
@Version : 1.0.1
@Release Date : 18th February, 2014
*/ 


// Declare as "Final" so that no one can Extend this class 
final class CreateZip {
    
    private function recursiveZip( $source , &$zip , $path ) {
    
        // Open file/directory
        $dir = opendir($source);
        
        // Loop through the directory 
        while(false !== ( $file = readdir($dir)) ) {
            
            // Skip parent (..) and root (.) directory
            if ( ( $file != '.' ) && ( $file != '..' ) ) {
                
                // if directory found again, call recursiveZip() function again
                if ( is_dir( $source . '/' . $file ) ) {
                    $this->recursiveZip($source . '/' . $file,$zip,$path);
                }
                else {
                    // Add files to zip
                    $zip->addFile($source . '/' . $file,substr($source . '/' . $file,$path));
                }
            }
        }
        closedir($dir);
    }
    
    // Call This Method for Create Zip 
    public function compress( $source , $destination='' ) {
        
        // check zip extension loaded or not 
        // check soure file/directory exists or not
        if (!extension_loaded('zip') || !file_exists($source) ) {
            return false;
        }        
        
        // Remove last slash (/) from source directory / destination directory
        if(substr($source,-1)==='/'){
            $source=substr($source,0,-1);        
        }
        if(substr($destination,-1)==='/'){
            $destination=substr($destination,0,-1);           
        }
        $path=strlen(dirname($source).'/');
        
        
        $filename = substr( $source , strrpos( $source , '/' ) ).'.zip' ;
        $destination = empty($destination)? $filename : $destination.'/'.$filename;
        @unlink($destination);

        // Create the Zip 
        $zip = new ZipArchive;
        $res = $zip->open( $destination , ZipArchive::CREATE );
        if( $res !== TRUE ) {
            echo 'Error: Unable to create zip file';
            exit;
        }
        if( is_file( $source ) ) { 
                $zip->addFile($source,substr($source,$path));
        }
        else {
            if( !is_dir( $source ) ){
                $zip -> close();
                @unlink( $destination );
                echo 'Error: File not found';
                exit() ;
            }
            $this->recursiveZip($source,$zip,$path);
        }
        $zip->close();
        return $destination ; 
    }
} 
?>