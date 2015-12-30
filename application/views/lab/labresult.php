<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
    <link rel="stylesheet" href="<?php echo base_url().'assets/billcss/'?>labstyle.css" media="all" />
  </head>
  <body>

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
      foreach($patient as $row)
      {
        $pname=$row->patient_name;
        $paddr=$row->address;
        $pphone=$row->phone_no;
        $pemail=$row->email;
        $page=$row->age;
        $labno=$row->labno;

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

          <div class="to"><h2>Patient Info:</h2></div>
          <h2 class="name">Name: <?php echo $pname;?></h2>
          <div class="address">Age : <?php echo $page;?></div>
          <div class="address">Address : <?php echo $paddr;?></div>
          <div class="address">Phone : <?php echo $pphone;?></div>
          <div class="email">Email : <?php echo $pemail;?></div>
        </div>
        <div id="invoice">
          <h4>Lab No : <?php echo $labno;?></h4>
          <div class="date">Date of Bill: <?php echo date('Y-M-D');?></div>
          <?php $user=$this->session->userdata('logged_in');?>
          <div class="date">Printed By: <?php echo $user['username'];?></div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
              <th class="no" ><strong>Test Name</strong> </th>
              <th class="no"><strong>Sample ID</strong></th>
              <th class="no" ><strong>Method Used</strong></th>
              <th class="no"><strong>Range</strong></th>
              <th class="no"><strong>Unit</strong></th>
              <th class="no"><strong>Result</strong></th>
              <th class="no"><strong>Category<strong></th>

          </tr>
        </thead>
        <tbody>
        <?php foreach($result as $row) { ?>
           <tr>
           <td class='unit' ><?php if($row->panel_yesno=1){echo  $row->order_service.'-'. $row->lab_service;} else{ echo $row->lab_service; }?> </td >
               <td class='unit'' > <?php echo $row->sample_id;?></td >
          <td class='unit'' > <?php echo $row->method;?></td >
               <td class='unit'' ><?php if($row->result_type='N'){echo $row->normal_range_from .'-'. $row->normal_range_to;}else{ echo $row->alpha_normal;}?></td >
               <td class='unit'' > <?php echo $row->unit;?></td >
         <td class='unit'' > <?php if($row->result_type='N'){echo $row->numeric_result;}else{ echo $row->alpha_resultl;}?></td >
               <td class='unit'' > <?php echo $row->category;?></td >
           </tr >
<?php }?>

        </tbody>
        <tfoot>

      </table>
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