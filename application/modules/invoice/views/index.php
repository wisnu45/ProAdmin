  <section class="content">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
<div class="container-fluid">
  <div class="row">
    <div class="ol-lg-12 col-md-12 col-sm-12 col-xs-12 invice">
       <div class="card">
        <!-- Custom Tabs -->
          <div class="header">
                <h2>
                    <?php echo $title; ?>                           
                </h2>
            </div>
            <div class="body">
            <div class="row">
              <div class="col-lg-12">
             <form class="form-horizontal" id="inv_form" action="<?php echo base_url().'invoice/add_edit' ?>" method="post" enctype='multipart/form-data'>
              <div class="box-body">
                <h4 class="b-r"> <strong><?php echo lang('general_information'); ?>:</strong> </h4>
                <hr>
                <div class="row"> 
                  <div class="col-md-6">
                    <div class="form-group form-float">
                      <label class=" col-sm-4" for=""><?php echo lang('build_date'); ?>:</label>
                      <div class="col-sm-8">
                        <div class="form-line">
                          <input type="text" class="form-control mkadatepicker" name="build_date" id="" value="<?php echo isset($result->build_date)?date($setting[0]->date_formate, strtotime($result->build_date)) : $build_date;?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-float">
                      <label class=" col-sm-4" for="">Due Date:</label>
                      <div class="col-sm-8">
                       <div class="form-line">
                          <input type="text" class="form-control mkadatepicker" name="due_date" id="" value="<?php echo isset($result->due_date)?date($setting[0]->date_formate, strtotime($result->due_date)) :$due_date;?>" placeholder="">
                       </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class=" col-sm-4" for=""><?php echo lang('customer_name'); ?>:</label>
                      <div class="col-sm-8">
                        <div class="form-group form-float">
                                <div class="form-line m-b-10">
                        <select name="customer_name" id="CNselectbox" class="col-md-8 form-control" required style="width: 74%;margin-right: 1%;">
                          <option value="">Select Customer Name</option>
                          <?php  
                            foreach ($customers as $key => $value) {
                              $selected = '';
                              if(isset($result->customer_name) && $result->customer_name == $value->customers_id) {
                                $selected = 'selected';
                              }
                              echo '<option value="'.$value->customers_id.'" '.$selected.' > '.$value->name.' </option>';
                            }
                          ?>
                        </select>
                      </div>
                      <button type="button" class="btn-sm  btn btn-primary modalButton" data-toggle="modal"  data-width="555" data-target="#nameModal_customers"><i class="material-icons">add</i> <?php echo lang('add'); ?></button>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class=" col-sm-4" for=""><?php echo lang('status') ?>:</label>
                      <div class="col-sm-8">
                        <select name="status" id="" class="form-control">
                          <?php  
                            $status_arr = explode(',', $setting[0]->invoice_status);
                            foreach ($status_arr as $key => $value) {
                              $selected = '';
                              if(isset($result->status) && $result->status == trim($value)) {
                                $selected = 'selected';
                              }
                              echo '<option value="'.trim($value).'" '.$selected.' > '.trim(ucfirst($value)).' </option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if(isset($result)) { ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="" class="control-label col-sm-4"><?php echo lang('invoice_no'); ?>. :</label>
                      <div class="col-sm-8 m-t-7" >
                        <span><?php echo $result->invoice_no; ?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <div class="m-t-20"></div>
                <!-- Custom_field_section_to_be_placed_here -->
                <div class="m-t-20"></div>
                <div class="mka-custom-f">
                  <?php get_custom_fields('invoice_list', isset($result->invoice_id) ? $result->invoice_id : ''); ?>
                </div>
                <div class="m-t-20"></div>
                  <h4 class="b-r"><strong><?php echo lang('item_details'); ?> :</strong> </h4>
                  <hr>
                  <div class="products-main-div">
                    <?php
                    if(isset($result)) { 
                      $product_details = json_decode($result->product_details);
                    }
                    $count = 0;
                    if(isset($product_details)){
                      $count = count($product_details);
                    }
                    $i = 0;
                    do{ ?>
                      <div class="products-row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-md-5 product"><div class="form-group form-float"><div class="form-line ">
                              <input type="text" class="form-control pro_name" name="product_name[]" id="" value="<?php echo isset($product_details[$i]->product_name)?$product_details[$i]->product_name :'';?>" required>
                              <label class="form-label" for=""><?php echo lang('item'); ?></label>
                            </div><div class="showdropdownname"></div></div></div>
                            <div class="col-md-2 quantity"><div class="form-group form-float"><div class="form-line ">
                              <input type="number" class="form-control qty" name="quantity[]" id="" required value="<?php echo isset($product_details[$i]->quantity)?$product_details[$i]->quantity :'';?>" data-id="<?php echo isset($product_details[$i]->product_id)?$product_details[$i]->product_id :'';?>">
                              <label class="form-label" for=""><?php echo lang('qty'); ?></label>
                              <input type="hidden" value="<?php echo isset($product_details[$i]->quantity)?$product_details[$i]->quantity :'';?>">
                            </div><span class="error_msgg text-red"></span></div></div>

                            <div class="col-md-2 unit_price"><div class="form-group form-float"><div class="form-line ">
                              <input type="number" class="form-control uprice" name="unitprice[]" id="" value="<?php echo isset($product_details[$i]->unitprice)?$product_details[$i]->unitprice :'';?>"  required>
                              <label class="form-label" for=""><?php echo lang('unit_price'); ?></label>
                            </div></div></div>
                            <div class="col-md-2 Dvtotal"><div class="form-group form-float"><div class="form-line ">
                              <input type="number" class="form-control" name="total[]" id="" value="<?php echo isset($product_details[$i]->total)?$product_details[$i]->total :'';?>">
                              <label class="form-label" for=""><?php echo lang('total'); ?></label>
                            </div></div></div>
                            <div class="col-md-1">

                              <button class="btn bg-deep-orange btn-circle waves-effect waves-circle waves-float rm-row" type="button" title="Remove Row"><i class="material-icons col-red">remove</i></button>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php  $i++;
                    } while($count > $i);
                    ?>
                  </div>
                  
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-md-1 col-md-offset-11">
                        <div class="">
                          <button type="button" class="add-more-row btn btn-primary btn-circle waves-effect waves-circle waves-float " title="Add Row" ><i class="material-icons">add</i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
                  <div class="m-b-20">
                    <div class="col-md-5"> <div class="form-group form-float"><div class="form-line focused">
                      <input type="number" class="form-control discount-input" value="<?php echo isset($result->discount)?$result->discount:'0';?>" name="discount">
                      <label for="" class="form-label"><?php echo lang('discount'); ?></label>
                    </div></div></div>
                    <div class="col-md-2">
                      <div class="form-group form-float">
                        <div class="form-line">
                          <select name="discount_type" id="" class="form-control discount-type">
                            <option value="ft" <?php echo isset($result->discount_type) && $result->discount_type == 'ft' ? 'selected' :'';?>><?php echo lang('flat'); ?></option>
                            <option value="per" <?php echo isset($result->discount_type) && $result->discount_type == 'per' ? 'selected' :'';?> ><?php echo lang('percentage'); ?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row cal-row">
                    <div class="col-md-12">
                      <div class="col-md-9 p-l-0">
                        <label for="" class=""><?php echo lang('sub_total'); ?>: </label> 
                      </div>
                      <div class="col-md-3">
                        <div class="total">
                          <span class="badge btn-color total-amt mka-badge"><?php echo isset($result->subtotal)?number_format($result->subtotal, 2) :'0';?></span> 
                          
                          <input type="hidden" name="subtotal" value="<?php echo isset($result->subtotal)?number_format($result->subtotal, 2):'0';?>">
                          
                        </div>
                      </div> 
                    </div>
                    
                    
                  </div>
                  <div class="tax-mn-dv"></div>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-12">
                    <?php if(isset($result->invoice_id)) { ?>
                    <input type="hidden" name="id" value="<?php echo isset($result->invoice_id)?$result->invoice_id :'';?>">
                    <button class="btn btn-primary GinvoiceBtn mka-inv-btn" type="submit" onclick="return validate_form_for_qty()" value="Update Invoice"><?php echo lang('update_invoice'); ?></button>
                    <button class="btn btn-primary" type="submit" name="view" value="view"><?php echo lang('view_n_download'); ?></button>
                  <?php } else { ?>
                    <button class="btn btn-primary GinvoiceBtn mka-inv-btn" onclick="return validate_form_for_qty()" type="submit" value="Generate Invoice"><?php echo lang('generate_invoice'); ?></button>
                  <?php } ?>
                  </div>
                </div>
              </div>
              
             </form>
            </div>
          </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
      </div>
        <!-- /.col -->
      </div>
    
     </section>    
    <!-- /.content -->
 
  <!-- /.content-wrapper -->
<!-- Modal -->
<div id="previewModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo lang('invoice_preview'); ?></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="nameModal_customers"  role="dialog"><!-- Modal Crud Start-->
  <div class="modal-dialog">
    <div class="modal-content" >
      <div class="modal-header">
          <h4 class="modal-title"><?php echo lang('customers'); ?></h4>
      </div>
      <div class="modal-body">
          
            <div class="form-group form-float">
              <div class="form-line">
                <input type="text" class="form-control CNnameinput" id="name" name="name" required value="">
                <label class="form-label" ><?php echo lang('name'); ?> <span class="text-red">*</span></label>
              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-danger" aria-label="Close"><?php echo lang('close'); ?></button>
        <input type="submit" value="Save" name="save" class="saveCN btn btn-primary btn-color ">
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
  /*$('dody').on('click', 'a.generateInv' , function() {
    alert('dfg');
    generateInv( $(this).attr('rel') );    
  });*/
  <?php  if(isset($this->session->get_userdata()['view_invoice']) && $this->session->get_userdata()['view_invoice'] != ''){ ?>
    generateInv( $('input[name="id"]').val() );


    $(window).resize(function() {
      calcHeight();
    }).load(function() {
      calcHeight();
    });
  <?php } ?>



  <?php 
    $date_format = 'dd-mm-yy';
    if(isset($setting[0]->date_formate) && $setting[0]->date_formate != '') {
      $date_format = $setting[0]->date_formate;
      $date_format = str_replace('Y', 'yy', $date_format);
      $date_format = str_replace('m', 'mm', $date_format);
      $date_format = str_replace('d', 'dd', $date_format);
    }
  ?>



  $(".mkadatepicker").datepicker({ dateFormat: "<?php echo $date_format; ?>" });

  $('.add-more-row').on('click', function() {
    $('.products-main-div').append('<div class="products-row">'+
      '<div class="col-md-12">'+
        '<div class="form-group">'+
          '<div class="col-md-5 product"><div class="form-group form-float"><div class="form-line">'+
            '<input type="text" class="form-control pro_name" name="product_name[]" id="" value="" required>'+
            '<label class="form-label" for=""><?php echo lang("item"); ?></label>'+
            '<input type="hidden" name="product_id[]" value="new">'+
          '</div><div class="showdropdownname"></div></div></div>'+
          '<div class="col-md-2 quantity"><div class="form-group form-float"><div class="form-line">'+
            '<input type="number" class="form-control qty" name="quantity[]" id="" value=""  required>'+
            '<label class="form-label" for=""><?php echo lang("qty"); ?></label>'+
            '<input type="hidden" value="">'+
          '</div><span class="error_msgg text-red"></span></div></div>'+
          
          '<div class="col-md-2 unit_price"><div class="form-group form-float"><div class="form-line">'+
            '<input type="number" class="form-control uprice" name="unitprice[]" id="" value="" required>'+
            '<label class="form-label" for=""><?php echo lang("unit_price"); ?></label>'+
          '</div></div></div>'+
          '<div class="col-md-2 Dvtotal"><div class="form-group form-float"><div class="form-line">'+
            '<input type="number" class="form-control" name="total[]" id="" value="">'+
            '<label class="form-label" for=""><?php echo lang("total"); ?></label>'+
          '</div></div></div>'+
          '<div class="col-md-1">'+
            '<button class="btn bg-deep-orange btn-circle waves-effect waves-circle waves-float rm-row" type="button" title="<?php echo lang('remove_row'); ?>"><i class="material-icons col-red">remove</i></button>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>');
    $.AdminBSB.input.activate();
  });


  $('body').on('click', '.rm-row', function() {
    $obj = $(this);
    if($('div.products-row').length > 1) {
      $obj.parents('div.products-row').remove();
      calculateTotal();
    }
  });

  $('.products-main-div').on('blur', 'input[name="quantity[]"]', function() {
    __obj = $(this);
    $unitprice = __obj.parents('.products-row').find('input[name="unitprice[]"]').val();
    if($unitprice != '') {
      if(__obj.attr('data-id') != '' && __obj.val() != ''){
        var qval = __obj.val();
        var hidden = __obj.siblings('input[type="hidden"]').val();
        if(hidden != ''){
           var diff = parseInt(qval) - parseInt(hidden);
           if(diff > 0){
            qval = diff;
            var qty_status = checkquantity(__obj.attr('data-id'), qval);
           }else if(diff < 0){
              qty_status = 'ok';
           }
        }else{
            var qty_status = checkquantity(__obj.attr('data-id'), qval);          
        }
        $val = $unitprice * __obj.val();
        __obj.parents('.products-row').find('input[name="total[]"]').val($val);
        if(qty_status == 'ok'){
          //$val = $unitprice * __obj.val();
          //__obj.parents('.products-row').find('input[name="total[]"]').val($val);
        }else if(qty_status == 'quantity limit exceeds'){
          //$val = $unitprice * __obj.val();
          //__obj.parents('.products-row').find('input[name="total[]"]').val($val);
          __obj.siblings('span.error_msgg').text('<?php echo lang("product_qty_exceeds_from_maximum_qty"); ?>').show();
        } 
        calculateTotal();
      }     
    } else {
      __obj.parents('.products-row').find('input[name="unitprice[]"]').focus();
    }    
    
  });

  $('.products-main-div').on('blur', 'input[name="unitprice[]"]', function() {
    __obj = $(this);
    
    $quantity = __obj.parents('.products-row').find('input[name="quantity[]"]').val();
    if($quantity != '') {      
      $val = $quantity * __obj.val();
      __obj.parents('.products-row').find('input[name="total[]"]').val($val);          
      calculateTotal();
    } else {
      __obj.parents('.products-row').find('input[name="quantity[]"]').focus();
    }    
  });

  $('.discount-input').on('blur', function() {
    calculateTotal();
  });

  $('.discount-type').on('change', function() {
    calculateTotal();
  })



 /* $('.generatePdf').on('click', function() {
    $.ajax({
      url:'<?php //echo base_url().'invoice/generatePdf' ?>',
      method: 'post',
      data: {
        id: $(this).parents('div#nameModal_student').find('input[name="id"]').val()
      }
    }).done(function(data) {
      alert(data);
    })
  });*/

    $('.mka-inv-btn').on('click', function(m) {
      m.preventDefault();
      $(this).attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> <?php echo lang("processing"); ?>...');
      setTimeout(function() {
        $('#inv_form').submit();
      }, 5000);
    });
  <?php if(isset($result->subtotal) && $result->subtotal > 0) { ?>
    calculateTax('<?php echo $result->subtotal; ?>');
  <?php } ?>
})


