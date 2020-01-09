<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        Bank Recieved/Journal Voucher
   <a href="<?php echo ADMIN_BASE_URL . 'account/transaction_list'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
            
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'account/submit_transaction/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'account/submit_transaction/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'ref_no',
                                                        'id' => 'ref_no',
                                                        'class' => 'form-control',
                                                        'type' => 'paid',
                                                        'tabindex' => '1',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Reference No', 'ref_no', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Account From</label>
                            </div>
                            <div class="col-md-8">
                              <select name="account_from" id="account_from" class="chosen form-control" required="required" tabindex="2" required="required">
                                <option value=""></option>
                              <?php if(isset($account) && !empty($account))
                              foreach ($account as $key => $value):?>
                                
                                <option value="<?php echo $value['id'].','.$value['name'].','.$value['type'] ?>"><?php echo $value['name'].' - '.$value['type'];?></option>
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
                              <label>Account To</label>
                            </div>
                            <div class="col-md-8">
                              <select name="account_to" id="account_to" class="chosen form-control" required="required" tabindex="2" required="required">
                                <option value=""></option>
                              <?php if(isset($account) && !empty($account))
                              foreach ($account as $key => $value):?>
                                <option value="<?php echo $value['id'].','.$value['name'].','.$value['type'] ?>"><?php echo $value['name'].' - '.$value['type'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          </div>
                      </div>
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'amount',
                                                        'id' => 'amount',
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'tabindex' => '3',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Amount', 'amount', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'comment',
                                                        'id' => 'comment',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '4',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Comment', 'comment', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>


                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button> </div>
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
      $(".chosen").chosen();
  });
</script>