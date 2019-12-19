<!-- Page content-->
<div class="content-wrapper">
    <h3>
        <?php 
    $urlPath = $this->uri->segment(5);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'customer'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
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
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Remaining Amount</th>
                        <th>Transaction Amount</th>
                        <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $total = 0;
                            $paid = 0;
                            $remaining = 0;
                            $transaction = 0;
                            if (isset($news) && !empty($news)) {
                                $result = $news->result_array();
                                $total = $result[0]['total'];
                                foreach ($news->result() as
                                        $new) {
                                    $i++;
                                $paid = $paid + $new->paid;
                                $transaction = $new->transaction_amount;
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $i;?></td>
                                    <td><?php echo wordwrap($new->total)  ?></td>
                                    <td><?php echo wordwrap($new->paid)  ?></td>
                                    <td><?php echo wordwrap($new->remaining)  ?></td>
                                    <td><?php echo wordwrap($new->transaction_amount)  ?></td>
                                    <td><?php echo wordwrap($new->date)  ?></td>
                                </tr>
                                <?php } ?>    
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pull-right" style="padding-right: 60px">
                        <h4 style="color:red;">Grand Total: <?php echo $total ?> PKR</h4>
                        <h4 style="color:red;">Total Paid: <?php echo $paid+$transaction ?> PKR</h4>
                        <h4 style="color:red;">Total Collectable: <?php echo $total-($paid+$transaction) ?> PKR</h4>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    </div>
</div>    