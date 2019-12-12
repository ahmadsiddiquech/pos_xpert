<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Test';
                else 
                    $strTitle = 'Edit Test';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'test'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'test/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'test/submit/' . $update_id, $attributes);
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
                          <?php echo form_label('Test Name<span style="color:red">*</span>', 'name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'test_code',
                              'id' => 'test_code',
                              'class' => 'form-control',
                              'type' => 'text',
                              'tabindex' => '2',
                              'value' => $news['test_code'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Test Code', 'test_code', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      
                      </div>
                     <div class="row">
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Category</label>
                            </div>
                            <div class="col-md-8">
                              <select name="category" id="category" class="form-control" tabindex="3">
                              <option value="">Select</option>
                              <?php if(isset($category) && !empty($category))
                              foreach ($category as $key => $value):?>
                                <option <?php if(isset($news['category_id']) && $news['category_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'] ?>"><?=$value['name'];?></option>
                              <?php endforeach; ?>
                            </select>
                            </div>
                          </div>
                      </div>
                      <div class="col-sm-5">
                          <div class="form-group">
                            <div class="control-label col-md-4">
                              <label>Unit</label>
                            </div>
                            <div class="col-md-8">
                              <select name="unit" id="unit" class="form-control" tabindex="4">
                              <option value="">Select</option>
                              <?php if(isset($unit) && !empty($unit))
                              foreach ($unit as $key => $value):?>
                                <option <?php if(isset($news['unit_id']) && $news['unit_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'] ?>"><?=$value['name'];?></option>
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
                                'name' => 'male_value',
                                'id' => 'male_value',
                                'class' => 'form-control',
                                'type' => 'text',
                                'tabindex' => '5',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['male_value'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('Male Value', 'male_value', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                $data = array(
                                'name' => 'female_value',
                                'id' => 'female_value',
                                'class' => 'form-control',
                                'type' => 'text',
                                'tabindex' => '6',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['female_value'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('Female Value', 'female_value', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                $data = array(
                                'name' => 'child_value',
                                'id' => 'child_value',
                                'class' => 'form-control',
                                'type' => 'text',
                                'tabindex' => '7',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['child_value'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('Child Value', 'child_value', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                $data = array(
                                'name' => 'delivery_time',
                                'id' => 'delivery_time',
                                'class' => 'form-control',
                                'type' => 'text',
                                'tabindex' => '8',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['delivery_time'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('Delivery Time', 'delivery_time', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                $data = array(
                                'name' => 'sample',
                                'id' => 'sample',
                                'class' => 'form-control',
                                'type' => 'text',
                                'tabindex' => '9',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['sample'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('Sample', 'sample', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                $data = array(
                                'name' => 'charges',
                                'id' => 'charges',
                                'class' => 'form-control',
                                'type' => 'text',
                                'tabindex' => '10',
                                'required' => 'required',
                                'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                               'value' => $news['charges'],
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                          <?php echo form_label('Charges<span style="color:red">*</span>', 'charges', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
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
                        <a href="<?php echo ADMIN_BASE_URL . 'test'; ?>">
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