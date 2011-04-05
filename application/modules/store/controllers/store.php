<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Store extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		$this->load->model('store_m');
	}
	
	//php 4 constructor
	function Store() {
		parent::Controller();
	}
	
	function index() {
		$data['data'] = 'asuh';
		$this->theme->render($data);
	}
	function test(){
		$source = $this->yh_conv->conv(1, 'USD', 'IDR');
		echo $source;
		
	}
	function addToCartForm($attribute, $product){
		$data = array(
			'a' => $attribute,
			'p' => $product
			);
		$this->load->view('store/misc/addtocart_form_v', $data);
	}
	function request_restock($data=array()){
		$this->load->view('store/misc/request_restockform_v', $data);
	}
	function exe_requestRestock(){
		$data = array(
			'email'=>$this->input->post('email'),
			'name'=> $this->input->post('name'),
			'id_prod' => $this->input->post('id_prod'),
				);
		if($this->input->post('id_attrb')){
		$data['id_attrb'] = $this->input->post('id_attrb');
		}
		$q = $this->store_m->add_request_restock($data);
		if($q){
			$this->messages->add('your request successfully added', 'success');
		}else{
			$this->messages->add('you seem already request restock from this product');
		}
	}
	function ajax_requestRestock(){
		if($this->input->post('email')){
		$ins_data = array(
			'email'=>$this->input->post('email'),
			'name'=> $this->input->post('name'),
			'id_prod' => $this->input->post('id_prod'),
			'c_date' => date('Y-m-d H:i:s'),
				);
		if($this->input->post('id_attrb')){
		$ins_data['id_attrb'] = $this->input->post('id_attrb');
		}
		$q = $this->store_m->add_request_restock($ins_data);
		if($q){
			$data['status'] = 'on';
			$data['msg']    = 'your request successfully added';
			echo json_encode($data);
		}else{
			$data['status'] = 'off';
			$data['msg']    = 'you seem already request restock from this product';
			echo json_encode($data);
		}
	}
	}
	function getCountry($id){
	return	$this->store_m->get_country($id);
	}
	function payprocessing(){
		$id = $this->session->userdata('order_id');
		$data['form'] = modules::run('paypal/generate_form', $id);
		$data['loadSide'] = false;
		$data['mainLayer'] = 'store/page/checkout/payProcessing_v';
		$this->theme->render($data);
	}

}?>