var generateInv = function($id) {
  $.ajax({
    url: '<?php echo base_url().'invoice/pdf_path/' ?>'+$id,
    method:'post',
  }).done(function(data){
    console.log(data);
    if(data != 'no_img') {
      $('#previewModal').find('div.modal-body').html('<iframe class="full-screen-preview__frame" src="'+data+'" frameborder="0" style="height: 500px;width: 100%;"></iframe>');
      $('#previewModal').modal('show');
    } else {
      alert('file not found');
    }
  });
} 


var calculateTotal = function() {
  $total = 0;
  $('input[name="total[]"]').each(function() {
    if($(this).val() != '' ) {
      $total += parseFloat($(this).val());
    }
  });
  calculateTax($total);
  $('span.total-amt').text($total);
  $('input[name="subtotal"]').val($total);
}

var calculateTax = function(amt) {
  $('.tax-mn-dv').removeClass('blind');
  $('.tax-mn-dv').html('<div class="row"><div class="text-center col-md-12"><i class="fa fa-refresh fa-spin"></i> <?php echo lang("tax_calculating"); ?> ... </div></div>');
  $dis = $('.discount-input').val();
  if($dis == '') {
    $dis = 0;
  }
  $dis_type = $('.discount-type').val();
  //$('.box-footer').find('.btn').attr('disabled', true);
  $html = '';
  $.post('<?php echo base_url().'invoice/calculateTax_ajax/'; ?>'+amt, { discount: $dis, dType: $dis_type } , function(data) {
    console.log(data);
    if(data.discount > 0) {
      $html += '<div class="row cal-row">'+
                  '<div class="col-md-12">'+
                    '<div class="col-md-9">'+
                      '<label for="" class="control-label"><?php echo lang("discount"); ?>: </label>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                      '<div class="total">'+
                        '<span class="badge btn-color mka-badge"> - '+ data.discount +'</span> '+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>';
    }
    if(data.taxes.length > 0) {
      $.each(data.taxes, function(k, v) {
        $html += '<div class="row cal-row">'+
                    '<div class="col-md-12">'+
                      '<div class="col-md-9">'+
                        '<label for="" class="control-label">'+ v.tax +': </label>'+
                      '</div>'+
                      '<div class="col-md-3">'+
                        '<div class="total">'+
                          '<span class="badge btn-color mka-badge"> + '+ v.amount +'</span> '+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                  '</div>';      
      });
      setTimeout(function() {
      $html += '<div class="row cal-row">'+
                  '<div class="col-md-12">'+
                    '<div class="col-md-9">'+
                      '<label for="" class="control-label"><?php echo lang('total'); ?>: </label>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                      '<div class="total">'+
                        '<span class="badge btn-color mka-badge">'+ data.total +'</span> '+
                        '<input type="hidden" name="grandtotal" value="'+ data.total.replace(/,/g, '') +'">'+
                      '</div>'
                    '</div>'+
                  '</div>'+
                '</div>';
        $('.tax-mn-dv').addClass('blind');
        $('.tax-mn-dv').html($html);
        $('.tax-mn-dv').slideDown('slow');
        //$('.box-footer').find('.btn').attr('disabled', false);
      }, 1000);
    }

  }, 'json');
}

