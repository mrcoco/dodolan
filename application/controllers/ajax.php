<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Ajax extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	//php 4 constructor
	function Ajax() {
		parent::Controller();
	}
	
	function index() {
		
	}
	function loadmsg(){
	$render['msg'] = $this->messages->get();
		if(is_array($render['msg'])){
			$data['status'] = 'on';
			$data['msg']   = $render['msg'];
			echo json_encode($data);
		}else{
			$data['status'] = 'off';
			echo json_encode($data);	
		}
	}
	function js_showmsg(){
		echo ("
		<script>
			function loadmsg(){
			$.ajax({
			  url: '".site_url('ajax/loadmsg')."',
			  dataType: 'json',
			  success: function(data){
					if(data.status == 'on'){
						var msg = data.msg
						$.each(msg, function(index, value){	
							if(value.length > 0){
								if(value.length > 1 ){
										var content = '';
										$.each(value, function(key, val){
											content += val+'<br/>';
										});
								}
								else{
									var content = value;
								}
								$.jGrowl(content, {position: 'center', header: index, theme: index });
							}
						});
								
					}	
				},
				global : false,
				
			});
			}
			function retrive_msg(){
				$(document).ajaxStop(function(){
					loadmsg();
				});
			}
			$(document).ready(function(){
				retrive_msg();
				loadmsg();
			});
	
		</script>
		");--git= 
	}
	
	function post(){
	    $action = current_url();
        $this->load->helper('string');
        
	}

}
