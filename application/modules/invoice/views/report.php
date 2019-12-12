<div class="content-wrapper">
    <h3>Test Result
    <a href="<?php echo ADMIN_BASE_URL . 'invoice' ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

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
                              'name' => 'id',
                              'id' => 'id',
                              'class' => 'form-control',
                              'type' => 'text',
                              'required' => 'required',
                              'readonly' => 'true',
                              'tabindex' => '1',
                              'value' => $news['id'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Invoice Id', 'id', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'p_id',
                              'id' => 'p_id',
                              'class' => 'form-control',
                              'type' => 'text',
                              'required' => 'required',
                              'readonly' => 'true',
                              'tabindex' => '2',
                              'value' => $news['p_id'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Ref. Id', 'p_id', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                       <div class="col-sm-4">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'name',
                              'id' => 'name',
                              'class' => 'form-control',
                              'type' => 'text',
                              'required' => 'required',
                              'readonly' => 'true',
                              'tabindex' => '3',
                              'value' => $news['name'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-5');
                              ?>
                          <?php echo form_label('Patient Name', 'name', $attribute); ?>
                          <div class="col-md-7"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>

                      <hr>

                      <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-4"><h4 style="color: #23b7e5">Test Report</h4></div>
                    </div>
                    <table id="datatable2" class="table table-striped table-hover table-body" style="width: 100%">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th>Test</th>
                        <th>Male Value</th>
                        <th>Female Value</th>
                        <th>Child Value</th>
                        <th>Result</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($test)) {
                                    foreach ($test as $key=>
                                            $new) {
                                        $i++;
                                        ?>
                                        <input class="form-control" readonly type="hidden" name="test_id[]" value="<?php echo $new['id']  ?>">
                                        </td>
                                        <td><input class="form-control" readonly type="text" value="<?php echo $new['test_code'].'-'.$new['test_name'].'-'.$new['category_name']  ?>"></td>
                                        <td><input class="form-control" readonly type="text" value="<?php echo $new['male_value'] ?>"></td>
                                        <td><input class="form-control" readonly type="text" value="<?php echo $new['female_value'] ?>"></td>
                                        <td><input class="form-control" readonly type="text" value="<?php echo $new['child_value'] ?>"></td>
                                        <td>
                                            <input class="form-control" id="test_id_<?php echo $new['id']; ?>" type="text" name="result_value[]" 
                                            value="<?php if(isset($new['result_value'])){ echo($new['result_value']);} ?>">
                                            <div class="btn btn-primary edit_report round" test_id="<?php echo $new['id']; ?>" obt_marks="<?php echo $new['result_value'];?>"><i class="fa fa-check"></i></div>
                                        </td>
                                    </tr>
                                    <?php } ?>    
                                <?php } ?>
                            </tbody>
                    </table>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    

<script type="text/javascript">

$(document).on("click", ".edit_report", function(event){
event.preventDefault();
var test_id = $(this).attr('test_id');
var result_value = $(this).siblings('#test_id_'+test_id).val();
// alert(test_id);

$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>invoice/update_result",
        data: {'test_id': test_id,'result_value': result_value},
        async: false,
        success: function(result) {
            if (result) {
                  toastr.success('Result Updated Successfully');
            }
            else{
                toastr.warning('Unsuccessfull');
            }
        }
    });
});

</script>