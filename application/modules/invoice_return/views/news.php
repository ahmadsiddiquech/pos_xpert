<!-- Page content-->
<div class="content-wrapper">
    <h3>Invoice Return<a href="invoice_return/create"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Add Purchase Invoice</b></button></a></h3>
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
                        <th>Invoice Return Id</th>
                        <th>Returnee Name</th>
                        <th>Date</th>
                        <th>Grand Total</th>
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
                                        $print_url = ADMIN_BASE_URL . 'invoice_return/print_invoice_return/' . $new->id ;
                                        $edit_url = ADMIN_BASE_URL . 'invoice_return/create/' . $new->id ;
                                        $delete_url = ADMIN_BASE_URL . 'invoice_return/delete/' . $new->id;
                                        ?>
                                        <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->id  ?></td>
                                        <td><?php echo $new->supplier_name ?></td>
                                        <td><?php echo $new->date ?></td>
                                        <td><?php echo $new->grand_total ?></td>
                                        <td><?php echo $new->status ?></td>
                                        
                                        <td class="table_action">
                                        <a class="btn yellow c-btn view_details" rel="<?=$new->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        <?php

                                        echo anchor($print_url, '<i class="fa fa-print"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Print purchase Invoice'));

                                        echo anchor($edit_url, '<i class="fa fa-pencil"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit purchase Invoice'));

                                        echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new->id, 'title' => 'Delete purchase Invoice'));
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
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    

<script type="text/javascript">
$(document).ready(function(){

    $(document).on("click", ".view_details", function(event){
    event.preventDefault();
    var id = $(this).attr('rel');
      $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>invoice_return/detail",
            data: {'id': id},
            async: false,
            success: function(exam_body) {
            var exam_desc = exam_body;
            $('#myModal').modal('show')
            $("#myModal .modal-body").html(exam_desc);
            }
        });
    });

  $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
        var id = $(this).attr('rel');
        e.preventDefault();
      swal({
        title : "Are you sure to delete the selected invoice_return?",
        text : "You will not be able to recover this invoice_return!",
        type : "warning",
        showCancelButton : true,
        confirmButtonColor : "#DD6B55",
        confirmButtonText : "Yes, delete it!",
        closeOnConfirm : false
      },
        function () {
            
               $.ajax({
                    type: 'POST',
                    url: "<?php echo ADMIN_BASE_URL?>invoice_return/delete",
                    data: {'id': id},
                    async: false,
                    success: function() {
                    location.reload();
                    }
                });
        swal("Deleted!", "invoice_return has been deleted.", "success");
      });

    });
});
</script>