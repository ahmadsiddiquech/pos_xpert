<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<style type="text/css">
  @media print {
    html, body {
        width: 80mm;
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
<body>
<?php $x = 1; $y = 1; ?>
<table width="100%">
  <tr>
    <td>
      <table width="100%">
      <tbody>
        <tr>
          <th colspan="100%" align="center">Lab invoice</th>
        </tr>
        <tr>
          <td colspan="5" align="center"><b style="font-size: 22px;"> <?php echo $invoice[0]['org_name']?></b><br><?php echo $invoice[0]['org_address']?><br>Tel: <?php echo $invoice[0]['org_phone'];?></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <td colspan="100%">issue Date: <b><?php echo $invoice[0]['date_time'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Delivery Date : <b><?php echo $invoice[0]['delivery_date'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">invoice id: <b><?php echo $invoice[0]['invoice_id'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Reference No: <b><?php echo $invoice[0]['p_id'];?></b></td>
        </tr>
        <tr><td colspan="100%">&nbsp;</td></tr>
        <tr>
          <td colspan="100%">Patient Name: <b><?php echo $invoice[0]['name'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Age/Sex: <b><?php echo $invoice[0]['age'].'/'.$invoice[0]['gender'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Patient Phone: <b><?php echo $invoice[0]['mobile'];?></b></td>
        </tr>
        <tr><td colspan="100%">&nbsp;</td></tr>
        <tr>
          <td colspan="100%">Referred By: <b><?php echo $invoice[0]['referred_by']; ?></b></td>
        </tr>
        <tr><td colspan="100%"><hr></td></tr>
        <tr align="center">
          <th colspan="2" class="border1"><b>Category</th>
          <th colspan="2" class="border1">Test</th>
          <th colspan="1" class="border1" style="border-right: 1px solid black"><b>Price</th>
        </tr>
        <?php foreach ($invoice as $key => $value) { ?>
        <tr align="center">
          <td colspan="2" class="border1"> <?php echo $value['category_name'];?></td>
          <td colspan="2" class="border1"> <?php echo $value['test_name'];?></td>
          <td colspan="1" class="border1" style="border-right: 1px solid black"> <?php echo $value['charges'];?></td>
          <th></th>
        </tr>
      <?php $x++; }  ?>
      <tr><td colspan="100%"><hr></td></tr>
        <tr>
          <td colspan="4" align="right"><b>Total Amount: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['total_pay']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Discount: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['discount']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Grand Total: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['net_amount']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Cash Recieved: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['paid_amount']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Change: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['remaining']; ?></b></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        
      </tbody>
    </table>
  </td>
</tr>
<tr><td colspan="100%">&nbsp;</td></tr>
<tr><td colspan="100%"><hr></td></tr>
<tr><td colspan="100%">&nbsp;</td></tr>
<tr><td colspan="100%">&nbsp;</td></tr>

<tr>
    <td>
      <table width="100%">
      <tbody>
        <tr>
          <th colspan="100%" align="center">Customer invoice</th>
        </tr>
        <tr>
          <td colspan="5" align="center"><b style="font-size: 22px;"> <?php echo $invoice[0]['org_name']?></b><br><?php echo $invoice[0]['org_address']?><br>Tel: <?php echo $invoice[0]['org_phone'];?></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <td colspan="100%">issue Date: <b><?php echo $invoice[0]['date_time'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Delivery Date : <b><?php echo $invoice[0]['delivery_date'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">invoice id: <b><?php echo $invoice[0]['invoice_id'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Reference No: <b><?php echo $invoice[0]['p_id'];?></b></td>
        </tr>
        <tr><td colspan="100%">&nbsp;</td></tr>
        <tr>
          <td colspan="100%">Patient Name: <b><?php echo $invoice[0]['name'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Age/Sex: <b><?php echo $invoice[0]['age'].'/'.$invoice[0]['gender'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">Patient Phone: <b><?php echo $invoice[0]['mobile'];?></b></td>
        </tr>
        <tr><td colspan="100%">&nbsp;</td></tr>
        <tr>
          <td colspan="100%">Referred By: <b><?php echo $invoice[0]['referred_by']; ?></b></td>
        </tr>
        <tr><td colspan="100%"><hr></td></tr>
        <tr align="center">
          <th colspan="2" class="border1"><b>Category</th>
          <th colspan="2" class="border1">Test</th>
          <th colspan="1" class="border1" style="border-right: 1px solid black"><b>Price</th>
        </tr>
        <?php foreach ($invoice as $key => $value) { ?>
        <tr align="center">
          <td colspan="2" class="border1"> <?php echo $value['category_name'];?></td>
          <td colspan="2" class="border1"> <?php echo $value['test_name'];?></td>
          <td colspan="1" class="border1" style="border-right: 1px solid black"> <?php echo $value['charges'];?></td>
          <th></th>
        </tr>
      <?php $x++; }  ?>
      <tr><td colspan="100%"><hr></td></tr>
        <tr>
          <td colspan="4" align="right"><b>Total Amount: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['total_pay']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Discount: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['discount']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Grand Total: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['net_amount']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Cash Recieved: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['paid_amount']; ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>Change: </b></td>
          <td colspan="1" align="right"><b>Rs.<?php echo $invoice[0]['remaining']; ?></b></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
      </tbody>
    </table>
    </td>
  </tr>
</table>
<div>
<b> Powered by XpertSpot +92-300-2660908</b>
</div>
</body>
<script type="text/javascript">
window.print();
</script>