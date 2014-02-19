<?php 
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		//AJAX Request
		//echo json_encode($_POST[]);
		$data['data']=array(
		'fname'=>$_POST['fname'],
		'lname'=>$_POST['lname'],
		'email'=>$_POST['email'],
		'amount'=>$_POST['amount']
		);		
		echo print_r($data);
	}else{
		//Native Form Submit
		echo '<br><textarea style="width:100%;height:90%">'.print_r($_POST, true).'</textarea>';
	}
	

?>
