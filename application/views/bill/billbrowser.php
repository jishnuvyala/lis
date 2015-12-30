<!DOCTYPE html>
<style type="text/css">
    .table-border {
    }
</style>
<head>
<?php $this->load->view('includes/css');?>
    <style type="text/css">
        table td{

            width: auto;
        }
    </style>
    <style type="text/css">
        .highlightred { background-color: indianred; }
        .highlightgreen { background-color: greenyellow; }

        </style>
</head>
<body>

<?php $this->load->view('includes/logo');?>


    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu');?>
     <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container-fluid">
             <div class="row pad-botm">
                 <div class="col-md-12 col-sm-12 col-xs-  text-center">
                     <h4 class="header-line">Bill Browser</h4>

                 </div>

             </div>

                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body panel-default">
                            <form id="search">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <input id="labno" name="labno" type="text" placeholder="LabNo" class="form-control input-sm" data-toggle="tooltip" data-placement="top"
                                           title="Enter Lab No to filter"  >
                                </div>
                                <label class="col-md-1 control-label">From date</label>
                                <div class="col-md-2">
                                    <input id="frmdate" name="frmdate" type="date" placeholder="From Date"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required data-toggle="tooltip" data-placement="top"
                                           title="Select Ordered date from" required >
                                </div>
                                <label class="col-md-1 control-label">To date</label>
                                <div class="col-md-2">
                                    <input id="todate" name="todate" type="date" placeholder="To dateDate" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required data-toggle="tooltip" data-placement="top"
                                           title="Select Ordered Date To" required>
                                </div>
                                <label class="col-md-1 control-label">Bill No</label>
                                <div class="col-md-2">
                                    <input id="billno" name="billno" type="text" placeholder="Billno" class="form-control input-sm" data-toggle="tooltip" data-placement="top"
                                           title="Enter the bill number to filter" >

                                </div>

                                <div class="col-md-1">
                                    <button id="find" name="search" class="btn btn-success" type="submit">Find</button>
                                </div>
                            </div>
                        </div>
                        </form>

            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div id="alert"></div>

                    <!-- Advanced Tables -->
                    <div class="panel panel-info">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body " style=" overflow-y: scroll;">
                            <div class="table table-responsive ">
                                <table  class="table table-bordered " id="resulttable">
                                    <thead>
                                    <tr>

                                        <th>Patient_Name</th>
                                        <th>Lab_No </th>
                                        <th>Bill No</th>
                                        <th class="hidden">Bill ID</th>
                                        <th class=>Bill_Total</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                        <th>Created_By</th>
                                        <th>Created_On</th>
                                        <th>Print</th>


                                    </tr>


                                    </thead>
                                    <tbody>



                                    </tbody>
                                </table>
                            </div>

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
<script>
  $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
      $("#search").submit(function (e) {
          e.preventDefault();
          $("#resulttable td").remove();
          var datastring = $("#search").serialize();
          $.ajax({
              type: "POST",
              url: "<?php echo base_url().'bill_browser/search'?>",
              data: datastring,
              datatype: "html",
              success: function (response) {
                  $("#resulttable").append(response);

              }

          });

      });

      $(document).on('click', '#print' , function() {

          //code here ....
          var billid = $(this).closest("tr").find('td:eq(3)').text();
          window.open("<?php echo base_url().'bill_printout/view/'?>"+billid);

      });

  });



/*  $(document).on ('click','#resulttable tr',function() {
      var selected = $(this).closest("tr").hasClass("highlightred");
      $("#resulttable tr").closest("tr").removeClass("highlightred");
      if(!selected)
          $(this).closest("tr").addClass("highlightred");
  }); */


</script>

</html>
