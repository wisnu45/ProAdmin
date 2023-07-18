<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Invoice extends CI_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model("invoice_model"); 
        $this->load->model("Customers_model"); 
        $this->load->model("Products_model"); 
        $this->lang->load(strtolower('Products'), setting_all('language'));
        $this->lang->load(strtolower('Customers'), setting_all('language'));
        $this->load->database();
        if($this->uri->segment(2) != 'recurring'){
            
            $this->user_id =isset($this->session->get_userdata()['user_details'][0]->ia_users_id)?$this->session->get_userdata()['user_details'][0]->ia_users_id:'1';
        }else{  
            $this->user_id = 1;
        }
        $this->lang->load('invoice', setting_all('language'));
        
    }

    public function index($id = '')
    {  
        $data['title'] = 'Add Invoice';
        $data['setting'] = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
        $data['build_date'] = date($data['setting'][0]->date_formate, strtotime("now"));
        $data['due_date'] = date($data['setting'][0]->date_formate, strtotime( date($data['setting'][0]->date_formate, strtotime($data['build_date'])).' + 15 days' ));
        $data['customers'] = $this->invoice_model->get_all_customers();
        $this->load->view('include/header');
        if (CheckPermission("invoice", "own_create")) {
            $this->load->view('index_invoice',$data);
        }
        else {
            echo '<section class="content">
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 invice">
                        <div class="card">
                            <div class="header">
                                <h2>Invoice</h2>
                            </div>
                            <div class="body" style="text-align: center;">
                                <h5>You do not have permission to view this.</h5>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </section>';
        }
        $this->load->view('include/footer');
        
    }

    public function customers_index() {
        $con = '';
        
        $data["view_data"]= $this->Customers_model->get_data($con);
        if($con == '') {
            $this->load->view("include/header");
        }
        $data["obj"] = $this;
        $this->load->view("index_customer",$data);
        if($con == '') {
            $this->load->view("include/footer");
        }
    }

    public function products_index() {   
        $con = '';
        
        $data["view_data"]= $this->Products_model->get_data($con);
        if($con == '') {
            $this->load->view("include/header");
        }
        $data["obj"] = $this;
        $this->load->view("index_product",$data);
        if($con == '') {
            $this->load->view("include/footer");
        }
    }


    public function get_filter_html($ajax = 0) {
        $filter_coo = '';
        if(isset($_COOKIE[strtolower('Customers_filter')])) {
            $filter_coo = json_decode($_COOKIE[strtolower('Customers_filter')]);
        }
        $html = '';
        if($ajax == 1) {
            echo $html; exit;
        } else {
            return $html;
        }
    }

    public function get_filter_html_products($ajax = 0) {
        $filter_coo = '';
        if(isset($_COOKIE[strtolower('Products_filter')])) {
            $filter_coo = json_decode($_COOKIE[strtolower('Products_filter')]);
        }
        $html = '';
        if($ajax == 1) {
            echo $html; exit;
        } else {
            return $html;
        }
    }


    public function get_filter_dropdown_options($field, $rel_table, $rel_col, $selected) {
        $res = $this->Customers_model->get_filter_dropdown_options($field, $rel_table, $rel_col);
        $option = '';
        if(isset($res) && is_array($res) && !empty($res)) {
            foreach ($res as $key => $value) {
                if($rel_table != '') {
                    $col = $rel_table.'_id';
                    $se = '';
                    if($selected == $value->$col) {
                        $se = 'selected';
                    }
                    $option .= '<option '.$se.' value="'.$value->$col.'">'.char_limit(ucfirst($value->$rel_col), 30).'</option>';   
                } else {
                    $se = '';
                    if($selected == $value->$field) {
                        $se = 'selected';
                    }
                    $option .= '<option '.$se.' value="'.$value->$field.'">'.char_limit(ucfirst($value->$field), 30).'</option>';
                }
            }
        }
        return $option;
    }

    public function get_filter_dropdown_options_products($field, $rel_table, $rel_col, $selected) {
        $res = $this->Products_model->get_filter_dropdown_options($field, $rel_table, $rel_col);
        $option = '';
        if(isset($res) && is_array($res) && !empty($res)) {
            foreach ($res as $key => $value) {
                if($rel_table != '') {
                    $col = $rel_table.'_id';
                    $se = '';
                    if($selected == $value->$col) {
                        $se = 'selected';
                    }
                    $option .= '<option '.$se.' value="'.$value->$col.'">'.char_limit(ucfirst($value->$rel_col), 30).'</option>';   
                } else {
                    $se = '';
                    if($selected == $value->$field) {
                        $se = 'selected';
                    }
                    $option .= '<option '.$se.' value="'.$value->$field.'">'.char_limit(ucfirst($value->$field), 30).'</option>';
                }
            }
        }
        return $option;
    }
    

    public function view() {
        $data['setting'] = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
        $options = '';
        $status = $data['setting'][0]->invoice_status;
        $status = explode(',', $status);
        foreach ($status as $skey => $svalue) {
            $options .= '<option value="'.trim($svalue).'">'.trim(ucfirst($svalue)).'</option>';    
        }
        $data['status_option'] = $options;
        $data['customers'] = $this->invoice_model->get_all_customers();
        $this->load->view('include/header');
        if (CheckPermission("invoice", "own_read")) {
            $this->load->view('view_invoice',$data);
        }
        else {
            echo '<section class="content">
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 invice">
                        <div class="card">
                            <div class="header">
                                <h2>Invoice</h2>
                            </div>
                            <div class="body" style="text-align: center;">
                                <h5>You do not have permission to view this.</h5>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </section>';
        }
        $this->load->view('include/footer');
    }

    public function edit($id) {
        if(isset($id) && $id > 0) {
            $inv_row = $this->invoice_model->get_data_by('invoice', $id, 'invoice_id');
            $data['result'] = $inv_row[0];
            $data['title'] = 'Edit Invoice';
            $data['setting'] = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
            $data['customers'] = $this->invoice_model->get_all_customers();
            $this->load->view('include/header');
            $this->load->view('index_invoice', $data); 
            $this->load->view('include/footer');
        } else {
            
        }
    }

    /*  Insert Update data */
    public function add_edit()
    {
        
        $res = $this->invoice_model->add_edit();
        $redirectTo = base_url().'invoice/view';
        $file = $this->generatePdf($res);
        $inst_arr['file_name'] = $file;
        if($this->input->post('id') && $this->input->post('id') != ''){
            if($this->input->post('view') && $this->input->post('view') == 'view') {
                $redirectTo = base_url().'invoice/edit/'.$this->input->post('id');
                $this->session->set_userdata('view_invoice', $file);
            } else {
                $this->session->set_flashdata('messagePr', 'Your data updated successfully..');
            }
        } else {
            $inv_setting = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
            $invoice_id_prefix = $inv_setting[0]->invoice_prefix; 
            $invoice_id_prefix = explode('-', $invoice_id_prefix);
            $invoice_id_prefix[1] = $invoice_id_prefix[1] + $res;
            $invoice_id = implode('-', $invoice_id_prefix);
            $inst_arr['invoice_no'] = $invoice_id;  
            $redirectTo = base_url().'invoice/edit/'.$res;  
            $this->session->set_userdata('view_invoice', $file);
        }
        $this->invoice_model->updateRow('invoice', 'invoice_id', $res, $inst_arr);
        $art_msg['msg'] = lang('action_performed_successfully'); 
        $art_msg['type'] = 'success'; 
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect($redirectTo);
    }

    public function add_edit_customers() {    
        $data = $this->input->post();
        $postoldfiles = array();
        foreach ($data as $okey => $ovalue) {
            if(strstr($okey, "wpb_old_")) {
            $postoldfiles[$okey]=$ovalue;
            }
        }
        foreach ($_FILES as $fkey => $fvalue) {
            $config['upload_path'] = 'assets/images/';
            $config['upload_url'] =  base_url().'assets/images/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = 5000; 
            $this->load->library('upload', $config);
            foreach($fvalue['name'] as $key => $fileInfo) {
                if(!empty($_FILES[$fkey]['name'][$key])){
                    $filename = str_replace(' ', '_', $_FILES[$fkey]['name'][$key]);
                    $tmpname=$_FILES[$fkey]['tmp_name'][$key]; 
                    $exp=explode('.', $filename);
                    $ext=end($exp);
                    $newname =  strtolower($exp[0]).'_'.time().".".$ext; 

                    $_FILES['mka_file']['name']     = $newname;
                    $_FILES['mka_file']['type']     = $_FILES[$fkey]['type'][$key];
                    $_FILES['mka_file']['tmp_name'] = $_FILES[$fkey]['tmp_name'][$key];
                    $_FILES['mka_file']['error']    = $_FILES[$fkey]['error'][$key];
                    $_FILES['mka_file']['size']     = $_FILES[$fkey]['size'][$key];
                    if ( $this->upload->do_upload('mka_file')) {
                        $newfiles[$fkey][]=$newname;
                    }
                }
                else{
                    $newfiles[$fkey]='';
            
                }
            }
            if(!empty($postoldfiles)) {

                if(!empty($postoldfiles['wpb_old_'.$fkey])){
                    $oldfiles = $postoldfiles['wpb_old_'.$fkey];
                }
                else{
                    $oldfiles = array();
                }
                if(!empty($newfiles[$fkey])){
                    $all_files = array_merge($oldfiles,$newfiles[$fkey]);   
                }
                else{
                    $all_files = $postoldfiles['wpb_old_'.$fkey];
                }
                    
            }
            else{
                $all_files = $newfiles[$fkey];
            }
            if(is_array($all_files) && !empty($all_files)) {
                $data[$fkey] = implode(',', $all_files);
            }
        }
        if($this->input->post('id')) {
            foreach ($postoldfiles as $pkey => $pvalue) {
                unset($data[$pkey]);        
            }
            unset($data['submit']);
            unset($data['save']);
            unset($data['id']);

            if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
                if(!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                        if(is_array($cfvalue)) {
                            $custom_fields[$cfkey] = implode(',', $cfvalue);
                            $cfvalue = implode(',', $cfvalue);
                        }
                        $qr = "SELECT * FROM `cf_values` WHERE `rel_crud_id` = '".$this->input->post('id')."' AND `cf_id` = '".$cfkey."'";
                        $cf_data = $this->Customers_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Customers_model->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'customers',
                                    "value" => $cfvalue,
                                );
                            $this->Customers_model->insertRow('cf_values', $d);
                        }
                    }
                }
            }
            
            foreach ($data as $dkey => $dvalue) {
                if(is_array($dvalue)) {
                    $data[$dkey] = implode(',', $dvalue); 
                }
            }
            $this->Customers_model->updateRow('customers', 'customers_id', $this->input->post('id'), $data);
            echo $this->input->post('id'); 
            exit;
        } else { 
            unset($data['submit']);
            unset($data['save']);
            $data['user_id']=$this->user_id;
            if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
            }
            foreach ($data as $dkey => $dvalue) {
                if(is_array($dvalue)) {
                    $data[$dkey] = implode(',', $dvalue); 
                }
            }
            $this->session->set_flashdata('message', 'Your data inserted Successfully..');
            // print_r($this->user_id);die();
            $last_id = $this->Customers_model->insertRow('customers', $data);
            if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                    if(is_array($cfvalue)) {
                        $cfvalue = implode(',', $cfvalue);
                    }
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'customers',
                                "value" => $cfvalue,
                            );
                    $this->Customers_model->insertRow('cf_values', $d);
                }
            }
            echo $last_id;
            exit;
            /*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
            redirect('customers');*/
        }
    }

    public function add_edit_products() {    
        $data = $this->input->post();
        $postoldfiles = array();
        foreach ($data as $okey => $ovalue) {
            if(strstr($okey, "wpb_old_")) {
            $postoldfiles[$okey]=$ovalue;
            }
        }
        foreach ($_FILES as $fkey => $fvalue) {
            $config['upload_path'] = 'assets/images/';
            $config['upload_url'] =  base_url().'assets/images/';
            $config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
            $config['max_size'] = 5000; 
            $this->load->library('upload', $config);
            foreach($fvalue['name'] as $key => $fileInfo) {
                if(!empty($_FILES[$fkey]['name'][$key])){
                    $filename = str_replace(' ', '_', $_FILES[$fkey]['name'][$key]);
                    $tmpname=$_FILES[$fkey]['tmp_name'][$key]; 
                    $exp=explode('.', $filename);
                    $ext=end($exp);
                    $newname =  strtolower($exp[0]).'_'.time().".".$ext; 

                    $_FILES['mka_file']['name']     = $newname;
                    $_FILES['mka_file']['type']     = $_FILES[$fkey]['type'][$key];
                    $_FILES['mka_file']['tmp_name'] = $_FILES[$fkey]['tmp_name'][$key];
                    $_FILES['mka_file']['error']    = $_FILES[$fkey]['error'][$key];
                    $_FILES['mka_file']['size']     = $_FILES[$fkey]['size'][$key];
                    if ( $this->upload->do_upload('mka_file')) {
                        $newfiles[$fkey][]=$newname;
                    }
                }
                else{
                    $newfiles[$fkey]='';
            
                }
            }
            if(!empty($postoldfiles)) {

                if(!empty($postoldfiles['wpb_old_'.$fkey])){
                    $oldfiles = $postoldfiles['wpb_old_'.$fkey];
                }
                else{
                    $oldfiles = array();
                }
                if(!empty($newfiles[$fkey])){
                    $all_files = array_merge($oldfiles,$newfiles[$fkey]);   
                }
                else{
                    $all_files = $postoldfiles['wpb_old_'.$fkey];
                }
                    
            }
            else{
                $all_files = $newfiles[$fkey];
            }
            if(is_array($all_files) && !empty($all_files)) {
                $data[$fkey] = implode(',', $all_files);
            }
        }
        if($this->input->post('id')) {
            foreach ($postoldfiles as $pkey => $pvalue) {
                unset($data[$pkey]);        
            }
            unset($data['submit']);
            unset($data['save']);
            unset($data['id']);

            if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
                if(!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                        if(is_array($cfvalue)) {
                            $custom_fields[$cfkey] = implode(',', $cfvalue);
                            $cfvalue = implode(',', $cfvalue);
                        }
                        $qr = "SELECT * FROM `cf_values` WHERE `rel_crud_id` = '".$this->input->post('id')."' AND `cf_id` = '".$cfkey."'";
                        $cf_data = $this->Products_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Products_model->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'products',
                                    "value" => $cfvalue,
                                );
                            $this->Products_model->insertRow('cf_values', $d);
                        }
                    }
                }
            }
            
            foreach ($data as $dkey => $dvalue) {
                if(is_array($dvalue)) {
                    $data[$dkey] = implode(',', $dvalue); 
                }
            }
            $this->Products_model->updateRow('products', 'products_id', $this->input->post('id'), $data);
            echo $this->input->post('id'); 
            exit;
        } else { 
            unset($data['submit']);
            unset($data['save']);
            $data['user_id']=$this->user_id;
            if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
            }
            foreach ($data as $dkey => $dvalue) {
                if(is_array($dvalue)) {
                    $data[$dkey] = implode(',', $dvalue); 
                }
            }
            $this->session->set_flashdata('message', 'Your data inserted Successfully..');
            $last_id = $this->Products_model->insertRow('products', $data);
            if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                    if(is_array($cfvalue)) {
                        $cfvalue = implode(',', $cfvalue);
                    }
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'products',
                                "value" => $cfvalue,
                            );
                    $this->Products_model->insertRow('cf_values', $d);
                }
            }
            echo $last_id;
            exit;
            /*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
            redirect('products');*/
        }
    }

    public function get_modal() {
        if($this->input->post('id')){
            $data['data']= $this->Customers_model->Get_data_id($this->input->post('id'));
            echo $this->load->view('add_update_customer', $data, true);
        } else {
            echo $this->load->view('add_update_customer', '', true);
        }
        exit;
    }
    
    public function get_modal_products() {
        if($this->input->post('id')){
            $data['data']= $this->Products_model->Get_data_id($this->input->post('id'));
            echo $this->load->view('add_update', $data, true);
        } else {
            echo $this->load->view('add_update', '', true);
        }
        exit;
    }

    public function dataTable (){
        $table = 'invoice';
        $primaryKey = 'invoice_id';

        $columns = array(
            array( 'db' => 'invoice.invoice_id', 'dt' => 0, 'field' => 'invoice_id' ),
            array( 'db' => 'invoice.date', 'dt' => 1, 'field' => 'date' ),
            array( 'db' => 'invoice.invoice_no',  'dt' => 2, 'field' => 'invoice_no' ),
            array( 'db' => 'customers0.name',  'dt' => 3, 'field' => 'name' ),
            array( 'db' => 'invoice.total',  'dt' => 4, 'field' => 'total' ),
            array( 'db' => 'invoice.status',  'dt' => 5, 'field' => 'status' ),
        );

        
        $joinQuery  = "FROM invoice LEFT JOIN  `customers` AS `customers0` ON (`customers0`.`customers_id` = `invoice`.`customer_name`) ";

        $cf = get_cf('invoice_list');
        if(is_array($cf) && !empty($cf)) {
            foreach ($cf as $cfkey => $cfvalue) {
                array_push($columns, array( 'db' => "cf_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));    
                $joinQuery  .=  " LEFT JOIN `cf_values` AS cf_values_".$cfkey."  ON  `invoice`.`invoice_id` = `cf_values_".$cfkey."`.`rel_crud_id` AND `cf_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
            }
        }

        array_push($columns, array( 'db' => 'invoice.invoice_id',  'dt' => count($columns), 'field' => 'invoice_id' ));

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        
        $where = '';
        if(CheckPermission("invoice", "all_read")){}
        else if(CheckPermission("invoice", "own_read")){ $where .= "`$table`.`user_id`=".$this->user_id;}    
        if($this->input->get('columnName1') && $this->input->get('columnName1') == 'date') {
            $date = explode(' - ', $this->input->get('columnVal1'));
            $and = '';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and." (DATE_FORMAT(`$table`.`date`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`date`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' )";
        }

        if($this->input->get('columnName2') && $this->input->get('columnName2') == 'status' && $this->input->get('columnVal2') != 'all') {
            $and = '';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and." `$table`.`status` = '".$this->input->get('columnVal2')."' ";
        }

        // echo $where; die;

        $output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where);
        //$output_arr = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns);

        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';

            if(CheckPermission("invoice", "all_read")){
                $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a class="mClass generateInv"  href="javascript:;" rel="'.$id.'" type="button" title="View"><i class="material-icons" data-id="">remove_red_eye</i></a>';
                }else if(CheckPermission("invoice", "own_read")){
                    $user_id =getRowByTableColomId($table,$id,'invoice_id','user_id');
                    if($user_id==$this->user_id){
                $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a class="mClass generateInv"  href="javascript:;" rel="'.$id.'" type="button" title="View"><i class="material-icons" data-id="">remove_red_eye</i></a>';
                    }
                }
                
            if(CheckPermission("invoice", "all_update")){
                $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="mClass"  href="edit/'.$id.'" type="button" title="Edit"><i class="material-icons" data-id="">edit</i></a>';
                }else if(CheckPermission("invoice", "own_update") && (CheckPermission($table, "all_update")!=true)){
                    $user_id =getRowByTableColomId($table,$id,'invoice_id','user_id');
                    if($user_id==$this->user_id){
                $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a id="btnEditRow" class="mClass"  href="edit/'.$id.'" type="button" title="Edit"><i class="material-icons" data-id="">edit</i></a>';
                    }
                }

                if(CheckPermission("invoice", "all_delete")){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="delete" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons text-red" >delete</i></a>';}
            else if(CheckPermission("invoice", "own_delete") && (CheckPermission($table, "all_delete")!=true)){
                $user_id =getRowByTableColomId($table,$id,'invoice_id','user_id');
                if($user_id==$this->user_id){
            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="delete" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons text-red" >delete</i></a>';
                }
            }

            $output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= ' <a href="javascript:;" class="invoice-mail" data-inv-id="'.$id.'" style="cursor:pointer;" title="Send mail"> <i class="material-icons">mail_outline</i></a>';
                
                
            $sett = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
                
            $output_arr['data'][$key][1] = date($sett[0]->date_formate, strtotime($output_arr['data'][$key][1]));
            $output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'" id="'.$output_arr['data'][$key][0].'" />
            <label for="'.$output_arr['data'][$key][0].'"></label>';

            //$output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
            $output_arr['data'][$key][5] = '<span class="changeStatus">'.$output_arr['data'][$key][5].'</span>';

        }
        echo json_encode($output_arr);
    }

    public function ajx_data(){
        $primaryKey = 'customers_id';
        $table      = 'customers';
        $joinQuery  =   "FROM `customers` ";
        $columns    = array(
array( 'db' => 'customers.customers_id AS customers_id', 'field' => 'customers_id', 'dt' => 0 ),
array( 'db' => 'customers.name AS name', 'field' => 'name', 'dt' => 1 ),
);

            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $cf = get_cf('customers');
            if(is_array($cf) && !empty($cf)) {
                foreach ($cf as $cfkey => $cfvalue) {
                    array_push($columns, array( 'db' => "cf_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));
                    $joinQuery  .=  " LEFT JOIN `cf_values` AS cf_values_".$cfkey."  ON  `customers`.`customers_id` = `cf_values_".$cfkey."`.`rel_crud_id` AND `cf_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
                }
            }
            array_push($columns, array( 'db' => 'customers.customers_id AS customers_id', 'field' => 'customers_id', 'dt' => count($columns) ));
        $where = '';
        $j = 0;
        if(strpos($joinQuery, 'JOIN') > 0) {
            $j = 1;
        }
        $where = SSP::iaFilter( $_GET, $columns, $j);
        $where = SSP::column_ia_filter($_GET, $where);
        if($this->input->get('dateRange')) {
            $date = explode(' - ', $this->input->get('dateRange'));
            $and = 'WHERE ';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and."DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
        }
        
        if(CheckPermission("invoice", "all_read")){}
        else if(CheckPermission("invoice", "own_read")){
            $and = 'WHERE ';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and."`$table`.`user_id`=".$this->user_id." ";
        }

        

        if(trim($where) == 'WHERE') {
            $where = '';
        }
        
        $group_by = "";
        $mka_hiving_va = "";
        if($mka_hiving_va != '') {
            $and = 'WHERE ';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and."($mka_hiving_va)";
        }

        $limit = SSP::limit( $_GET, $columns );
        $order = SSP::iaorder( $_GET, $columns, $j );
        $col = SSP::pluck($columns, 'db', $j);
        if(trim($where) == 'WHERE' || trim($where) == 'WHERE ()') {
            $where = '';
        }
        $query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$order." ".$limit." ";
        $query_without_limit = "SELECT count('*') AS c ".$joinQuery." ".$where." ";
        $res = $this->db->query($query);
        $res = $res->result_array();
        $recordsTotal = $this->db->query($query_without_limit)->row()->c;
        $res = SSP::mka_data_output($columns, $res, $j);

        $output_arr['draw']             = intval( $_GET['draw'] );
        $output_arr['recordsTotal']     = intval( $recordsTotal );
        $output_arr['recordsFiltered']  = intval( $recordsTotal );
        $output_arr['data']             = $res;
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where, $group_by, $having);
        foreach ($output_arr['data'] as $key => $value) 
        {
            $output_arr['data'][$key][0] = '
                    <input type="checkbox" name="selData" id="mka_'.$key.'" value="'.$output_arr['data'][$key][0].'">
                    <label for="mka_'.$key.'"></label>
                ';
            $key_id = @array_pop(array_keys($output_arr['data'][$key]));
            $id = $output_arr['data'][$key][$key_id];
            $output_arr['data'][$key][$key_id] = '';
            
            if(CheckPermission("invoice", "all_update")){
            $output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
            }else if(CheckPermission("invoice", "own_update")){
                $user_id =getRowByTableColomId($table,$id,'id');
                if($user_id->user_id==$this->user_id){
            $output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
                }
            }
            
            if(CheckPermission("invoice", "all_delete")){
            $output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setDeleteId('.$id.', \'invoice/delete_customers\')"><i class="material-icons col-red font-20">delete</i></a>';}
            else if(CheckPermission("invoice", "own_delete")){
                $user_id =getRowByTableColomId($table,$id,'id');
                if($user_id->user_id==$this->user_id){
            $output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setDeleteId('.$id.', \'invoice/delete_customers\')"><i class="material-icons col-red font-20">delete</i></a>';
                }
            }
            
        }
        echo json_encode($output_arr);
    }

    public function ajx_data_products(){
        $primaryKey = 'products_id';
        $table      = 'products';
        $joinQuery  =   "FROM `products` ";
        $columns    = array(
array( 'db' => 'products.products_id AS products_id', 'field' => 'products_id', 'dt' => 0 ),
array( 'db' => 'products.product_name AS product_name', 'field' => 'product_name', 'dt' => 1 ),
array( 'db' => 'products.quantity AS quantity', 'field' => 'quantity', 'dt' => 2 ),
array( 'db' => 'products.unit_price AS unit_price', 'field' => 'unit_price', 'dt' => 3 ),
);

            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $cf = get_cf('products');
            if(is_array($cf) && !empty($cf)) {
                foreach ($cf as $cfkey => $cfvalue) {
                    array_push($columns, array( 'db' => "cf_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));
                    $joinQuery  .=  " LEFT JOIN `cf_values` AS cf_values_".$cfkey."  ON  `products`.`products_id` = `cf_values_".$cfkey."`.`rel_crud_id` AND `cf_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
                }
            }
            array_push($columns, array( 'db' => 'products.products_id AS products_id', 'field' => 'products_id', 'dt' => count($columns) ));
        $where = '';
        $j = 0;
        if(strpos($joinQuery, 'JOIN') > 0) {
            $j = 1;
        }
        $where = SSP::iaFilter( $_GET, $columns, $j);
        $where = SSP::column_ia_filter($_GET, $where);
        if($this->input->get('dateRange')) {
            $date = explode(' - ', $this->input->get('dateRange'));
            $and = 'WHERE ';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and."DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
        }
        
        if(CheckPermission("invoice", "all_read")){}
        else if(CheckPermission("invoice", "own_read")){
            $and = 'WHERE ';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and."`$table`.`user_id`=".$this->user_id." ";
        }

        

        if(trim($where) == 'WHERE') {
            $where = '';
        }
        
        $group_by = "";
        $mka_hiving_va = "";
        if($mka_hiving_va != '') {
            $and = 'WHERE ';
            if($where != '') {
                $and = ' AND ';
            }
            $where .= $and."($mka_hiving_va)";
        }

        $limit = SSP::limit( $_GET, $columns );
        $order = SSP::iaorder( $_GET, $columns, $j );
        $col = SSP::pluck($columns, 'db', $j);
        if(trim($where) == 'WHERE' || trim($where) == 'WHERE ()') {
            $where = '';
        }
        $query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$order." ".$limit." ";
        $query_without_limit = "SELECT count('*') AS c ".$joinQuery." ".$where." ";
        $res = $this->db->query($query);
        $res = $res->result_array();
        $recordsTotal = $this->db->query($query_without_limit)->row()->c;
        $res = SSP::mka_data_output($columns, $res, $j);

        $output_arr['draw']             = intval( $_GET['draw'] );
        $output_arr['recordsTotal']     = intval( $recordsTotal );
        $output_arr['recordsFiltered']  = intval( $recordsTotal );
        $output_arr['data']             = $res;
        //$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where, $group_by, $having);
        foreach ($output_arr['data'] as $key => $value) 
        {
            $output_arr['data'][$key][0] = '
                    <input type="checkbox" name="selData" id="mka_'.$key.'" value="'.$output_arr['data'][$key][0].'">
                    <label for="mka_'.$key.'"></label>
                ';
            $key_id = @array_pop(array_keys($output_arr['data'][$key]));
            $id = $output_arr['data'][$key][$key_id];
            $output_arr['data'][$key][$key_id] = '';
            
            if(CheckPermission("invoice", "all_update")){
            $output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
            }else if(CheckPermission("invoice", "own_update")){
                $user_id =getRowByTableColomId($table,$id,'id');
                if($user_id->user_id==$this->user_id){
            $output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
                }
            }
            
            if(CheckPermission("invoice", "all_delete")){
            $output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setDeleteId('.$id.', \'invoice/delete_products\')"><i class="material-icons col-red font-20">delete</i></a>';}
            else if(CheckPermission("invoice", "own_delete")){
                $user_id =getRowByTableColomId($table,$id,'id');
                if($user_id->user_id==$this->user_id){
            $output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setDeleteId('.$id.', \'invoice/delete_products\')"><i class="material-icons col-red font-20">delete</i></a>';
                }
            }
            
        }
        echo json_encode($output_arr);
    }

    public function getFilterdata(){
        $where = '';
        if($this->input->post('dateRange')) {
            $date = explode(' - ', $this->input->post('dateRange'));
            $where = " DATE_FORMAT(`customers`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`customers`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
        }
        $data["view_data"]= $this->Customers_model->get_data($where);
        echo $this->load->view("tableData",$data, true);
        die;
    }

    public function getFilterdata_products(){
        $where = '';
        if($this->input->post('dateRange')) {
            $date = explode(' - ', $this->input->post('dateRange'));
            $where = " DATE_FORMAT(`products`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`products`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
        }
        $data["view_data"]= $this->Products_model->get_data($where);
        echo $this->load->view("tableData",$data, true);
        die;
    }

    public function set_filter_cookie() {
        if(!empty($this->input->post(strtolower('Customers_filter')))) {
            setcookie(strtolower('Customers_filter'), json_encode($this->input->post(strtolower('Customers_filter'))), time() + (86400 * 30 * 365), "/");
        }
    }

    public function set_filter_cookie_products() {
        if(!empty($this->input->post(strtolower('Products_filter')))) {
            setcookie(strtolower('Products_filter'), json_encode($this->input->post(strtolower('Products_filter'))), time() + (86400 * 30 * 365), "/");
        }
    }

    public function get_grid_info_box_val() {
        $result = array();
        if(is_array($this->input->get('request')) && !empty($this->input->get('request'))) {
            foreach ($this->input->get('request') as $rkey => $rvalue) {
                if(isset($rvalue['con_field']))
                $con_field      = json_decode(str_replace('@m@', '"', $rvalue['con_field']));
                if(isset($rvalue['con_operator']))
                $con_operator   = json_decode(str_replace('@m@', '"', $rvalue['con_operator']));
                if(isset($rvalue['con_value']))
                $con_value      = json_decode(str_replace('@m@', '"', $rvalue['con_value']));
                if(isset($rvalue['relation']))
                $relation       = json_decode(str_replace('@m@', '"', $rvalue['relation']));
                if(isset($rvalue['relation_table']))
                $relation_table = json_decode(str_replace('@m@', '"', $rvalue['relation_table']));
                if(isset($rvalue['relation_from']))
                $relation_from  = json_decode(str_replace('@m@', '"', $rvalue['relation_from']));
                if(isset($rvalue['relation_where']))
                $relation_where = json_decode(str_replace('@m@', '"', $rvalue['relation_where']));
                $where = '';
                $join = '';

                if(!CheckPermission($rvalue['table'], 'all_read') || !CheckPermission($rvalue['table'], 'all_update') || !CheckPermission($rvalue['table'], 'all_delete')) {
                    $where = " `".$rvalue['table']."`.`user_id` = '".$this->session->get_userdata()['user_details'][0]->users_id."' AND";
                }

                if($con_field[0] != '') {
                    foreach ($con_field as $cfkey => $cfvalue) {
                        if(isset($relation[$cfkey]) && $relation[$cfkey] == 'yes') {
                            $join .= " JOIN `".$relation_table[$cfkey]."` ON `".$relation_table[$cfkey]."`.`".$relation_table[$cfkey]."_id` = `".$rvalue['table']."`.`".$relation_from[$cfkey]."` ";
                            $where .= " `".$relation_table[$cfkey]."`.`".$relation_where[$cfkey]."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";
                        } else {
                            $where .= " `".$rvalue['table']."`.`".$cfvalue."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";    
                        }
                    }
                }

                if(is_array($this->input->get('request_filter')) && !empty($this->input->get('request_filter'))) {
                    foreach ($this->input->get('request_filter') as $fkey => $fvalue) {
                        if($fvalue != 'all') {
                            $fkey = explode('___', $fkey);
                            if($fkey[2] == 'filter_date') {
                                $date = explode(' - ', $fvalue);
                                $where .= " DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' AND";
                            } else {
                                $where .= " `".$fkey[0]."`.`".$fkey[1]."` =  '".$fvalue."' AND";
                            }
                        }
                    }
                }

                if(strpos($where, ' AND') > 0) {
                    $where = substr_replace($where, '', -3);
                }
                if($where != '') {
                    $where = 'WHERE '.$where;
                }
                if($rvalue['action'] == 'count') {
                    $qr = "SELECT count(*) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
                } else if($rvalue['action'] == 'sum') {
                    $qr = "SELECT SUM(`".$rvalue['sum_field']."`) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
                }
                $res = $this->Customers_model->getQrResult($qr);
                $result[$rvalue['return_id']] = 0;
                if($res[0]->mka_num != '') {
                    $result[$rvalue['return_id']] = $res[0]->mka_num;
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function get_grid_info_box_val_products() {
        $result = array();
        if(is_array($this->input->get('request')) && !empty($this->input->get('request'))) {
            foreach ($this->input->get('request') as $rkey => $rvalue) {
                if(isset($rvalue['con_field']))
                $con_field      = json_decode(str_replace('@m@', '"', $rvalue['con_field']));
                if(isset($rvalue['con_operator']))
                $con_operator   = json_decode(str_replace('@m@', '"', $rvalue['con_operator']));
                if(isset($rvalue['con_value']))
                $con_value      = json_decode(str_replace('@m@', '"', $rvalue['con_value']));
                if(isset($rvalue['relation']))
                $relation       = json_decode(str_replace('@m@', '"', $rvalue['relation']));
                if(isset($rvalue['relation_table']))
                $relation_table = json_decode(str_replace('@m@', '"', $rvalue['relation_table']));
                if(isset($rvalue['relation_from']))
                $relation_from  = json_decode(str_replace('@m@', '"', $rvalue['relation_from']));
                if(isset($rvalue['relation_where']))
                $relation_where = json_decode(str_replace('@m@', '"', $rvalue['relation_where']));
                $where = '';
                $join = '';

                if(!CheckPermission($rvalue['table'], 'all_read') || !CheckPermission($rvalue['table'], 'all_update') || !CheckPermission($rvalue['table'], 'all_delete')) {
                    $where = " `".$rvalue['table']."`.`user_id` = '".$this->session->get_userdata()['user_details'][0]->users_id."' AND";
                }

                if($con_field[0] != '') {
                    foreach ($con_field as $cfkey => $cfvalue) {
                        if(isset($relation[$cfkey]) && $relation[$cfkey] == 'yes') {
                            $join .= " JOIN `".$relation_table[$cfkey]."` ON `".$relation_table[$cfkey]."`.`".$relation_table[$cfkey]."_id` = `".$rvalue['table']."`.`".$relation_from[$cfkey]."` ";
                            $where .= " `".$relation_table[$cfkey]."`.`".$relation_where[$cfkey]."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";
                        } else {
                            $where .= " `".$rvalue['table']."`.`".$cfvalue."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";    
                        }
                    }
                }

                if(is_array($this->input->get('request_filter')) && !empty($this->input->get('request_filter'))) {
                    foreach ($this->input->get('request_filter') as $fkey => $fvalue) {
                        if($fvalue != 'all') {
                            $fkey = explode('___', $fkey);
                            if($fkey[2] == 'filter_date') {
                                $date = explode(' - ', $fvalue);
                                $where .= " DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' AND";
                            } else {
                                $where .= " `".$fkey[0]."`.`".$fkey[1]."` =  '".$fvalue."' AND";
                            }
                        }
                    }
                }

                if(strpos($where, ' AND') > 0) {
                    $where = substr_replace($where, '', -3);
                }
                if($where != '') {
                    $where = 'WHERE '.$where;
                }
                if($rvalue['action'] == 'count') {
                    $qr = "SELECT count(*) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
                } else if($rvalue['action'] == 'sum') {
                    $qr = "SELECT SUM(`".$rvalue['sum_field']."`) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
                }
                $res = $this->Products_model->getQrResult($qr);
                $result[$rvalue['return_id']] = 0;
                if($res[0]->mka_num != '') {
                    $result[$rvalue['return_id']] = $res[0]->mka_num;
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function generatePdf($id){
        $this->load->library('Mypdf');
        $invoice_detail = $this->invoice_model->getInvoiceDetail($id);
        $product_detail = json_decode($invoice_detail->product_details);
        $body = $this->load->view('templates/invoice', '', true);
        $sett = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
        
        $table = '<table class="table m-t-30"><thead><tr><th width="5%">#</th><th width="50%">Items</th><th width="10%">Qty</th><th width="15%">Unit Price</th><th width="20%">Total ( '.$sett[0]->currency.' )</th></tr></thead><tbody>';
                    foreach ($product_detail as $key => $value) {
                        $num = $key + 1;
                    $table .= '<tr><td>'.$num.'</td><td>'.$value->product_name.'</td><td>'.$value->quantity.'</td><td>'.number_format($value->unitprice, 2).'</td><td>'.number_format($value->total, 2).'</td></tr>';                
                    }

                    if($num < 5) {
                        while ($num < 5) {
                            $num++;
                            $table .= '<tr><td>'.$num.'</td><td></td><td></td><td></td><td>-</td></tr>';      
                        } 
                    }

                    $table .= '<tr class="even"><td colspan="4">Subtotal :</td><td colspan="4">'.number_format($invoice_detail->subtotal, 2).'</td></tr>';
                    $dis_arr = array('discount' => $invoice_detail->discount, 'dType' => $invoice_detail->discount_type);
                    $tax = $this->calculateTax($invoice_detail->subtotal, $dis_arr);
                    if(isset($tax['discount']) && $tax['discount'] > 0) {
                        $table .= '<tr><td colspan="4">Discount :</td><td colspan="4">- '.$tax['discount'].'</td></tr>';
                    }
                    foreach ($tax['taxes'] as $key => $value) {
                        $table .= '<tr><td colspan="4">'.$value['tax'].' :</td><td colspan="4">+ '.$value['amount'].'</td></tr>';
                    }
                    $table .= '<tr class="total"><td colspan="4">Total :</td><td colspan="4">'.$tax['total'].' ( '.$sett[0]->currency.' )</td></tr>';
        $table .= '</tbody></table>';

        $cusdt = $this->invoice_model->get_data_by('customers', $invoice_detail->customer_name, 'customers_id');
        $sett_header = preg_replace('/>\s+</', '><',$sett[0]->header);
        $sett_contant = preg_replace('/>\s+</', '><',$sett[0]->contant);
        $sett_footer = preg_replace('/>\s+</', '><',$sett[0]->footer);
        $body = str_replace('{{HEADER}}', $sett_header, $body);
        $body = str_replace('{{CONTANT}}', $sett_contant, $body);
        $body = str_replace('{{FOOTER}}', $sett_footer, $body);

        $invoice_id_prefix = $sett[0]->invoice_prefix; 
        $invoice_id_prefix = explode('-', $invoice_id_prefix);
        $invoice_id_prefix[1] = $invoice_id_prefix[1] + $invoice_detail->invoice_id;
        $invoice_id = implode('-', $invoice_id_prefix);

        $body = str_replace('{invoice_id}', $invoice_id, $body);        
        $body = str_replace('{order_date}', date($sett[0]->date_formate, strtotime($invoice_detail->date)), $body);
        $body = str_replace('{due_date}', date($sett[0]->date_formate, strtotime($invoice_detail->due_date)), $body);    
        $body = str_replace('{order_status}', $invoice_detail->status, $body);        

        $body = str_replace('{PRODUCT_TABLE}', $table, $body);   

        $body = str_replace('{Grand-Total}', number_format($invoice_detail->total, 2), $body);
        $body = str_replace('{user_name}', $cusdt[0]->name, $body);
        //echo $body; die;
        // $body = "<p>hello</p>";
        $this->dompdf->load_html($body);

        $this->dompdf->set_paper("A4", "portrait"); // to change page orientation to landscape, change the parameter “portrait” to “landscape”
        $this->dompdf->render();
       
        // Adding page number and invoice id
        $canvas = $this->dompdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(40, 780, "Page Number: {PAGE_NUM}", $font, 10, array(0,0,0));
        $canvas->page_text(465, 780, "Invoice #".$invoice_id, $font, 10, array(0,0,0));
        
        $filename = "Invoice-".strtotime("now").".pdf";
        $path = realpath(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/assets/images/pdf/';
        if(file_exists($path.$invoice_detail->file_name)) {
            unlink($path.$invoice_detail->file_name);
        }
        //$filename = 'sdhgkdfg'."-".$inst_pkg.".pdf";
        file_put_contents($path.$filename, $this->dompdf->output());
        return $filename;
    } 


    function calculatePersentage($per, $total) {
        return ( $per / 100 ) * $total;
    } 
    
    /* Delete data */
    public function delete($id)
    { 
        $idsArr = explode('-', $id);
        foreach ($idsArr as $key => $value) {
            $this->invoice_model->delete_data($value);      
        }
        $this->session->set_flashdata('message', 'Your data deleted Successfully..');
        redirect(base_url().'invoice/view');
    }

    public function delete_customers($ids) {
        $idsArr = explode('-', $ids);
        foreach ($idsArr as $key => $value) {
            $this->Customers_model->delete_data($value);        
        }
        echo json_encode($idsArr); 
        exit;
        //redirect(base_url().'customers', 'refresh');
    }

    public function delete_products($ids) {
        $idsArr = explode('-', $ids);
        foreach ($idsArr as $key => $value) {
            $this->Products_model->delete_data($value);     
        }
        echo json_encode($idsArr); 
        exit;
        //redirect(base_url().'products', 'refresh');
    }

    public function delete_data($id) { 
        $this->Customers_model->delete_data($id);
        $art_msg['msg'] = lang('your_data_deleted_successfully'); 
        $art_msg['type'] = 'warning'; 
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect('customers');
    }

    public function delete_data_products($id) { 
        $this->Products_model->delete_data($id);
        $art_msg['msg'] = lang('your_data_deleted_successfully'); 
        $art_msg['type'] = 'warning'; 
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect('products');
    }


    public function setting() {
        $id = $this->input->post('id');
        if($id && $id > 0) {
            $tax_arr = array();
            foreach ($this->input->post('tax_key') as $tkey => $tvalue) {
                if($tvalue != ''){
                    $tvalue = str_replace(' ', '_', $tvalue);
                    $tax_arr[$tkey]['tax_key'] = $tvalue;
                    $tax_arr[$tkey]['tax_value'] = $this->input->post('tax_value')[$tkey];
                    $tax_arr[$tkey]['calculate_on'] = $this->input->post('calculate_on')[$tkey];
                }
            }
            $data = array(
                    'invoice_prefix' => $this->input->post('invoice_prefix'),
                    'currency' => $this->input->post('currency'),
                    'date_formate' => $this->input->post('date_formate'),
                    'invoice_status' => $this->input->post('invoice_status'),
                    'taxes' => json_encode($tax_arr),
                    'header' => $this->input->post('header'),
                    'contant' => $this->input->post('contant'),
                    'footer' => $this->input->post('footer'),
                );
            $this->invoice_model->updateRow('invoice_settings', 'id', $id, $data);
            $art_msg['msg'] = lang('invoice_setting_successfully_updated'); 
            $art_msg['type'] = 'success'; 
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url().'invoice/setting');
        } else {
            $this->load->library('currency');
            $inv_setting = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
            $data['inv_setting'] = $inv_setting;
            $currency = $this->currency->get_currency_dropdown_options($inv_setting[0]->currency); 
            $data['currency'] = $currency;
            $this->load->view('include/header', $data);
            $this->load->view('inv_setting');   
            $this->load->view('include/footer');
        }
    }


    public function pdf_path($id) {
        $invoice_detail = $this->invoice_model->getInvoiceDetail($id);
        if(isset($invoice_detail->file_name) && $invoice_detail->file_name != '') {
            if(isset($this->session->get_userdata()['view_invoice'])) {
                $this->session->unset_userdata('view_invoice');
            }
            echo mka_base().'assets/images/pdf/'.$invoice_detail->file_name;
        } else {
            echo 'no_img';
        }
        exit;
    }

    public function calculateTax($amt, $dis) {
        $inv_setting = $this->invoice_model->get_data_by('invoice_settings', 1, 'id');
        $taxes = json_decode($inv_setting[0]->taxes);
        $amount = '';
        $total_tax = $amt;
        $result = array();
        if(is_array($dis) && !empty($dis)) {
            if($dis['discount'] > 0) {
                $dis_amt = $dis['discount'];
                if($dis['dType'] == 'per') {
                    $dis_amt = $this->calculatePersentage($dis_amt, $total_tax);
                }
                $result['discount'] = number_format($dis_amt, 2);
                $total_tax = $total_tax - $dis_amt;
            }
        }
        foreach ($taxes as $taxkey => $taxvalue) {
            if($taxvalue->calculate_on == 'sub_total') {
                $amount = $this->calculatePersentage($taxvalue->tax_value, $amt);
            } else if($taxvalue->calculate_on == 'tax1') {
                $amount = $this->calculatePersentage($taxvalue->tax_value, $txn_amt1);
            } else if($taxvalue->calculate_on == 'tax2') {
                $amount = $this->calculatePersentage($taxvalue->tax_value, $txn_amt2);
            } else if($taxvalue->calculate_on == 'tax3') {
                $amount = $this->calculatePersentage($taxvalue->tax_value, $txn_amt3);
            }
            if($taxkey == 0) {
                $txn_amt1 = $amount;
            } else if($taxkey == 1) {
                $txn_amt2 = $amount;
            } else if($taxkey == 2) {
                $txn_amt3 = $amount;
            } else if($taxkey == 2) {
                $txn_amt4 = $amount;
            }

            $result['taxes'][$taxkey]['tax'] = str_replace('_', ' ', $taxvalue->tax_key).' ('.$taxvalue->tax_value.'%)';
            $result['taxes'][$taxkey]['amount'] = number_format($amount, 2);
            $total_tax += $amount;
        }
        
        $result['total'] = number_format($total_tax, 2);
        return $result;
    }

    public function calculateTax_ajax($amt) {
        $res = $this->calculateTax($amt , $this->input->post());
        echo json_encode($res);
        exit;
    }

    public function update_status() {
        echo $this->invoice_model->updateRow('invoice', 'invoice_id', $this->input->post('inv_id'), array('status' => $this->input->post('status')));
        exit;
    }


    public function send_mail_inv() {
       // print_r($_POST); die;
        $invoice_detail = $this->invoice_model->getInvoiceDetail($this->input->post('inv_id'));
        $setting = settings();
        $sub = $this->input->post('subject');
        $body = $this->input->post('mail_body');
        $to = $this->input->post('to');
        $path = realpath(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
        $file = $path.'/assets/images/pdf/'.$invoice_detail->file_name;
        if($setting['mail_setting'] == 'php_mailer') {
            $this->load->library("send_mail");
            $emm = $this->send_mail->emailwith_attechment($sub, $body, $to, $setting, $file);
            if($emm) {
                $this->session->set_flashdata('messagePr', 'Mail Sent.');
            }
        } else {
            $content = file_get_contents($file);
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:application/pdf;charset=UTF-8" . "\r\n";
            $headers .= "Content-Transfer-Encoding: base64". "\r\n";
            $headers .= "Content-Disposition: attachment". "\r\n";
            $headers .= 'From: '.$setting['EMAIL'] . "\r\n";
            $body .= "Content-Type: application/pdf; name=\"" . basename($file) . "\"" . "\r\n";
            $body .= "Content-Transfer-Encoding: base64" . "\r\n";
            $body .= "Content-Disposition: attachment" . "\r\n";
            $body .= $content . "\r\n";
            $body .= "--" . strtotime("now") . "--";
            $emm = mail($to,$sub,$body,$headers);
            if($emm) {
                $this->session->set_flashdata('messagePr', 'Mail Sent.');
            }
        }

        redirect(base_url().'invoice/view');
    }

    public function getproducts() {
        $products = $this->invoice_model->getproducts($this->input->post('pro_name'), $this->input->post('except'));

        if (isset($products) && !empty($products)) {
            $html = "<ul>";
            foreach ($products as $product){
                $html .= "<li><span class='pro_name_li' data-id = '".$product->products_id."' data-uprice = '".$product->unit_price."'>".$product->product_name."</span></li>";
            }
            $html .= "</ul>";
            echo json_encode($html);
        } else {
            echo json_encode('');
        }
    }

    public function checkquantity() {
        $products = $this->invoice_model->get_data_by('products', $this->input->post('pro_id'), 'products_id');

        if (isset($products) && !empty($products)) {
            $difference = (int) $products[0]->quantity - (int) $this->input->post('qty');
                      
            if($difference >= 0){
                echo 1;
            }else{
                echo 0;
            }
        } else{
            echo 0;
        }           
    }

    public function add_customers() {   
        $data['name'] = $this->input->post('cust_name');        
        $data['user_id']=$this->user_id;
       
        $cust_id = $this->invoice_model->insertRow('customers', $data);
        if(isset($cust_id) && !empty($cust_id)){
            $html = '<option value="'.$cust_id.'" selected > '.$data["name"].' </option>';  
            echo json_encode($html);
        } else {
            echo json_encode('');
        }
    }

}
?>