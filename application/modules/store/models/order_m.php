<?php 

if (! defined('BASEPATH')) exit('No direct script access');



class Order_m extends Model {

	//php 5 constructor
	function __construct() {
		parent::Model();
	}
	
	//php 4 constructor
	function Order_m() {
		parent::Model();
	}
	
	// Group Function Admin Order
	/////////////////////////////
	
	/**
	 * browse order
	 *
	 * @param array $param 
	 *			    'query', 'status', 'start', 'end', limit
	 * @return void
	 * @author Zidni Mubarock
	 */
	function browse_order($param=array()){
		//defaul param
		//$start = 0; $end = 10;	
		if(isset($param['start'])){
		$start = $param['start'] ;
		}
		if(isset($param['end'])){
		$end  = $param['end'] ;	
		}
		
		$this->db->select('a.id');
		$this->db->select('a.status');
		$this->db->from('store_order as a');
		$this->db->query('SET @rows = FOUND_ROWS()');
		//$this->db->query('SELECT SQL_CALC_FOUND_ROWS');
		//$this->db->query('set @rows = FOUND_ROWS()');
		// if search by query
	
		if(isset($param['query'])){
			$this->db->join('store_order_personal_data as b', 'b.order_id=a.id' );
			$this->db->join('store_order_shipto_data as c', 'c.order_id=a.id' );
			$this->db->like('b.first_name', $param['query']);
			$this->db->or_like('b.last_name', $param['query']);
			$this->db->or_like('b.email', $param['query']);
			$this->db->or_like('c.first_name', $param['query']);
			$this->db->or_like('c.last_name', $param['query']);
		}
		// if order id set
		if(isset($param['order_id'])){
			$this->db->where('a.id', $param['order_id']);
		}
		// if search by order_status
		
		if(isset($param['status'])){
			$this->db->where('a.status', $param['status']);
		}
	
		$q = $this->db->get('', $end, $start);
		$q2 = $this->db->query('SELECT FOUND_ROWS() as rowcount');
		
		if($q->num_rows() < 1){
			return false;
		}else{
			$data['orders'] = $q->result();
			$data['number_rec'] = $q2->result(); 
			return $data; 
		}
		
	}
	
	
	
	
	//  end of Group Function Admin Order
	/////////////////////////////////////
	
	
	// Group Function CREATE ORDER
	//////////////////////////////
	function open_order(){
		$data = array('c_date' => date('Y-m-d H:i:s'));
		$q = $this->db->insert('store_order', $data);
		return $this->db->insert_id();
	}
	// $param = {order_data, personal_data, shipto_data, product_sold_data}
	function insert_order($param=array(), $id){
		// insert store_order, which actally update the record with complete data;
		$this->db->where('id', $id);
		$order = $this->db->update('store_order', $param['order_data']);
		// insert personal data
	if($order){
		$personal_data = $this->insert_personal_data($param['personal_data']);
		// insert shipto_data
		$shipto_data = $this->insert_shipto_data($param['shipto_data']);
		// insert product_sold_data
		$product_sold_data = $this->insert_product_sold_data($param['product_sold_data']);
		return $id;
	}else{
		return false;
	}
		
	}
	function insert_personal_data($data){
		$q = $this->db->insert('store_order_personal_data', $data);
		return true;
		
	}
	function insert_shipto_data($data){
		$q = $this->db->insert('store_order_shipto_data', $data);
		return true;
	}
	function insert_product_sold_data($data){
		$i = 0;
		foreach($data as $d){
			$q = $this->db->insert('product_sold_data', $d);
			$id[$i] = $this->db->insert_id();
			$i++;
		}
		if(count($data) == count($id)){
			return true;
		}else{
			return false;
		}
	}
	// end of Group Function CREATE ORDER
	////////////////////////////////////
	
	function getall_orderdata($id){
		$data['order'] = $this->getOrder($id);
		if($data['order']){
			$data['personal_data'] = $this->get_personal_data($id);
			$data['shipto_data'] = $this->get_shipto_data($id);
			$data['prodsold_data'] = $this->get_prodsold_data($id);
			return $data;
		}else{
			return false;
		}
	
	}
	
	
	function getOrder($id){
		$this->db->where('id', $id);
		$q = $this->db->get('store_order');
		if($q->num_rows() == 1){
			$order = $q->row();
		}else{
			$order = false;
		}
		return $order;
	}
	
	function get_personal_data($id_order){
		$this->db->where('order_id', $id_order);
		$q2 = $this->db->get('store_order_personal_data');
		if($q2->num_rows() == 1){
			$personal_data = $q2->row();
		}else{
			$personal_data = false;
		}
		return $personal_data;
	}

	function get_shipto_data($id_order){
		$this->db->where('order_id', $id_order);
		$q3 = $this->db->get('store_order_shipto_data');
		if($q3->num_rows() == 1){
			$shipto_data = $q3->row();
		}else{
			$shipto_data = false;
		}
		return $shipto_data;
	}
	function get_prodsold_data($id_order){
		$this->db->where('order_id', $id_order);
		$q4 = $this->db->get('product_sold_data');
		if($q4->num_rows() >0 ){
			$product_sold_data = $q4->result();
		}else{
			$product_sold_data = false;
		}
		return $product_sold_data;
	}
	
	function function_name() {
		
	}

}?>                                            