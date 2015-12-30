<!DOCTYPE html>

<head>
<?php $this->load->view('includes/css');?>
<?php $this->load->view('includes/js');?>

</head>
<body>
<script>
<?php
foreach($refund as $row)
{

$billno=$row->bill_no;
$total_amt=$row->total_amount;
$date=$row->created_date_time;
$createdby=$row->created_by;
$fname=$row->first_name;
$lname=$row->last_name;
$addr=$row->adress;
$phno=$row->phone_no;
}
?>
</script>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Refund Bill</h2><h3 class="pull-right">Refund Bill No # <?php echo $billno;?></h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        <?php echo $fname.''.$lname;?><br>
                        <?php echo $addr;?><br>
                        <?php echo $phno;?><br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>

                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        Cash<br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        <?php echo $date;?><br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td><strong>Item</strong></td>
                                <td class="text-center"><strong>Price</strong></td>

                            </tr>
                            </thead>
                            <tbody>
                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                            <?php foreach($billdetails as $row)
                            {?>
                            <tr>

                                <td><?php echo $row->servicename;?></td>
                                <td class="text-center"><?php echo $row->price;?></td>


                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="thick-line">&nbsp;</td>
                                <td class="thick-line">&nbsp;</td>
                                <td class="thick-line text-center"></td>
                                <td class="thick-line text-right"></td>
                            </tr>


                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right"><strong class="label-warning"><?php echo $total_amt;?></strong></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
     <!-- CONTENT-WRAPPER SECTION END-->
<section class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                &copy; 2015 vyalatech.com |<a href="http://www.vyalatech.com/" target="_blank"  > Devolped by : Vyala Healthcare Divison</a>
            </div>

        </div>
    </div>
</section>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
<?php $this->load->view('includes/js');?>
</body>

</html>
