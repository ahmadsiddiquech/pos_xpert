<!-- Page content-->
<div class="content-wrapper">
    <h3>
    Chart of Account
    <!-- <a href="<?php echo ADMIN_BASE_URL . 'supplier'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a> -->
    </h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <!-- <a target="_blank" href="<?php echo ADMIN_BASE_URL . 'supplier/invoice_list_print/'.$supplier_id; ?>"><button type="button" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Print All</button></a> -->
                    <table id="datatable1" class="table table-striped table-hover table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr">ID</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (isset($news)) {
                                foreach ($news->result() as
                                        $new) {
                                    $i++;
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $new->id ?></td>
                                    <td><?php echo $new->type ?></td>
                                    <td><?php echo $new->name ?></td>
                                    <td><?php echo $new->date ?></td>
                                    <? if ($new->type == 'Cash-in-hand' || $new->type == 'Bank' || $new->type == 'Asset') { ?>
                                        <td>0</td>
                                        <td><?php echo $new->opening_balance ?></td>
                                    <?php } 
                                        elseif ($new->type == 'Salary' || $new->type == 'Invester' || $new->type == 'Loan') { ?>
                                            <td><?php echo $new->remaining ?></td>
                                            <td><?php echo $new->paid ?></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>    
                            <?php }
                            if (isset($customer)) {
                                foreach ($customer->result() as
                                        $new) {
                                    $i++;
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $new->id ?></td>
                                    <td><?php echo 'Customer' ?></td>
                                    <td><?php echo $new->name ?></td>
                                    <td><?php echo date('Y-m-d') ?></td>
                                    <td>0</td>
                                    <td><?php echo $new->remaining ?></td>
                                </tr>
                                <?php } ?>    
                            <?php }
                            if (isset($supplier)) {
                                foreach ($supplier->result() as
                                        $new) {
                                    $i++;
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $new->id ?></td>
                                    <td><?php echo 'Supplier' ?></td>
                                    <td><?php echo $new->name ?></td>
                                    <td><?php echo date('Y-m-d') ?></td>
                                    <td><?php echo $new->remaining ?></td>
                                    <td>0</td>
                                    
                                </tr>
                                <?php } ?>    
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- <div class="pull-right" style="padding-right: 60px">
                        <h4 style="color:red;">Grand Total: <?php echo $total ?> PKR</h4>
                        <h4 style="color:red;">Total Paid: <?php echo $total-$remaining ?> PKR</h4>
                        <h4 style="color:red;">Total Collectable: <?php echo $remaining ?> PKR</h4>
                    </div> -->
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    </div>
</div>