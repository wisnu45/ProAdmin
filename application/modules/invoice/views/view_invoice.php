
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
   
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2><?php echo lang('invoice') ?></h2>
            <ul class="header-dropdown">
              <?php if(CheckPermission("invoice", "own_create")){ ?>
             <a href="<?php echo base_url().'invoice/invoice'; ?>" class="btn-sm  btn btn-primary waves-effect amDisable modalButton"><i class="material-icons">add</i> <?php echo lang('add_invoice'); ?></a><?php } ?>
              </ul>
            
          </div>
             <!-- /.box-header -->
             <?php //print_r($setting); ?>
          <div class="body  table-responsive"> 
            <div class="row fRow">
              <div class="col-md-3 table-date-range">
                <label for="satatus" class="control-label"><?php echo lang('status'); ?></label>
                <select name="status" id="status-filter" class="form-control">
                  <option value="all"><?php echo lang('all'); ?></option>
                  <?php  
                    $status_arr = explode(',', $setting[0]->invoice_status);
                    foreach ($status_arr as $key => $value) {
                      $selected = '';
                      echo '<option value="'.trim($value).'" '.$selected.' > '.trim(ucfirst($value)).' </option>';
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-3 table-date-range m-t-25">
                <div class="form-group form-float">
                  <div class="form-line">
                    <input type="text" class="form-control daterange-filter daterange-picker" name="daterange" />
                    <label class="form-label"><?php echo lang('select_date_range'); ?></label>
                  </div>
                </div>
              </div>
            </div>       
            <table id="example1" class="table table-bordered table-striped table-hover delSelTable example_products dataTable no-footer">
              <thead>
              <tr>
                    <th>
                      <input type="checkbox" class="selAll" id="basic_checkbox_mka" />
                      <label for="basic_checkbox_mka"></label>
                    </th>
                   <th><?php echo lang('create_date'); ?></th>
                   <th><?php echo lang('invoice_no'); ?>.</th>
                   <th><?php echo lang('customer_name'); ?></th>
                   <th><?php echo lang('total_amount'); ?> ( <?php echo $setting[0]->currency; ?> )</th>
                   <th><?php echo lang('status') ?></th>
                   
                   <?php  $cf = get_cf('invoice_list');
                      if(is_array($cf) && !empty($cf)) {
                        foreach ($cf as $cfkey => $cfvalue) {
                          echo '<th>'.lang(get_lang($cfvalue->rel_crud).'_'.get_lang($cfvalue->name)).'</th>';
                        } 
                      }
                    ?>
                   <th><?php echo lang('action'); ?></th>
              </tr>
              </thead>
              <tbody>

              </tbody> 
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
  </section>
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


<div id="inv-mail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('send_mail'); ?></h4>
      </div>
      <form action="<?php echo base_url().'invoice/send_mail_inv' ?>" method="post">
        <div class="modal-body">
            <div class="form-group">
                <input class="form-control" name="to" placeholder="To:">
            </div>
            <div class="form-group">
                <input class="form-control" name="subject" placeholder="Subject:">
            </div>
            <div class="form-group">
              <textarea name="mail_body" id="" rows="3" class="form-control ckeditor"></textarea>
            </div>
            <div class="form-group">
              <label for="" class="control-label"> <strong><?php echo lang('atteched_file'); ?> :</strong></label>
              <span class="onv_file_name"> My-filename </span>
              <input type="hidden" name="inv_id" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><?php echo lang('send'); ?></button>
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        </div>
      </form>
    </div>

  </div>
</div>
<style></style>
<script>
  $(document).ready(function() {
    $('body').on('click', '.generateInv', function() {
      $.ajax({
        url: '<?php echo base_url().'invoice/pdf_path/' ?>'+$(this).attr('rel'),
        method:'post',
      }).done(function(data){
        if(data != 'no_img') {
          $('#previewModal').find('div.modal-body').html('<iframe class="full-screen-preview__frame" src="'+data+'" frameborder="0" style="height: 500px; width: 100%;"></iframe>');
          $('#previewModal').modal('show');
        } else {
          alert('<?php echo lang("file_not_found"); ?>');
        }
      });
    });
    var table = '';
    table = loadDatatable('', '');

  
      /*$('header').addClass('preview__header');*/

      


      $('body').on('click','.btn-blk-del', function() {
        $obj = $(this);
        $ids = '';
        $('[name="selData"]').each(function(){
          if($(this).is(':checked')){
            $ids += $(this).val() + '-';
          }
        })
        if($ids != ''){
          $ids = $ids.slice(0, -1);
          $('#cnfrm_delete').find('.yes-btn').attr('href', $obj.attr('data-del-url') + $ids)
          $('#cnfrm_delete').modal('show');
        } else {
          alert('<?php echo lang("nothig_is_seleted_to_delete"); ?>...');
        }
      });
      <?php 
      $date_format = 'DD-MM-YYYY';
      if(isset($setting[0]->date_formate) && $setting[0]->date_formate != '') {
        $date_format = $setting[0]->date_formate;
        $date_format = str_replace('Y', 'YYYY', $date_format);
        $date_format = str_replace('m', 'MM', $date_format);
        $date_format = str_replace('d', 'DD', $date_format);
      }

      ?>




      $(".daterange-filter, #status-filter").on("change", function() {
        table.destroy();
        var dateRange = $('.daterange-filter').val();
        var status = $('#status-filter').val();
        table = loadDatatable(dateRange, status);
      });

      $(".daterange-picker").daterangepicker(
      {
          locale: {
            format: "DD-MM-YYYY"
          },
          startDate: "<?php echo $sDate = "01-".date("m-Y"); ?>",
          endDate: "<?php echo date("d-m-Y", strtotime($sDate. " + 60 day")); ?>"
      });



    $('body').on('click', '.changeStatus', function() {

      $('.chng-status').each(function() {
        $(this).parents('td').html('<span class="changeStatus">'+$(this).val()+'</span>');
      });
      $obj = $(this);
      $old_val = $obj.text();
      $obj.parent().html('<select class="form-control chng-status"> '+ '<?php echo $status_option; ?>' +' </select>').find('.chng-status').val($old_val);
    })

    $('body').on('change', '.chng-status', function() {
      $obj = $(this);
      $.ajax({
        url: '<?php echo base_url().'invoice/update_status' ?>',
        type: 'POST',
        data: {
          inv_id: $obj.parents('tr').find('.generateInv').attr('rel'),
          status: $obj.val()
        },
      })
      .done(function(mka) {
        console.log(mka);
        if(mka) {
          $obj.parents('td').html('<span class="changeStatus">'+$obj.val()+'</span>');
        }
      });
      
    });

    $('body').on('click', '.invoice-mail', function() {
      $o = $(this);
      $.post('<?php echo base_url().'invoice/pdf_path/'; ?>' + $o.attr('data-inv-id'),  function(mka) {
        $('.onv_file_name').text(basename(mka));
        $('input[name="inv_id"]').val($o.attr('data-inv-id'));
        $('#inv-mail').modal('show');
      });
      

    });


    var tt = $('textarea.ckeditor').ckeditor();
    CKEDITOR.config.allowedContent = true;



  });

  function basename(path) {
   return path.split('/').reverse()[0];
  }



function loadDatatable(date, status) {
  $columnName1 = '';
  $columnVal1 = '';
  $columnName2 = '';
  $columnVal2 = '';
  if(date != '') {
    $columnName1 = 'date';
    $columnVal1 = date;
  }
  if(status != '') {
    $columnName2 = 'status';
    $columnVal2 = status;
  }
  $ret = $("#example1").DataTable({
        "dom": 'lfBrtip',
        "buttons": ['copy','excel'],
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url" : '<?php echo base_url(); ?>' + "invoice/dataTable",
          "data": function ( d ) { 
              d.columnName1 = $columnName1;
              d.columnVal1 = $columnVal1;
              d.columnName2 = $columnName2;
              d.columnVal2 = $columnVal2;
           }
        },
        "sPaginationType": "full_numbers",
        "language": {
          "search": "_INPUT_", 
          "searchPlaceholder": "<?php echo lang('search'); ?>",
          "paginate": {
              "next": '<i class="material-icons">keyboard_arrow_right</i>',
              "previous": '<i class="material-icons">keyboard_arrow_left</i>',
              "first": '<i class="material-icons">first_page</i>',
              "last": '<i class="material-icons">last_page</i>'
          }
        }, 
        "iDisplayLength": 10,
        "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]],
        "columnDefs" : [
          {
            "orderable": false,
            "targets": [0]
          }
          <?php if(!CheckPermission("invoice", "all_delete") && !CheckPermission("invoice", "own_delete")){ ?>
          ,{
            "targets": [0],
            "visible": false,
            "searchable": false
          }
                <?php } ?>
        ],
        "order": [[1, 'asc']],
    });


    var  cjhk = 0;
      <?php if(CheckPermission("invoice", "all_delete") || CheckPermission("invoice", "own_delete")){ ?>
        cjhk = 1;
      <?php } ?>
      setTimeout(function() {
        var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
        //$('.table-date-range').css('right',add_width+'px');

        if(cjhk == 1) {
          if($('button.btn-blk-del').length <= 0) {
            $('.dataTables_info').before('<button data-del-url="<?php echo base_url() ?>invoice/delete/" class="btn btn-default btn-xs btn-blk-del pull-left"> <i class="material-icons text-red">delete</i></button><br><br>'); 
          }
        }
      }, 200);
    return $ret;
}
</script>