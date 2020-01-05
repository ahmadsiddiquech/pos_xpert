<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Account';
                else 
                    $strTitle = 'Edit Account';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'account'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'account/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'account/submit/' . $update_id, $attributes);
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
                                                        
                          <?php echo form_label('Account Name<span style="color:red">*</span>', 'name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                        $data = array(
                                        'name' => 'type',
                                        'id' => 'type',
                                        'class' => 'form-control',
                                        'type' => 'text',
                                        'tabindex' => '3',
                                        'value' => $news['type'],
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                          <?php echo form_label('Type<span style="color:red">*</span>', 'type', $attribute); ?>
                          <div class="col-md-8"> 
                            <select name="type" id="type" required="required" class="form-control" tabindex="4">
                              <option value="Invester" <?php if($news['type']=='Invester') echo "selected"; ?>>Invester</option>
                              <option value="Loan" <?php if($news['type']=='Loan') echo "selected"; ?>>Loan</option>
                              <option value="Bank" <?php if($news['type']=='Bank') echo "selected"; ?>>Bank</option>
                              <option value="Salary" <?php if($news['type']=='Salary') echo "selected"; ?>>Salary</option>
                              <option value="Capital" <?php if($news['type']=='Capital') echo "selected"; ?>>Capital</option>
                              <option value="Cash-in-hand" <?php if($news['type']=='Cash-in-hand') echo "selected"; ?>>Cash-in-hand</option>
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
                                                        'name' => 'opening_balance',
                                                        'id' => 'opening_balance',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '3',
                                                        'value' => $news['opening_balance'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Opening Balance', 'opening_balance', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
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
                                                        'tabindex' => '4',
                                                        'value' => $news['paid'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Paid', 'paid', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'remaining',
                                                        'id' => 'remaining',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '5',
                                                        'value' => $news['remaining'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Remaining', 'remaining', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'comment',
                                                        'id' => 'comment',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '8',
                                                        'value' => $news['comment'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Comment', 'comment', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>
                      </div>


                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary" id="button1"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'account'; ?>">
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

<script type="text/javascript">
  
//   $("#type").change(function () {
//   var type = this.value;
//   $.ajax({
//       type: 'POST',
//       url: "<?php echo ADMIN_BASE_URL?>account/check_cash_in_hand",
//       data: {'type':type},
//       async: false,
//       success: function(result) {
//         if (result == 1) {
//           toastr.danger('Cannot Create more than one Cash-in-hand Accounts');
//           document.getElementById("button1").disabled = true;
//         }
//         else {
//           toastr.danger('Cannot Create more than one Cash-in-hand Accounts');
//         }
//       }
//   });
// });
 
</script> 