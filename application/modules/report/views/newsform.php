<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Report';
                else 
                    $strTitle = 'Report';
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'report/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'report/submit', $attributes);
                        ?>
                  <div class="form-body">

                    
                    <div class="row" style="margin-top:15px;">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                        $data = array(
                                        'name' => 'return_type',
                                        'id' => 'return_type',
                                        'class' => 'form-control',
                                        'type' => 'text',
                                        'tabindex' => '3',
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                          <?php echo form_label('Type <span style="color:red">*</span>', 'return_type', $attribute); ?>
                          <div class="col-md-8"> 
                            <select name="return_type" id="return_type" required class="form-control" tabindex="5">
                              <option value="">Select</option>
                              <option value="Customer">Customer</option>
                              <option value="Supplier">Supplier</option>
                            </select>
                      </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Name</label>
                            </div>
                            <div class="col-md-8">
                              <select name="returnee" id="returnee" class="form-control" required="required" tabindex="2">
                              <option value="">Select</option>
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
                              'name' => 'from',
                              'id' => 'from',
                              'class' => 'form-control',
                              'type' => 'date',
                              'tabindex' => '1',
                              'value' => date('Y-m-d'),
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('From', 'from', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'to',
                              'id' => 'to',
                              'class' => 'form-control',
                              'type' => 'date',
                              'tabindex' => '1',
                              'value' => date('Y-m-d'),
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('To', 'to', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                    </div>

                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;View Report</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'report'; ?>">
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

$("#return_type").change(function () {
    var return_type = this.value;
   $.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>stock_return/get_returnee",
        data: {'return_type': return_type },
        async: false,
        success: function(result) {
        $("#returnee").html(result);
      }
    });
});

});
             
</script>