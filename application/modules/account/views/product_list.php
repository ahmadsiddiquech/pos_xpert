<!-- Page content-->
<div class="content-wrapper">
    <h3>
        <?php 
    $urlPath = $this->uri->segment(5);
    $customer_id = $this->uri->segment(6);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'supplier/invoice_list/'.$customer_id.'/'.$urlPath; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
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
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Total Price</th>
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
                                    <td><?php echo wordwrap($new->product_name) ?></td>
                                    <td><?php echo wordwrap($new->p_c_name) ?></td>
                                    <td><?php echo wordwrap($new->sale_price) ?></td>
                                    <td><?php echo wordwrap($new->qty) ?></td>
                                    <td><?php echo wordwrap($new->amount) ?></td>
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