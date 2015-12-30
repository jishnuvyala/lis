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

<div>
    <?php $this->load->view('includes/logo');?>

    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu');?>
     <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container-fluid">
             <div class="row pad-botm">
                 <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                     <h6 class="header-line">Cancel Orders</h6>

                 </div>

             </div>

                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body panel-default">
                            <form id="search">
                            <div class="form-group">
                                <div class="col-md-1">
                                    <input id="labno" name="labno" type="text" placeholder="LabNo" class="form-control input-sm" required data-toggle="tooltip" data-placement="top"
                                           title="Enter Lab No " >
                                </div>
                                <label class="col-md-1 control-label">From date</label>
                                <div class="col-md-2">
                                    <input id="frmdate" name="frmdate" type="date" placeholder="From Date"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required required data-toggle="tooltip" data-placement="top"
                                           title="Select Ordered date from">
                                </div>
                                <label class="col-md-1 control-label">To date</label>
                                <div class="col-md-2">
                                    <input id="todate" name="todate" type="date" placeholder="To dateDate" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required required data-toggle="tooltip" data-placement="top"
                                           title="Select Ordered date to">
                                </div>
                                <label class="col-md-1 control-label">Status</label>
                                <div class="col-md-2">
                                    <label><input type="checkbox" name= 'ordered' value="1" data-toggle="tooltip" data-placement="top"
                                                  title="View Services with status ordered" checked>Odered</label>
                                    <label><input type="checkbox" name='inprogress' value="1"  data-toggle="tooltip" data-placement="top"
                                                  title="View services with status Inprogress" checked>In Progress</label>
                                </div>

                                <div class="col-md-2">
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
                                <table  class=" table table-bordered " id="resulttable">
                                    <thead>
                                    <tr>

                                        <th>Patient_Name</th>
                                        <th>Lab_No </th>
                                        <th>Service_Order</th>
                                        <th class="hidden">Service_Order_Id</th>
                                        <th class=>Ordered_By</th>
                                        <th>Ordered_Date_Time</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Cancel</th>


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
<?php $this->load->view('includes/footer');?>
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
              url: "<?php echo base_url().'cancel_order/search'?>",
              data: datastring,
              datatype: "html",
              success: function (response) {
                  $("#resulttable").append(response);

              }

          });

      });

      $(document).on('click', '#cancel' , function() {

          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(3)').text();
          var savebutton= $(this).closest("tr");
          var remarks=$(this).closest("tr").find('#remarks').val();
          if(remarks=='')
          {
              Lobibox.notify("warning",
                  {
                      msg: "Enter cancellation remarks"
                  });
          }
          else{
                if(confirm("Are You Sure")) {


                    $.ajax({
                        type: "post",
                        url: "<?php echo base_url().'cancel_order/cancel'?>",
                        data: {
                            orderid: orderid,
                            remarks: remarks
                        },
                        datatype: "json",
                        success: function (response) {
                            var response = JSON.parse(response);
                            if (response.status === true) {
                                Lobibox.notify("success",
                                    {
                                        msg: "Order is cancelled"
                                    });
                                savebutton.hide();


                            }
                            else {
                                Lobibox.notify("error",
                                    {
                                        msg: "Something Went wrong"
                                    });

                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                            Lobibox.alert("error",
                                {
                                    width: 300,
                                    msg: errorThrown
                                });

                        }


                    });
                }

          }

      });

  });





</script>

</html>
