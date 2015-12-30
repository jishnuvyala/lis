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
                     <h4 class="header-line">Create Refunds</h4>

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
                                    <input id="labno" name="labno" type="text" placeholder="Lab No" class="form-control input-sm" >
                                </div>
                                <div class="col-md-2">
                                    <label class="text-normal">Patient Name:</label> <label class="label-info" id="labelname"></label>
                                </div>
                                <div class="col-md-1">
                                    <label class="text-normal">Age:</label> <label class="label-info" id="labelage"></label>

                            </div>
                                <div class="col-md-2">
                                    <label class="text-normal">Phone No:</label> <label class="label-info" id="labelphone"></label>
                                </div>
                                <div class="col-md-4"><label class="text-normal">Email:</label> <label class="label-info" id="labelemail"></label></div>

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

      $("#labno").change(function () {

          $("#labelname").empty();
          $("#labelage").empty();
          $("#labelphone").empty();
          $("#labelemail").empty();
          var id=$("#labno").val();
          $.ajax({
              type: "POST",
              url: "<?php echo base_url().'refund_bill/findpatient'?>",
              data:{id:id},
              datatype: "json",
              success: function (response) {
                  var data=JSON.parse(response);
                  if(data.status===true)
                  {
                      $("#labelname").append(data.name);
                      $("#labelage").append(data.age);
                      $("#labelphone").append(data.phone);
                      $("#labelemail").append(data.email);

                  }
                  else
                  {
                      alert("patient not found");
                  }

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
