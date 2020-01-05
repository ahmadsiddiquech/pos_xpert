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
                                    <td width='2%'><?php echo $i;?></td>
                                    <td><?php echo wordwrap($new->name , 50 , "<br>\n")  ?></td>
                                    <td><?php echo $new->type   ?></td>
                                    <td><?php echo $new->opening_balance   ?></td>
                                    <td><?php echo $new->paid   ?></td>
                                    <td><?php echo $new->remaining   ?></td>
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