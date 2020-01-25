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
      <?php echo $org[0]['org_name']; ?>
      </h1>
      <h5 class="display-5 text-break" style="text-align: center;">
        <?php echo $org[0]['org_address']; ?><br>
        Ph: <?php echo $org[0]['org_phone']; ?>
      </h5>
    </div>
    <div class="col-md-3">
      <h2 style="text-align: right;">
      Product Report
      </h2>
      <h5 class="display-5 text-break" style="text-align: right;">
        Issue Date: <?php echo date('Y-m-d'); ?><br>
      </h5>
    </div>
  </div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
  <div class="row">
    <div class="col-md-6">
      <h4>
        From Date : <?=$from_date?>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h4>
        To Date : <?=$to_date?>
      </h4>
    </div>
  </div>
  <p class="border_bottom"></p>
  <div class="row pl-3 pr-3">
    <div class="col-md-5" style="border: 1px solid black;">
      <h2 style="text-align: left;">
      Report From
      </h2>
      <h5 class="display-5 text-break" style="text-align: left;">
        <?php echo $org[0]['org_name']; ?><br>
        <?php echo $org[0]['org_address']; ?><br>
        <?php echo $org[0]['org_phone']; ?><br>
      </h5>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-5" style="border: 1px solid black;">
      <h2 style="text-align: left;">
      Product Details
      </h2>
      <h5 class="display-5 text-break" style="text-align: left;">
        <?php echo $product[0]['name'].' - '.$product[0]['p_c_name']; ?><br>
        <?php echo 'In-Stock - '.$product[0]['stock']; ?><br>
        <?php echo 'Sale Price - '.$product[0]['sale_price']; ?><br>
        <?php echo 'Purchase Price - '.$product[0]['purchase_price']; ?>
      </h5>
    </div>
  </div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
<table width="100%">
  <thead align="center">
    <th colspan="1" class="border1">Sr. No</th>
    <th colspan="1" class="border1">Date</th>
    <th colspan="1" class="border1">Quantity</th>
    <th colspan="1" class="border1">Sale Price</th>
    <th colspan="1" class="border1" style="border-right: 1px solid black">Total</th>
  </thead>
  <tbody>
  <?php 
  $total = 0;
  $i = 1;
  foreach ($report as $key => $value) { 
    $total = $total + $value['amount'];
    ?>

    <tr style="text-align: center;">
      <td colspan="1" class="border1"> <?php echo $i;?></td>
      <td colspan="1" class="border1"> <?php echo $value['date'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['qty'];?></td>
      <td colspan="1" class="border1"> <?php echo $value['sale_price'];?></td>
      <td colspan="1" class="border1" style="border-right: 1px solid black"> <?php echo $value['amount'];?>
      </td>
    </tr>
  <?php  $i++; }  ?>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="2" align="right"><b><h3>Total Amount: </h3></b></td>
          <td colspan="2" align="right"><b><h3>Rs.<?php echo $total; ?></h3></b></td>
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