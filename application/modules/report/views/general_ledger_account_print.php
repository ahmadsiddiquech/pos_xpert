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
    <div class="col-md-9">
      <h1 style="text-align: center;">
      <?php echo $invoice[0]['org_name']; $total=0; ?>
      </h1>
      <h5 class="display-5 text-break" style="text-align: center;">
        <?php echo $invoice[0]['org_address']; ?>
        &nbsp;Ph: <?php echo $invoice[0]['org_phone']; ?><br>
        General Ledger for the period
      </h5>
    </div>
  </div>
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
  <div class="row">
    <div class="col-md-9">
      <h4>
        Account Title : <?php echo $invoice[1]['name'].' - '. $type; ?>
      </h4>
    </div>
    <div class="col-md-3">
      <h5>
        From Date : <?=$from_date?><br>
        Upto Date : <?=$to_date?>
      </h5>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-8">
      &nbsp;
    </div>
    <div class="col-md-4">
      <h4>
        <b>Opening Balance : </b><?php echo $invoice[1]['opening_balance']?>
      </h4>
    </div>
  </div>
  <div class="row">&nbsp;</div>
  <p class="border_bottom"></p>
  <div class="row">
    <div class="col-md-2"><b>Date</b></div>
    <div class="col-md-2"><b>Ref No</b></div>
    <div class="col-md-4"><b>Description</b></div>
    <div class="col-md-1"><b>Debit</b></div>
    <div class="col-md-1"><b>Credit</b></div>
    <div class="col-md-2"><b>Balance</b></div>
  </div>
  <p class="border_bottom"></p>
  <?php if($type == 'Cash-in-hand') { ?>
  <?php foreach ($report as $key => $value) {
if ($value['transaction_type'] == 'CR' || $value['transaction_type'] == 'BR') {
  $total = $total + $value['remaining'];
}
else{
  $total = $total - $value['remaining'];
}
    ?>
  <div class="row">
    <div class="col-md-2"><?=$value['date']?></div>
      <div class="col-md-2"><?=$value['transaction_type'].' - '.$value['id']?></div>
      <div class="col-md-4"><b><?='From - '.$value['account_from_name'].'('.$value['account_from_type'].')'.' - To - '.$value['account_to_name'].'('.$value['account_to_type'].')'?></b></div>
      <?php if ($value['transaction_type'] == 'CR' || $value['transaction_type'] == 'BR') { ?>
        <div class="col-md-1"><?=$value['remaining']?></div>
        <div class="col-md-1"></div>
      <?php } else{ ?>
        <div class="col-md-1"></div>
        <div class="col-md-1"><?=$value['remaining']?></div>
       <?php } ?>
    <div class="col-md-2"><?=$total ?></div>
  </div>
  <p class="border_bottom"></p>
  <?php }
  } elseif ($type == 'Bank') { ?>
    <?php foreach ($report as $key => $value) {
if ($value['transaction_type'] == 'BD') {
  $total = $total + $value['remaining'];
}
else{
  $total = $total - $value['remaining'];
}
    ?>
  <div class="row">
    <div class="col-md-2"><?=$value['date']?></div>
      <div class="col-md-2"><?=$value['transaction_type'].' - '.$value['id']?></div>
      <div class="col-md-4"><b><?='From - '.$value['account_from_name'].'('.$value['account_from_type'].')'.' - To - '.$value['account_to_name'].'('.$value['account_to_type'].')'?></b></div>
      <?php if ($value['transaction_type'] == 'BD') { ?>
        <div class="col-md-1"></div>
        <div class="col-md-1"><?=$value['remaining']?></div>
      <?php } else{ ?>
        <div class="col-md-1"><?=$value['remaining']?></div>
        <div class="col-md-1"></div>
       <?php } ?>
    <div class="col-md-2"><?=$total ?></div>
  </div>
  <p class="border_bottom"></p>
  <?php }
  } ?>

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