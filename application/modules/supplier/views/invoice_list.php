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
                        <th>Remaining</th>
                        <th>Status</th>
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
                                $supplier_id = $this->uri->segment(4);
                                $product_url = ADMIN_BASE_URL . 'supplier/product_list/' . $new->id.'/'.$new->supplier_name . '/' .$supplier_id;
                                    ?>
                                <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                    <td width='2%'><?php echo $i;?></td>
                                    <td><?php echo wordwrap($new->id)  ?></td>
                                    <td><?php echo wordwrap($new->date)  ?></td>
                                    <td><?php echo wordwrap($new->grand_total)  ?></td>
                                    <td><?php echo wordwrap($new->remaining)  ?></td>
                                    <td><?php echo wordwrap($new->status)  ?></td>
                                    <td>
                                    <?php
                                    echo anchor($product_url, '<i class="fa fa-mail-forward"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'View Invoice Products'));
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