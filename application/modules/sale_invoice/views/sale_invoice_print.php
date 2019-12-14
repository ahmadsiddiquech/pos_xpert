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
      Invoice
      </h2>
      <h5 class="display-5 text-break" style="text-align: right;">
        Invoice #<?php echo $invoice[0]['sale_invoice_id']; ?><br>
        Date <?php echo $invoice[0]['date']; ?>
      </h5>
    </div>
  </div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
  <p class="border_bottom"></p>
  <div class="row pl-3 pr-3">
    <div class="col-md-5" style="border: 1px solid black;">
      <h2 style="text-align: left;">
      Invoice From
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
      Invoice To
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
    <th colspan="1" class="border1">Item Code</th>
    <th colspan="1" class="border1">Description</th>
    <th colspan="1" class="border1">Unit Price</th>
    <th colspan="1" class="border1">Qty</th>
    <th colspan="1" class="border1" style="border-right: 1px solid black">Amount</th>
  </thead>
  <tbody>
  <?php foreach ($invoice as $key => $value) { ?>
    <tr style="text-align: center;">
      <td colspan="1" class="border1"> <?php echo 'PR -'.$value['product_id'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['product_name'].' - '.$value['p_c_name'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['sale_price'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['qty'];?></td>
      <td colspan="1" class="border1" style="border-right: 1px solid black"> <?php echo $value['amount'];?></td>
    </tr>
  <?php  }  ?>
  <tr>
          <td colspan="4" align="right"><b>Total Amount: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['total_payable']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Discount: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['discount']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Grand Total: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['grand_total']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Cash Recieved: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['cash_received']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Change: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['change']; ?></b></td>
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