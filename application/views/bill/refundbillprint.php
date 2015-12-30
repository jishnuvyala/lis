<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
    <link rel="stylesheet" href="<?php echo base_url().'assets/billcss/'?>style.css" media="all" />
  </head>
  <body>
 <?php foreach($refund as $row)
 {

     $billno=$row->bill_no;
     $total_amt=$row->total_amount;
     $date=$row->created_date_time;
     $createdby=$row->created_by;
     $fname=$row->first_name;
     $lname=$row->last_name;
     $addr=$row->address;
     $phno=$row->phone_no;
     $email=$row->email;
 }
  ?>
    <header class="clearfix">
      <div id="logo">
        <img src="<?php echo base_url().'assets/img/header.png'?>">
      </div>
      <?php
      foreach($company as $row)
      {
        $cname=$row->name;
        $caddr=$row->address;
        $cphone=$row->phone;
        $cemail=$row->email;

      }
      ?>
      <div id="company">
        <h2 class="name"><?php echo $cname;?></h2>
        <div><?php echo $caddr; ?></div>
        <div><?php echo $cphone; ?></div>
        <div><a href="mailto:<?php echo $cemail; ?>"><?php echo $cemail; ?></a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Billed To:</div>
          <h2 class="name"> <?php echo $fname.' '.$lname;?></h2>
          <div class="address"><?php echo $addr;?></div>
          <div class="email"><a href="mailto:  <?php echo $email;?>"><?php echo $email;?></a></div>
        </div>
        <div id="invoice">
          <h4><?php echo $billno;?></h4>
          <div class="date">Date of Bill:<?php echo $date;?></div>
          <div class="date">Created By:<?php echo $createdby;?></div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>

              <th class="unit">PRICE</th>
          </tr>
        </thead>
        <tbody>
        <?php $count=0;
        foreach($billdetails as $row)
        { $count++;
          ?>
          <tr>
            <td class="no"><?php echo $count;?></td>
            <td class="desc"><h4><?php echo $row->servicename;?></h4></td>
            <td class="unit"><?php echo $row->price;?></td>

          </tr>
<?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="1"></td>
            <td colspan="1">TOTAL REFUND</td>
            <td>-<?php echo $total_amt;?></td>

        </tfoot>
      </table>
      <div id="thanks"> <img src="<?php echo base_url().'assets/img/seal.jpg'?>"></div>
      <div id="notices">
        <div></div>
        <div class="notice">This was created using Vyala Lab Informatica <a href="http://www.vyalatech.com">Vyalatech.com</a></div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>