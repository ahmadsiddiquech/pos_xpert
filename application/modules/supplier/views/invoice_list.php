<!-- Page content-->
<div class="content-wrapper">
    <h3>
        <?php 
    $urlPath = $this->uri->segment(5);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'supplier'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
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
                        <th>Purchase Invoice Id</th>
                        <th>Date</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $remaining = 0;
                            $paid = 0;
                            if (isset($news)) {
                                foreach ($news->result() as
                                        $new) {
                                    $i++;
                                    $paid = $paid + $new->grand_total;
                                    if ($new->status == 'Un-Paid') {
                                        $remaining = $remaining + $new->grand_total;
                                    }
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $i;?></td>
                                    <td><?php echo wordwrap($new->id)  ?></td>
                                    <td><?php echo wordwrap($new->date)  ?></td>
                                    <td><?php echo wordwrap($new->grand_total)  ?></td>
                                    <td><?php echo wordwrap($new->status)  ?></td>
                                </tr>
                                <?php } ?>    
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pull-right" style="padding-right: 60px">
                        <h4 style="color:red;">Grand Total: <?php echo $paid+$remaining ?> PKR</h4>
                        <h4 style="color:red;">Total Paid: <?php echo $paid ?> PKR</h4>
                        <h4 style="color:red;">Total Payable: <?php echo $remaining ?> PKR</h4>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    </div>
</div>    