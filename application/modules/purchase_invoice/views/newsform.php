<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
<style type="text/css">
  th, td, tr {
    border-collapse: collapse;
    border: 1px solid black;
    text-align: center;
  }
  
</style>

<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Purchase invoice';
                else 
                    $strTitle = 'Edit Purchase invoice';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'purchase_invoice/manage'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>View Purchase Invoice</b></button></a>
       </h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
            <div class="tab-pane  active" >
              <div class="portlet box green ">
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                  
                  <!-- BEGIN FORM-->
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'purchase_invoice/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'purchase_invoice/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">

                    <div class="row" style="margin-top:15px;">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'date',
                              'id' => 'date',
                              'class' => 'form-control',
                              'type' => 'date',
                              'tabindex' => '1',
                              'value' => date('Y-m-d'),
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Date', 'date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Supplier Name</label>
                            </div>
                            <div class="col-md-8">
                              <select name="supplier" id="supplier" class="chosen form-control" required="required" tabindex="2">
                              <?php if(isset($supplier) && !empty($supplier))
                              foreach ($supplier as $key => $value):?>
                                <option <?php if(isset($news['supplier_id']) && $news['supplier_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'] ?>"><?=$value['name'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'ref_no',
                              'id' => 'ref_no',
                              'class' => 'form-control',
                              'type' => 'ref_no',
                              'tabindex' => '3',
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Reference No', 'ref_no', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                    </div>
                    <hr>

                    <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-4"><h4 style="color: #23b7e5">Product</h4></div>
                    </div>
                    
               <div class="row" style="padding-top: 15px;">
                      <div class="col-sm-10">
                          <div class="form-group">
                            <div class="control-label col-md-1">
                              <label>Product</label>
                            </div>
                            <div class="col-md-8">
                              <select name="product" id="product" class="chosen form-control product" tabindex="4">
                                <option value=""></option>
                              <?php if(isset($product) && !empty($product))
                              foreach ($product as $key => $value):?>
                                <option <?php if(isset($news['product_id']) && $news['product_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'].','.$value['sale_price'] ?>"><?=$value['name'].'-'.$value['p_c_name'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          
                          <div class="control-label col-md-1">
                          <label>Qty</label>
                        </div>
                        <div class="col-md-2">
                          <input type="text" name="qty" class="form-control" value="1" style="text-align: center;">
                        </div>
                        </div>
                      </div>
                    <button class="btn btn-primary add_product btn-lg" tabindex="5" style="border-radius: 7px !important;padding-left: 30px;padding-right: 30px;font-size: 20px;">Add</button>
                    </div>
                    <div class="row" style="padding-top: 20px;">
                      <div class="col-md-1">
                      </div>
                      <div class="col-md-10">
                      <table style="width: 100%;">
                      <thead>
                       <tr>
                        <th>Description</th>
                        <th>Price per Unit</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                       </tr>
                      </thead>
                      <tbody id="table_data">
                      </tbody>
                     </table>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 15px;">
                      <div class="col-md-4"></div>
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Total Payment</h4>
                          </div>
                          <div class="col-md-6">
                            <input type="number" readonly name="total_pay" value="0" class="form-control" style="text-align: center;">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Discount</h4>
                          </div>
                          <div class="col-md-6">
                            <input type="number" name="discount" id="discount" class="form-control" value="0" style="text-align: center;" tabindex="6">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Grand Total</h4>
                          </div>
                          <div class="col-md-6">
                            <input type="number" readonly name="net_amount" value="0" class="form-control" style="text-align: center;">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Cash Received</h4>
                          </div>
                          <div class="col-md-6">
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control" value="0" style="text-align: center;" tabindex="7">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Change</h4>
                          </div>
                          <div class="col-md-6">
                            <input type="number" readonly name="remaining" value="0" class="form-control" style="text-align: center;">
                          </div>
                        </div>
                      </div>
                      </div>
                </div>
                </div>



                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;padding-top:15px;">
                       <span style="margin-left:40px"></span>
                       <button type="submit" id="button1" class="btn btn-success btn-lg" tabindex="8" style="margin-left:20px; border-radius: 7px !important; padding: 20px;font-size: 20px;"><i class="fa fa-print"></i>&nbsp;Save & Print</button>
                       <a href="<?php echo ADMIN_BASE_URL . 'purchase_invoice/create'; ?>">
                        <button type="button" class="btn btn-info btn-lg" style="margin-left:20px; border-radius: 7px !important; padding: 20px;font-size: 20px;" tabindex="9"><i class="fa fa-file"></i>&nbsp;New</button>
                        </a>
                        <a href="<?php echo ADMIN_BASE_URL . 'purchase_invoice'; ?>">
                        <button type="button" class="btn btn-danger btn-lg" style="margin-left:20px;border-radius: 7px !important;padding: 20px;font-size: 20px;" tabindex="10"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
                <!-- END FORM--> 
                
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>


<script>
  $(document).ready(function(){

$(document).on("click", ".add_product", function(event){
event.preventDefault();
var product = $(this).parent().find('select[name=product]').val();
var qty = $('input[name=qty]').val();
var total_pay = $('input[name=total_pay]').val();
    $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>purchase_invoice/add_product",
                data: {'product': product ,'total_pay' :total_pay , 'qty':qty},
                dataType: 'json',
                async: false,
                success: function(result) {
                $("#table_data").append(result[0]);
                $('input[name=total_pay]').val(result[1]);
                $('input[name=net_amount]').val(result[1]);
              }
});
});

$('input[name=discount]').keyup(function() {
    var total_pay = parseInt($('input[name=total_pay]').val());
    var discount = $(this).val();
    var net_amount = total_pay - discount;
    $('input[name=net_amount]').val(net_amount);
});

$('input[name=paid_amount]').keyup(function() {
    var net_amount = parseInt($('input[name=net_amount]').val());
    var paid_amount = $(this).val();
    var remaining = paid_amount - net_amount;
    $('input[name=remaining]').val(remaining);
    
});

$(".chosen").chosen();
});

             
</script>