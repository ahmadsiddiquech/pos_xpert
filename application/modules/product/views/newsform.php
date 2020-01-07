<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Product';
                else 
                    $strTitle = 'Edit Product';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
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
                          <?php echo form_label('Product Name<span style="color:red">*</span>', 'name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Supplier</label>
                            </div>
                            <div class="col-md-8">
                              <select name="supplier" id="supplier" class="form-control chosen" tabindex="2">
                              <option value=""></option>
                              <?php if(isset($supplier) && !empty($supplier))
                              foreach ($supplier as $key => $value):?>
                                <option <?php if(isset($news['supplier_id']) && $news['supplier_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'] ?>"><?php echo $value['name'].' - '.$value['company_name'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          </div>
                      </div>
                      
                      </div>
                     <div class="row">
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Parent Category</label>
                            </div>
                            <div class="col-md-8">
                              <select name="parent_category chosen" id="parent_category" class="form-control chosen" tabindex="3">
                              <option value=""></option>
                              <?php if(isset($category) && !empty($category))
                              foreach ($category as $key => $value):?>
                                <option <?php if(isset($news['p_c_id']) && $news['p_c_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'] ?>"><?=$value['name'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                        <div class="control-label col-md-4">
                              <label>Sub Category</label>
                            </div>
                        <div class="col-md-8">
                          <select class="form-control" id="sub_category" name="sub_category" tabindex="4">
                            <option value="">Select</option>
                            <?php if(isset($news['s_c_id']) && !empty($news['s_c_id'])) { ?>
                            <option selected value="<?php echo $news['id'].','.$news['name']; ?>"><?php echo $news['name'];?></option>
                          <?php } ?>
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
                              'name' => 'barcode',
                              'id' => 'barcode',
                              'class' => 'form-control',
                              'type' => 'text',
                              'tabindex' => '5',
                              'value' => $news['barcode'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Barcode', 'barcode', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'stock',
                              'id' => 'stock',
                              'class' => 'form-control',
                              'type' => 'number',
                              'tabindex' => '6',
                              'value' => $news['stock'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Opening Stock', 'stock', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'purchase_price',
                              'id' => 'purchase_price',
                              'class' => 'form-control',
                              'type' => 'number',
                              'tabindex' => '7',
                              'value' => $news['purchase_price'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Purchase Price', 'purchase_price', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'sale_price',
                              'id' => 'sale_price',
                              'class' => 'form-control',
                              'type' => 'number',
                              'tabindex' => '8',
                              'value' => $news['sale_price'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Sale Price', 'sale_price', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'sale_discount',
                              'id' => 'sale_discount',
                              'class' => 'form-control',
                              'type' => 'text',
                              'tabindex' => '9',
                              'value' => $news['sale_discount'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Sale Discount', 'sale_discount', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'remarks',
                              'id' => 'remarks',
                              'class' => 'form-control',
                              'type' => 'text',
                              'tabindex' => '10',
                              'value' => $news['remarks'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Remarks', 'remarks', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                    </div>
                </div>
                </div>



                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" id="button1" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
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
  $("#parent_category").change(function () {
        var parent_category = this.value;
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>product/get_sub_category",
            data: {'parent_category': parent_category },
            async: false,
            success: function(result) {
            $("#sub_category").html(result);
          }
        });
  });

  $(".chosen").chosen();
});
</script>