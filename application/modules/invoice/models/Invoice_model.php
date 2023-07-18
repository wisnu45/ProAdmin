<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Setting_model Class extends CI_Model
 *
 */
class Invoice_model extends CI_Model {       
	function __construct(){            
	   parent::__construct();
	   $this->load->database();
	   $this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';
	} 
   
	public function add_edit()
	{	
		if($this->input->post('id') && $this->input->post('id') != '')
		{
			
			$data['customer_name'] = $this->input->post('customer_name');
			$data['status'] = $this->input->post('status');
			$data['subtotal'] = str_replace(',', '', $this->input->post('subtotal'));
			$data['total'] = str_replace(',', '', $this->input->post('grandtotal'));
			$data['build_date'] = date('Y-m-d', strtotime($this->input->post('build_date')));
			$data['due_date'] = date('Y-m-d', strtotime($this->input->post('due_date')));
			$data['discount'] = $this->input->post('discount');
			$data['discount_type'] = $this->input->post('discount_type');
			foreach ($this->input->post('product_name') as $key => $value) {
				$pro_id = $this->get_product_id($value, $this->input->post('quantity')[$key], $this->input->post('unitprice')[$key]);

				$np_data[$key]['product_id'] =  $pro_id;
				$np_data[$key]['product_name'] =  $value;
				$np_data[$key]['quantity'] =  $this->input->post('quantity')[$key];
				$np_data[$key]['unitprice'] =  $this->input->post('unitprice')[$key];
				$np_data[$key]['total'] =  $this->input->post('total')[$key];
				$np_data[$key]['unit'] =  $this->input->post('unit')[$key];

				$this->UpdateNewQuantityOnInvoiceEdit($pro_id, $this->input->post('quantity')[$key], $this->input->post('id'));
			}
			$data['product_details'] = json_encode($np_data);
				

			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(",", $dvalue); 
				}
			}


			$this->db->where('invoice_id', $this->input->post('id'));
			$this->db->update('invoice', $data);

