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
                    $strTitle = 'Add invoice';
                else 
                    $strTitle = 'Edit invoice';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'invoice/manage'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>View Invoice</b></button></a>
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
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'invoice/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'invoice/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    <div class="row" >
                      <div class="col-md-1"></div>
                      <div class="col-md-4"><h4 style="color: #23b7e5">Patient Info</h4></div>
                    </div>

                    <div class="row" style="margin-top:15px;">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'name',
                              'id' => 'name',
                              'class' => 'form-control',
                              'type' => 'text',
                              'required' => 'required',
                              'tabindex' => '1',
                              'value' => $news['name'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Name<span style="color:red">*</span>', 'name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                       <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'father_name',
                              'id' => 'father_name',
                              'class' => 'form-control',
                              'type' => 'text',
                              'required' => 'required',
                              'tabindex' => '2',
                              'value' => $news['father_name'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-5');
                              ?>
                          <?php echo form_label('Guardian Name<span style="color:red">*</span>', 'father_name', $attribute); ?>
                          <div class="col-md-7"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-3">
                                <div class="form-group">
                                  <?php
                                      $data = array(
                                      'name' => 'age',
                                      'id' => 'age',
                                      'class' => 'form-control',
                                      'type' => 'text',
                                      'required' => 'required',
                                      'tabindex' => '3',
                                      'value' => $news['age'],
                                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                      );
                                      $attribute = array('class' => 'control-label col-md-4');
                                      ?>
                                  <?php echo form_label('Age<span style="color:red">*</span>', 'age', $attribute); ?>
                                  <div class="col-md-6"> <?php echo form_input($data); ?></div>
                                </div>
                              </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                                        $data = array(
                                        'name' => 'gender',
                                        'id' => 'gender',
                                        'class' => 'form-control',
                                        'type' => 'text',
                                        'tabindex' => '4',
                                        'value' => $news['gender'],
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                          <?php echo form_label('Gender<span style="color:red">*</span>', 'gender', $attribute); ?>
                          <div class="col-md-8"> 
                            <select name="gender" required="required" class="form-control" tabindex="5">
                              <option value="">Select</option>
                              <option value="Male" <?php if($news['gender']=='Male') echo "selected"; ?>>Male</option>
                              <option value="Female" <?php if($news['gender']=='Female') echo "selected"; ?>>Female</option>
                              <option value="Other" <?php if($news['gender']=='Other') echo "selected"; ?>>Other</option>
                            </select>
                      </div>
                        </div>
                      </div>
                        <div class="col-sm-3">
                        <div class="form-group">
                          <?php
                                      $data = array(
                                      'name' => 'mobile',
                                      'id' => 'mobile',
                                      'class' => 'form-control',
                                      'type' => 'number',
                                      'tabindex' => '6',
                                      'required' => 'required',
                                      'value' => $news['mobile'],
                                      );
                                      $attribute = array('class' => 'control-label col-md-3');
                                      ?>
                          <?php echo form_label('Mobile<span style="color:red">*</span> ', 'mobile', $attribute); ?>
                          <div class="col-md-9"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                        <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                                $data = array(
                                'name' => 'cnic',
                                'id' => 'cnic',
                                'class' => 'form-control',
                                'pattern' => '[0-9]{13}',
                                'title' => 'Enter 13 Digit CNIC',
                                'tabindex' => '7',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['cnic'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('CNIC', 'cnic', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                                $data = array(
                                'name' => 'address',
                                'id' => 'address',
                                'class' => 'form-control',
                                'tabindex' => '8',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['address'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('Address', 'address', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-4"><h4 style="color: #23b7e5">Test Detail</h4></div>
                    </div>
                    <div class="row" style="padding-top: 15px;">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                                      $data = array(
                                      'name' => 'referred_by',
                                      'id' => 'referred_by',
                                      'class' => 'form-control',
                                      'type' => 'text',
                                      'tabindex' => '9',
                                      'value' => $news['referred_by'],
                                      );
                                      $attribute = array('class' => 'control-label col-md-4');
                                      ?>
                          <?php echo form_label('Referred By', 'referred_by', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                                      $data = array(
                                      'name' => 'delivery_date',
                                      'id' => 'delivery_date',
                                      'class' => 'form-control',
                                      'type' => 'date',
                                      'tabindex' => '10',
                                      'value' => $news['delivery_date'],
                                      );
                                      $attribute = array('class' => 'control-label col-md-5');
                                      ?>
                          <?php echo form_label('Delivery Date', 'delivery_date', $attribute); ?>
                          <div class="col-md-7"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                                        $data = array(
                                        'name' => 'status',
                                        'id' => 'status',
                                        'class' => 'form-control',
                                        'type' => 'text',
                                        'tabindex' => '11',
                                        'value' => $news['status'],
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                          <?php echo form_label('Status<span style="color:red">*</span>', 'status', $attribute); ?>
                          <div class="col-md-7"> 
                            <select name="status" required="required" class="form-control" tabindex="12">
                              <option value="">Select</option>
                              <option value="Pending" <?php if($news['status']=='Pending') echo "selected"; ?>>Pending</option>
                              <option value="In-Progress" <?php if($news['status']=='In-Progress') echo "selected"; ?>>In-Progress</option>
                              <option value="Ready" <?php if($news['status']=='Ready') echo "selected"; ?>>Ready</option>
                              <option value="Delivered" <?php if($news['status']=='Delivered') echo "selected"; ?>>Delivered</option>
                            </select>
                      </div>
                        </div>
                      </div>
                    </div>
                    
               <div class="row" style="padding-top: 15px;">
                <div class="col-md-1"></div>
                      <div class="col-sm-4">
                          <div class="form-group">
                            <div class="control-label col-md-3">
                              <label>Category</label>
                            </div>
                            <div class="col-md-9">
                              <select name="category" id="category" class="form-control" tabindex="13">
                              <option value="">Select</option>
                              <?php if(isset($category) && !empty($category))
                              foreach ($category as $key => $value):?>
                                <option <?php if(isset($news['category_id']) && $news['category_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'] ?>"><?=$value['name'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                        <?php
                        $attribute = array('class' => 'control-label col-md-3');
                        echo form_label('Test', 'test', $attribute);?>
                        <div class="col-md-9">
                          <select class="form-control" id="test" name="test" tabindex="14">
                            <option value="">Select</option>
                            <?php if(isset($news['test_id']) && !empty($news['test_id'])) { ?>
                            <option selected value="<?php echo $news['test_id'].','.$news['test_name']; ?>"><?php echo $news['test_name'];?></option>
                          <?php } ?>
                          </select>
                          </div>
                        </div>
                    </div>
                    <button class="btn btn-primary add_test btn-lg" tabindex="15" style="border-radius: 7px !important;padding-left: 30px;padding-right: 30px;font-size: 20px;">Add</button>
                    </div>
                    <div class="row" style="padding-top: 20px;">
                      <div class="col-md-1">
                      </div>
                      <div class="col-md-8">
                      <table style="width: 100%;">
                      <thead>
                       <tr>
                        <th>Category Name</th>
                        <th>Test Name</th>
                        <th>Charges</th>
                       </tr>
                      </thead>
                      <tbody id="table_data">
                      </tbody>
                     </table>
                      </div>
                    </div>
                    <div class="row" style="padding-top: 15px;">
                      <div class="col-md-4"></div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Total Payment</h4>
                          </div>
                          <div class="col-md-4">
                            <input type="number" readonly name="total_pay" value="0" class="form-control" style="text-align: center;">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Discount</h4>
                          </div>
                          <div class="col-md-4">
                            <input type="number" name="discount" id="discount" class="form-control" value="0" style="text-align: center;" tabindex="16">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Grand Total</h4>
                          </div>
                          <div class="col-md-4">
                            <input type="number" readonly name="net_amount" value="0" class="form-control" style="text-align: center;">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Cash Received</h4>
                          </div>
                          <div class="col-md-4">
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control" value="0" style="text-align: center;" tabindex="17">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <h4 style="text-align: right;">Change</h4>
                          </div>
                          <div class="col-md-4">
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
                       <button type="submit" id="button1" class="btn btn-success btn-lg" tabindex="19" style="margin-left:20px; border-radius: 7px !important; padding: 20px;font-size: 20px;"><i class="fa fa-print"></i>&nbsp;Save & Print</button>
                       <a href="<?php echo ADMIN_BASE_URL . 'invoice/create'; ?>">
                        <button type="button" class="btn btn-info btn-lg" style="margin-left:20px; border-radius: 7px !important; padding: 20px;font-size: 20px;" tabindex="20"><i class="fa fa-file"></i>&nbsp;New</button>
                        </a>
                        <a href="<?php echo ADMIN_BASE_URL . 'invoice'; ?>">
                        <button type="button" class="btn btn-danger btn-lg" style="margin-left:20px;border-radius: 7px !important;padding: 20px;font-size: 20px;" tabindex="21"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
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
  $("#category").change(function () {
        var category = this.value;
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>invoice/get_test",
            data: {'category': category },
            async: false,
            success: function(result) {
            $("#test").html(result);
          }
        });
  });

$(document).on("click", ".add_test", function(event){
event.preventDefault();
var test = $(this).parent().find('select[name=test]').val();
var total_pay = $('input[name=total_pay]').val();
    $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>invoice/add_test",
                data: {'test': test ,'total_pay' :total_pay},
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
});
</script>