<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<style type="text/css">
  @media print {
    html, body {
        
        font-family: 'Roboto', sans-serif;
    }
  }
  body {
    font-family: 'Roboto', sans-serif;
  }
  .border_bottom {
    border-bottom: 2px solid black;
  }
  .border1 {
    border-left:1px solid black;
    border-top:1px solid black;
  }
</style>
<body class="container pt-5">
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;">Invoice</h1>
    </div>
  </div>
    <div class="row">
    <div class="col-md-3">
      <img src="<?php echo STATIC_ADMIN_IMAGE.'logo.png'?>" height="100px;">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h2>
        <?php echo $invoice[0]['org_name']; ?>
      </h2>
      <h5>
        <?php echo $invoice[0]['org_address']; ?><br>
        Ph: <?php echo $invoice[0]['org_phone']; ?>
      </h5>
    </div>
    <div class="col-md-6">
      <h5 class="display-5 text-break" style="text-align: right;">
        Invoice #<?php echo $invoice[0]['sale_invoice_id']; ?><br>
        Date <?php echo $invoice[0]['date']; ?><br>
        <b><?php echo $invoice[0]['pay_status']; ?></b>
      </h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h5 class="text-break" style="text-align: left;">
        <b>Name: </b><?php if (isset($invoice[0]['name'])) {
          echo $invoice[0]['name'];
        } else{
          echo "Walk-In Customer";
        } ?><br>
        <b>Address: </b><?php if (isset($invoice[0]['address'])) {
          echo $invoice[0]['address']; }?>
      </h5>
    </div>
    <div class="col-md-6">
      <h5>
        <b>Phone: </b><?php if (isset($invoice[0]['phone'])) {
          echo $invoice[0]['phone']; } ?>
      </h5>
    </div>
  </div>
<table width="100%">
  <thead align="center">
    <th colspan="1" class="border1">Item Code</th>
    <th colspan="1" class="border1">Description</th>
    <th colspan="1" class="border1">Unit Price</th>
    <th colspan="1" class="border1">Qty</th>
    <th colspan="1" class="border1" style="border-right: 1px solid black">Amount</th>
  </thead>
  <tbody >
  <?php foreach ($invoice as $key => $value) { ?>
    <tr>
      <td colspan="1" class="border1" style="text-align: center;"> <?php echo 'PR -'.$value['product_id'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['product_name'].' - '.$value['p_c_name'];?></td>
      <td colspan="1" class="border1" style="text-align: center;"> <?php echo $value['sale_price'];?></td>
      <td colspan="1" class="border1" style="text-align: center;"> <?php echo $value['qty'];?></td>
      <td colspan="1" class="border1" style="border-right: 1px solid black;text-align: center"> <?php echo $value['amount'];?></td>
    </tr>
  <?php  }  ?>
  <tr style="text-align: center;height: 50px;font-size: 25px">
      <td colspan="1" class="border1" height="440px;"></td>
      <td colspan="1" class="border1"></td>
      <td colspan="1" class="border1"></td>
      <td colspan="1" class="border1"></td>
      <td colspan="1" class="border1" style="border-right: 1px solid black"></td>
    </tr>
  <tr>
    <th class="border_bottom" colspan="100%"></th>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="left" style="border: 1px solid black"><b>Sub Total: </b></td>
    <td colspan="1" align="right" style="border: 1px solid black">Rs.<?php echo $invoice[0]['total_payable']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="left" style="border: 1px solid black"><b>Discount: </b></td>
    <td colspan="1" align="right" style="border: 1px solid black">Rs.<?php echo $invoice[0]['discount']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="left" style="border: 1px solid black"><b>Total Amount: </b></td>
    <td colspan="1" align="right" style="border: 1px solid black">Rs.<?php echo $invoice[0]['grand_total']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="left" style="border: 1px solid black"><b>Previous Amount: </b></td>
    <td colspan="1" align="right" style="border: 1px solid black">Rs.<?php if (isset($invoice[0]['cust_remaining'])) {
          $cust_remaining = $invoice[0]['cust_remaining'];
          echo $cust_remaining;
        } else{
           $cust_remaining = 0;
          echo $cust_remaining;
        } ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="left" style="border: 1px solid black"><b>Total Paid: </b></td>
    <td colspan="1" align="right" style="border: 1px solid black">Rs.<?php echo $invoice[0]['cash_received']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="left" style="border: 1px solid black"><b>Still Outstanding: </b></td>
    <td colspan="1" align="right" style="border: 1px solid black">Rs.<?php echo $invoice[0]['cash_remaining']+$cust_remaining; ?></td>
  </tr>
  </tbody>
</table>
  <div class="row mt-5 pt-5">
    <div class="col-md-9"></div>
    <div class="col-md-3">
      <h5 style="text-align: center; border-top:1px dashed black">Signature</h5>
    </div>
  </div>
<div>
<b> Powered by XpertSpot +92-300-2660908</b>
<p style="page-break-after: always"> </p>
</div>
</body>
<script type="text/javascript">
window.print();
</script>