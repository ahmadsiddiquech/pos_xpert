<!-- Page content-->
<div class="content-wrapper">
    <h3>
        <?php 
    $urlPath = $this->uri->segment(5);
    $supplier_id = $this->uri->segment(4);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'supplier'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a target="_blank" href="<?php echo ADMIN_BASE_URL . 'supplier/invoice_list_print/'.$supplier_id; ?>"><button type="button" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Print All</button></a>
                    <table id="datatable1" class="table table-striped table-hover table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr">S.No</th>
                        <th>Purchase Invoice Id</th>
                        <th>Date</th>
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Status</th>
                        <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $total = 0;
                            $paid = 0;
                            $remaining = 0;
                            if (isset($news)) {
                                foreach ($news->result() as
                                        $new) {
                                    $i++;
                                $total = $total + $new->grand_total;
                                $remaining = $remaining + $new->remaining;
                                $supplier_id = $this->uri->segment(4);
                                $product_url = ADMIN_BASE_URL . 'supplier/product_list/' . $new->id.'/'.$new->supplier_name . '/' .$supplier_id;
                                $set_publish_url = ADMIN_BASE_URL . 'supplier/set_publish/' . $new->id;
                                $set_unpublish_url = ADMIN_BASE_URL . 'supplier/set_unpublish/' . $new->id ;
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $i;?></td>
                                    <td><?php echo wordwrap($new->id)  ?></td>
                                    <td><?php echo wordwrap($new->date)  ?></td>
                                    <td><?php echo wordwrap($new->grand_total)  ?></td>
                                    <td><?php echo wordwrap($new->cash_received)  ?></td>
                                    <td><?php echo wordwrap($new->remaining)  ?></td>
                                    <td><?php echo wordwrap($new->status)  ?></td>
                                    <td>
                                    <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set as Un-Paid';
                                        $icon = '<i class="fa fa-check"></i>';
                                        $iconbgclass = ' btn green c-btn';
                                        if ($new->status  != 'Paid' ) {
                                            $publish_class = ' table_action_unpublish';
                                            $publis_title = 'Set as Paid';
                                            $icon = '<i class="fa fa-credit-card"></i>';
                                            $iconbgclass = ' btn default c-btn';
                                        }

                                    echo anchor($product_url, '<i class="fa fa-mail-forward"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'View Invoice Products'));

                                    echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass,
                                    'title' => $publis_title,'rel' => $new->id,'id' => $new->id, 'status' => $new->status));
                                    ?>
                                </td>
                                </tr>
                                <?php } ?>    
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pull-right" style="padding-right: 60px">
                        <h4 style="color:red;">Grand Total: <?php echo $total ?> PKR</h4>
                        <h4 style="color:red;">Total Paid: <?php echo $total-$remaining ?> PKR</h4>
                        <h4 style="color:red;">Total Payable: <?php echo $remaining ?> PKR</h4>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>supplier/change_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-credit-card').removeClass('fa-credit-card').addClass('fa-check');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-check').removeClass('fa-check').addClass('fa-credit-card');
                    }
                    $("#listing").load('<?php echo ADMIN_BASE_URL?>supplier/invoice_list/<?php $this->uri->segment(4)?>');
                    toastr.success('Status Changed Successfully');
                }
            });
            if (status == 'Paid') {
                $(this).removeClass('table_action_publish');
                $(this).addClass('table_action_unpublish');
                $(this).attr('title', 'Set as Paid');
                $(this).attr('status', 'Un-Paid');
            } else {
                $(this).removeClass('table_action_unpublish');
                $(this).addClass('table_action_publish');
                $(this).attr('title', 'Set as Un-Paid');
                $(this).attr('status', 'Paid');
            }
           
        });
});

</script>