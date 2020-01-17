<div class="content-wrapper">
    <h3>Account<a href="account/create"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Add Account</b></button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <table id="datatable1" class="table table-striped table-hover table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr">S.No</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Opening Balance</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (isset($news)) {
                                foreach ($news->result() as
                                        $new) {
                                    $i++;
                                    $edit_url = ADMIN_BASE_URL . 'account/create/' . $new->id ;
                                    $delete_url = ADMIN_BASE_URL . 'account/delete/' . $new->id;
                                    ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $i;?></td>
                                    <td><?php echo wordwrap($new->name , 50 , "<br>\n")  ?></td>
                                    <td><?php echo $new->type   ?></td>
                                    <td><?php echo $new->opening_balance   ?></td>
                                    <td><?php echo $new->paid   ?></td>
                                    <td><?php echo $new->remaining   ?></td>
                                    <td class="table_action">
                                        <?php 

                                    echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Account'));

                                    echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new->id, 'title' => 'Delete Account'));
                                        ?>
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
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){

  $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
        var id = $(this).attr('rel');
        e.preventDefault();
        swal({
            title : "Are you sure to delete the selected account?",
            text : "You will not be able to recover this account!",
            type : "warning",
            showCancelButton : true,
            confirmButtonColor : "#DD6B55",
            confirmButtonText : "Yes, delete it!",
            closeOnConfirm : false
        },
        function () {
           $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>account/delete",
                data: {'id': id},
                async: false,
                success: function() {
                location.reload();
                }
            });
            swal("Deleted!", "account has been deleted.", "success");
        });

    });

});
</script>