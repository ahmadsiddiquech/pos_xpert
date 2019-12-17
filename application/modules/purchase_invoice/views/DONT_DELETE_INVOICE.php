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
          <td colspan="5" align="center"><b style="font-size: 22px;"> <?php echo $invoice[0]['org_name']?></b><br><?php echo $invoice[0]['org_address']?><br>Tel: <?php echo $invoice[0]['org_phone'];?></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <td colspan="100%">Date: <b><?php echo $invoice[0]['date'];?></b></td>
        </tr>
        <tr>
          <td colspan="100%">invoice id: <b><?php echo $invoice[0]['sale_invoice_id'];?></b></td>
        </tr>
        <tr><td colspan="100%">&nbsp;</td></tr>
        <tr>
          <td colspan="100%">Customer Name: <b><?php echo $invoice[0]['customer_name'];?></b></td>
        </tr>
        <tr><td colspan="100%">&nbsp;</td></tr>
        <tr><td colspan="100%"><hr></td></tr>
        <tr align="center">
          <th colspan="2" class="border1"><b>Description</th>
          <th colspan="1" class="border1"><b>Unit Price</th>
          <th colspan="1" class="border1">Qty</th>
          <th colspan="1" class="border1" style="border-right: 1px solid black"><b>Amount</th>
        </tr>
        <?php foreach ($invoice as $key => $value) { ?>
        <tr align="center">
          <td colspan="2" class="border1"> <?php echo $value['product_name'].' - '.$value['p_c_name'];?></td>
          <td colspan="1" class="border1"> <?php echo $value['sale_price'];?></td>
          <td colspan="1" class="border1"> <?php echo $value['qty'];?></td>
          <td colspan="1" class="border1" style="border-right: 1px solid black"> <?php echo $value['amount'];?></td>
          <th></th>
        </tr>
      <?php $x++; }  ?>
      <tr><td colspan="100%"><hr></td></tr>
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
  </td>
</tr>
</table>
<div>
<b> Powered by XpertSpot +92-300-2660908</b>
<p style="page-break-after: always"> </p>
</div>
</body>
<script type="text/javascript">
window.print();
</script>