var calcHeight = function() {
  var headerDimensions = $('.preview__header').height();
  $('.full-screen-preview__frame').height($(window).height() - headerDimensions);
}


$(document).on('keyup', '.pro_name', function(){
  var pro_name = $(this).val();
  var obj = $(this);
  var except = [];
  $('.qty').each(function(){
    var pro_id = $(this).attr('data-id');
    if(pro_id != ""){
      except.push(pro_id);
    }
  });

  $.ajax({
      url:'<?php echo base_url().'invoice/getproducts'; ?>',
      method: 'post',
      dataType: 'json',
      data: {
        pro_name: pro_name,
        except: except
      }
    }).done(function(data) {
        if (data && data != '') {
            obj.parents('div.form-group').first().find('div.showdropdownname').html(data).show();
        } else {
            obj.parents('div.form-group').first().find('div.showdropdownname').html('').hide();
        }
    })
});

/*$(document).on('blur', '.pro_name', function(){
  setTimeout(function() {
    $('div.showdropdownname').html('').hide();
  }, 500);
})*/
/*'.pro_name_li'*/

$('body').on('click', '.showdropdownname li', function() {
    $ob = $(this).find('span.pro_name_li');
    var product_name = $ob.text();
    var id = $ob.attr('data-id');
    var uprice = $ob.attr('data-uprice');
    $ob.parents('div.showdropdownname').siblings('.form-line').find('.pro_name').val(product_name);
    $ob.parents('div.showdropdownname').parents('div.product').siblings('div.unit_price').find('.uprice').val(uprice).focus().trigger('blur');
    $ob.parents('div.showdropdownname').parents('div.product').siblings('div.quantity').find('.qty').attr('data-id', id);
    $('.showdropdownname').html('').hide();
});

