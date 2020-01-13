<!-- Page content-->
<div class="content-wrapper">
    <h3>
    Transaction
    <a href="<?php echo ADMIN_BASE_URL . 'account/transaction'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Make Transaction</b></button></a></h3>
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
                        <th>Transaction From</th>
                        <th>Trasaction To</th>
                        <th>Transaction Type</th>
                        <th>Comment</th>
                        <th>Amount</th>
                        <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (isset($news)) {
                                $result = $news->result_array();
                                foreach ($news->result() as
                                        $new) {
                                    $i++;
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $i;?></td>
                                    <td><?php echo wordwrap($new->account_from_name)  ?></td>
                                    <td><?php echo wordwrap($new->account_to_name)  ?></td>
                                    <td><?php echo wordwrap($new->transaction_type)  ?></td>
                                    <td><?php echo wordwrap($new->comment)  ?></td>
                                    <td><?php echo wordwrap($new->amount)  ?></td>
                                    <td><?php echo wordwrap($new->date)  ?></td>
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