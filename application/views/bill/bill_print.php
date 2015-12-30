<!DOCTYPE html>

<head>
<?php $this->load->view('includes/css');?>


</head>
<body>
<script>
<?php
foreach($bill as $row)
{

$billno=$row->bill_no;
$billamt=$row->bill_amount;
$discper=$row->discount_percentage;
$totalamt=$row->total_amount;
$paidamt=$row->paid_amount;
$date=$row->created_date;
$createdby=$row->created_by;
$name=$row->name;
$addr=$row->adress;
$phno=$row->phone_no;
$email=$row->email;
}
?>
</script>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2><img src="<?php echo base_url().'assets/img/header.png'?>" style="width:100%; max-width:300px;"></h2>
                    <div class="col-xs-6">
                        <address>
                            Dr Path Lab
                            Varanasi,Up
                            Phone : 9455273689
                        </address>
                    </div>

                </h2><h4 class="pull-right">Bill No # <?php echo $billno;?></h4>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        <?php echo $name;?><br>
                        <?php echo $addr;?><br>
                        <?php echo $phno;?><br>
                        <?php echo $email;?>
                    </address>
                </div>
                <div class="col-xs-6 text-right" align="right">
                    <address>
                        <strong>Bill Date:</strong><br>
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
                    <h3 class="panel-title"><strong>Order Details</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td><strong>Item</strong></td>
                                <td class="text-center"><strong>Price</strong></td>
                                <td class="text-center"><strong>Quantity</strong></td>
                                <td class="text-right"><strong>Totals</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                            <?php foreach($billdetails as $row)
                            {?>
                            <tr>

                                <td><?php echo $row->servicename;?></td>
                                <td class="text-center"><?php echo $row->price;?></td>
                                <td class="text-center"><?php echo $row->quantity;?></td>
                                <td class="text-right">Rs.<?php echo $row->total_price;?></td>

                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="thick-line">&nbsp;</td>
                                <td class="thick-line">&nbsp;</td>
                                <td class="thick-line text-center"></td>
                                <td class="thick-line text-right"></td>
                            </tr>

                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                <td class="thick-line text-right">Rs.<?php echo $billamt;?></td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Discount</strong></td>
                                <td class="no-line text-right"><?php echo $discper;?>%</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right">Rs.<?php echo $totalamt;?></td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Paid</strong></td>
                                <td class="no-line text-right">Rs.<?php echo $paidamt;?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <address>
                Dr Path Lab
                Varanasi,Up
                Phone : 9455273689
                </address>
            </div>
            <div class="col-md-12">
                Generated Using VLI ,Vyala Lab Informatica |<a href="http://www.binarytheme.com/" target="_blank"  > Vyala Technologies</a>
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
