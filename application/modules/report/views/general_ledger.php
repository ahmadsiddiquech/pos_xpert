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
                    $strTitle = 'General Ledger';
                else 
                    $strTitle = 'General Ledger';
                    echo $strTitle;
                    ?>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'report/submit_general_ledger/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'report/submit_general_ledger', $attributes);
                        ?>
                  <div class="form-body">

                    
                    <div class="row" style="margin-top:15px;">
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Account</label>
                            </div>
                            <div class="col-md-8">
                              <select name="account" id="account" class="chosen form-control" required="required" tabindex="1" required="required">
                                <option value=""></option>
                              <?php if(isset($account) && !empty($account))
                              foreach ($account as $key => $value):?>
                                
                                <option value="<?php echo $value['id'].','.$value['name'].','.$value['type'] ?>"><?php echo $value['name']?> <?php if ($value['type'] == 'supplier') {
                                  echo ' - '.$value['company_name'];
                                } ?> <?php echo ' - '.$value['type'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="row" >
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'from_date',
                              'id' => 'from_date',
                              'class' => 'form-control',
                              'type' => 'date',
                              'tabindex' => '2',
                              'value' => date('Y-m-d'),
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('From', 'from_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'to_date',
                              'id' => 'to_date',
                              'class' => 'form-control',
                              'type' => 'date',
                              'tabindex' => '3',
                              'value' => date('Y-m-d'),
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('To', 'to_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                    </div>

                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;View Report</button>
                        </div>
                    </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?>
                
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
    $(".chosen").chosen();
});       
</script>