			if($this->input->post('mkacf')) {
				$id = $this->input->post('id');
                $custom_fields = $this->input->post('mkacf');
                if(!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                        $qr = "SELECT * FROM `cf_values` WHERE `rel_crud_id` = '".$id."' AND `cf_id` = '".$cfkey."'";
                        $cf_data = $this->db->query($qr)->result();
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $id,
                                    "cf_id" => $cfkey,
                                    "curd" => 'invoice_list',
                                    "value" => $cfvalue,
                                );
                            $this->insertRow('cf_values', $d);
                        }
                    }
                }
            }
			
			return $this->input->post('id');
		} else { 
			$data['customer_name'] = $this->input->post('customer_name');
			$data['user_id'] = $this->user_id;
			$data['status'] = $this->input->post('status');
			$data['total'] = $this->input->post('grandtotal');
			$data['subtotal'] = $this->input->post('subtotal');
			$data['build_date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('build_date'))));
			$data['due_date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('due_date'))));
			$data['discount'] = $this->input->post('discount');
			$data['discount_type'] = $this->input->post('discount_type');
			foreach ($this->input->post('product_name') as $key => $value) {
				$pro_id = $this->get_product_id($value, $this->input->post('quantity')[$key], $this->input->post('unitprice')[$key]);

				$np_data[$key]['product_id'] =  $pro_id;
				$np_data[$key]['product_name'] =  $value;
				$np_data[$key]['quantity'] =  $this->input->post('quantity')[$key];
				$np_data[$key]['unitprice'] =  $this->input->post('unitprice')[$key];
				$np_data[$key]['total'] =  $this->input->post('total')[$key];
				$np_data[$key]['unit'] =  $this->input->post('unit')[$key];

				$this->update_new_quantity($pro_id, $this->input->post('quantity')[$key]);
			}

			$data['product_details'] = json_encode($np_data);
			

			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(",", $dvalue); 
				}
			}

			$this->db->insert('invoice',$data);
			$insert_id = $this->db->insert_id();

			if($this->input->post('mkacf')) {
				$custom_fields = $this->input->post('mkacf');
                foreach ($custom_fields as $cfkey => $cfvalue) {
                    $d = array(
                                "rel_crud_id" => $insert_id,
                                "cf_id" => $cfkey,
                                "curd" => 'invoice_list',
                                "value" => $cfvalue,
                            );
                    $this->insertRow('cf_values', $d);
                }
            }
            return $insert_id;
		}
	
	}

	public function get_data_by($tableName='', $id='', $colum='')
	{	
		if((!empty($id)) && (!empty($colum)))
		{ $this->db->where($colum, $id);}
		$this->db->select('*');
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
   }
	
	public function Get_invoioce_id($id='')
	{
		 $this->db->select('*');
		 $this->db->from('invoice');
		 $this->db->where('invoice_id' , $id);
		 $query = $this->db->get();
		 return $result = $query->row();
	}

	public function getInvoiceDetail($id){
		$this->db->where('invoice_id', $id);
		$this->db->join('customers', 'invoice.invoice_id = customers.customers_id', 'left');
		return $this->db->get('invoice')->row();
	}
	
	public function get_data()
	{
		$this->db->select('*');
		$this->db->from('setting');
		$query = $this->db->get();
		return $result = $query->result();
	}

	public function get_all_customers(){
		$this->db->select('*');
		$this->db->from('customers');
		$query = $this->db->get();
		return $result = $query->result();
	}

	public function getproducts($keyword, $except){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where_not_in('products_id', $except);
		$this->db->like('product_name', $keyword);
		$query = $this->db->get();
		return $result = $query->result();
	}

	public function delete_data($id='')
	{
		$this->db->where('invoice_id', $id);
        $this->db->delete('invoice');
	}


	/**
      * This function is used to Insert Record in table
      * @param : $table - table name in which you want to insert record 
      * @param : $data - record array 
      */
	public function insertRow($table, $data){
	  	$this->db->insert($table, $data);
	  	return  $this->db->insert_id();
	}

	/**
      * This function is used to Update Record in table
      * @param : $table - table name in which you want to update record 
      * @param : $col - field name for where clause 
      * @param : $colVal - field value for where clause 
      * @param : $data - updated array 
      */
  	public function updateRow($table, $col, $colVal, $data) {
  		$this->db->where($col,$colVal);
		$this->db->update($table,$data);
		return true;
  	}

  	public function get_product_id($pro_name, $quantity, $unitprice) {
  		$this->db->select('products_id');
		$this->db->from('products');
		$this->db->where('product_name', $pro_name);
		$this->db->where('unit_price', $unitprice);
		$query = $this->db->get();
		$result = $query->result();

		if(isset($result) && !empty($result)){
			return $result[0]->products_id;
		}else{
			$data['user_id'] = $this->user_id;
			$data['product_name'] = $pro_name;
			$data['quantity'] = $quantity;
			$data['unit_price'] = $unitprice;
			$id = $this->insertRow('products', $data);
			return $id;
		}
		
  	}

  	public function update_new_quantity($pro_id, $quantity, $sign = '') {
        $products = $this->invoice_model->get_data_by('products', $pro_id, 'products_id');
 
        if (isset($products) && !empty($products)) {
        	if(!empty($sign) && $sign == 'add'){
        		$difference = (int) $products[0]->quantity + abs((int) $quantity);
        	}else if(empty($sign)){
        		$difference = (int) $products[0]->quantity - (int) $quantity;
        	}
            
          	$data['quantity'] = $difference;
			$id = $this->updateRow('products', 'products_id', $pro_id, $data);
        }          
    }

    public function UpdateNewQuantityOnInvoiceEdit($pro_id, $quantity, $invoice_id) {
        $invoice_details = $this->getInvoiceDetail($invoice_id);
        $product_details = json_decode($invoice_details->product_details);
        if(!search_in_array_obj($product_details, 'product_id', $pro_id)) {
        	$this->update_new_quantity($pro_id, $quantity);
        }
        foreach ($product_details as $key => $value) {
        	if($value->product_id == $pro_id){
        		$difference = (int) $quantity - (int) $value->quantity;
        		if($difference > 0){
	                $this->update_new_quantity($pro_id, $difference);
	            }else if($difference < 0){
	                $this->update_new_quantity($pro_id, $difference, 'add');
	            }
        	}
        }
    }
	
}?>