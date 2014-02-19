$(document).ready(function() {
						   
						   
	var $body = $('body'),
		$content = $('#content'),
		$form = $content.find('#loginform');
	
		
		//IE doen't like that fadein
		if(!$.browser.msie) $body.fadeTo(0,0.0).delay(20).fadeTo(100, 1);
		
		
		$("input").uniform();
		

		$form.wl_Form({
			status:false,
			onBeforeSubmit: function(data){
				$form.wl_Form('set','sent',false);
				if(data.username || data.password){
					location.href="parse/login.php?user="+data.username+"&pass="+data.password;
					
				}else{
					$('#loginform').effect( "shake" );
					$.wl_Alert('Please provide something!','info','#content');
				}
				return false;

			}
										  
		});
		
		
});