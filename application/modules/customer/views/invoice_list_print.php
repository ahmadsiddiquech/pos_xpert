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
    padding: 10px;
  }
</style>
<body class="container pt-5">
    <div class="row">
    <div class="col-md-3">
      <img src="<?php echo STATIC_ADMIN_IMAGE.'logo.png'?>" height="100px;">
    </div>
    <div class="col-md-6 ">
      <h1 style="text-align: center;">
      <?php echo $invoice[0]['org_name']; ?>
      </h1>
      <h5 class="display-5 text-break" style="text-align: center;">
        <?php echo $invoice[0]['org_address']; ?><br>
        Ph: <?php echo $invoice[0]['org_phone']; ?>
      </h5>
    </div>
    <div class="col-md-3">
      <h2 style="text-align: right;">
      Sale Invoice Report
      </h2>
      <h5 class="display-5 text-break" style="text-align: right;">
        Date: <?php echo date('Y-m-d'); ?><br>
      </h5>
    </div>
  </div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
  <p class="border_bottom"></p>
  <div class="row pl-3 pr-3">
    <div class="col-md-5" style="border: 1px solid black;">
      <h2 style="text-align: left;">
      Report From
      </h2>
      <h5 class="display-5 text-break" style="text-align: left;">
        <?php echo $invoice[0]['org_name']; ?><br>
        <?php echo $invoice[0]['org_address']; ?><br>
        <?php echo $invoice[0]['org_phone']; ?><br>
      </h5>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-5" style="border: 1px solid black;">
      <h2 style="text-align: left;">
      Report To
      </h2>
      <h5 class="display-5 text-break" style="text-align: left;">
        <?php echo $invoice[0]['name']; ?><br>
        <?php echo $invoice[0]['address']; ?><br>
        <?php echo $invoice[0]['phone']; ?><br>
      </h5>
    </div>
  </div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
<table width="100%">
  <thead align="center">
    <th colspan="1" class="border1">Invoice Id</th>
    <th colspan="1" class="border1">Date</th>
    <th colspan="1" class="border1">Total</th>
    <th colspan="1" class="border1">Discount</th>
    <th colspan="1" class="border1">Grand Total</th>
    <th colspan="1" class="border1">Cash Received</th>
    <th colspan="1" class="border1">Remaining</th>
    <th colspan="1" class="border1" style="border-right: 1px solid black">Status</th>
  </thead>
  <tbody>
  <?php 
  $total = 0;
  $discount = 0;
  $grand_total = 0;
  $cash_received = 0;
  $cash_remaining = 0;
  foreach ($invoice as $key => $value) { 
    $total = $total + $value['total_payable'];
    $discount = $discount + $value['discount'];
    $grand_total = $grand_total + $value['grand_total'];
    $cash_received = $cash_received + $value['cash_received'];
    $cash_remaining = $cash_remaining + $value['cash_remaining'];
    ?>
    
    <tr style="text-align: center;">
      <td colspan="1" class="border1"> <?php echo 'I -'.$value['sale_invoice_id'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['date'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['total_payable'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['discount'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['grand_total'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['cash_received'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['cash_remaining'];?>
      <td colspan="1" class="border1" style="border-right: 1px solid black"> <?php echo $value['pay_status'];?></td>
    </tr>
  <?php  }  ?>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="4" align="right"><b><h3>Total Amount: </h3></b></td>
          <td colspan="2" align="right"><b><h3>Rs.<?php echo $total; ?></h3></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b><h3>Discount: </h3></b></td>
          <td colspan="2" align="right"><b><h3>Rs.<?php echo $discount; ?></h3></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b><h3>Grand Total: </h3></b></td>
          <td colspan="2" align="right"><b><h3>Rs.<?php echo $grand_total; ?></h3></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b><h3>Cash Recieved: </h3></b></td>
          <td colspan="2" align="right"><b><h3>Rs.<?php echo $grand_total - $cash_remaining; ?></h3></b></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <td colspan="4" align="right"><b><h3>Remaining: </h3></b></td>
          <td colspan="2" align="right"><b><h3>Rs.<?php echo $cash_remaining; ?></h3></b></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
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