$(document).on('click', '.saveCN', function(){
  var cust_name = $('.CNnameinput').val();

  $.ajax({
      url:'<?php echo base_url()."invoice/add_customers"; ?>',
      method: 'post',
      dataType: 'json',
      data: {
        cust_name: cust_name
      }
    }).done(function(data) {
        if (data && data != '') {
            $('.CNnameinput').val('');
            $('#nameModal_customers').modal('hide');
            $('#CNselectbox').find('option:selected').removeAttr('selected');
            $('#CNselectbox').append(data).selectpicker('refresh');
        }
    })
});

function checkquantity(id, qty){
  var ret = '';
  $.ajax({
    url:'<?php echo base_url().'invoice/checkquantity' ?>',
    method: 'post',
    dataType: 'json',
    async:false,
    data: {
      pro_id: id,
      qty: qty
    }
    }).done(function(data) {
      if (data && data == '1') {
        ret = 'ok';
      }else{
        ret = 'quantity limit exceeds';
      }
    })
    return ret;
}

$(document).on('change', '.qty', function(){
  $(this).siblings('span.error_msgg').text('').hide();
});

function validate_form_for_qty(){
  var check = [];
  $('.qty').each(function(){
    var product_id = $(this).attr('data-id');
    var qty = $(this).val();
    var res = '';

    if(product_id != '' && qty != ''){
      var hidden = $(this).siblings('input[type="hidden"]').val();
      if(hidden != ''){
         var diff = parseInt(qty) - parseInt(hidden);
         if(diff > 0){
          qty = diff;
          res = checkquantity(product_id, qty); 
         }else if(diff < 0){
          
         }
      }else{
          res = checkquantity(product_id, qty);
      }
    }

    if(res == 'ok'){
        check.push('1');
    }else if(res == 'quantity limit exceeds'){
        check.push('0');
    }else if(res == ''){
        check.push('1');  
    }else{
        check.push('0');
    }     
  });

  if(jQuery.inArray('0', check) != -1){
    alert('<?php echo lang("product_qty_exceeds_from_maximum_qty"); ?>');
    return false;
  }else{
    return true;
  }
  
}
</script>