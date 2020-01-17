<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add supplier';
                else 
                    $strTitle = 'Edit supplier';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'supplier'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'supplier/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'supplier/submit/' . $update_id, $attributes);
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
                                                        
                          <?php echo form_label('Supplier Name<span style="color:red">*</span>', 'name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'city',
                                                        'id' => 'city',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '2',
                                                        'value' => $news['city'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Address', 'city', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>
                      <div class="row">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'phone',
                                                        'id' => 'phone',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '3',
                                                        'value' => $news['phone'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Phone No.', 'phone', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'company_name',
                                                        'id' => 'company_name',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '4',
                                                        'value' => $news['company_name'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Company Name', 'company_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'total',
                                                        'id' => 'total',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '5',
                                                        'value' => $news['total'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Amount Payable', 'total', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                        <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'paid',
                                                        'id' => 'paid',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '7',
                                                        'value' => $news['paid'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Amount Paid', 'paid', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'comments',
                                                        'id' => 'comments',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '8',
                                                        'value' => $news['comments'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Comments', 'comments', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>
                      </div>


                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'supplier'; ?>">
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

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });



</script>