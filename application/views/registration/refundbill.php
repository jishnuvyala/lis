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
                     <h4 class="header-line">Patient Browser</h4>

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
                                    <input id="firstname" name="fname" type="text" placeholder="First Name" class="form-control input-sm" >
                                </div>
                                <div class="col-md-2">
                                    <input id="lastname" name="lname" type="text" placeholder="Last Name" class="form-control input-sm" >                                </div>
                                <div class="col-md-2">
                                    <input id="age" name="age" type="number" placeholder="Age" class="form-control input-sm" >
                                </div>
                                <div class="col-md-2">
                                    <input id="addr" name="addr" type="text" placeholder="Address" class="form-control input-sm" >
                                </div>
                                <div class="col-md-2">
                                    <input id="phone" name="phone" type="number" placeholder="Mobile Number" class="form-control input-sm" >
                                </div>


                                <div class="col-md-2">
                                    <button id="find" name="search" class="btn btn-success btn-sm" type="submit">Find</button>
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

                                        <th>Lab No</th>
                                        <th>First_Name</th>
                                        <th>Last_Name</th>
                                        <th >Age</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>District</th>
                                        <th>State</th>
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

      $("#search").submit(function (e) {
          e.preventDefault();
          $("#resulttable td").remove();
          var datastring = $("#search").serialize();
          alert(datastring);

          $.ajax({
              type: "POST",
              url: "<?php echo base_url().'patient_browser/search'?>",
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
