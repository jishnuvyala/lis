<!DOCTYPE html>
<head>
    <?php $this->load->view('includes/css'); ?>


</head>
<body>
<style type="text/css">
    .table-nonfluid {
        width: auto;
        white-space: nowrap;
    }
</style>

<script type="text/javascript">
    //Java script to open barcode and Card as a popup

    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url, 'popUpWindow', 'height=200,width=400,left=500,top=200,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }

    function newPopup_barcode(url) {
        popupWindow = window.open(
            url, 'popUpWindow', 'height=50,width=30,left=500,top=200,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }
    <!-- start: Header -->
</script>
<div>
    <?php $this->load->view('includes/logo'); ?>
    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row pad-botm">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <h6 class="header-line">Result Browser</h6>

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
                                           title="Enter Lab No to filter" required >
                                </div>
                                <label class="col-md-2 control-label">From date</label>

                                <div class="col-md-2">
                                    <input id="frmdate" name="frmdate" type="date" placeholder="From Date"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required data-toggle="tooltip" data-placement="top"
                                           title="Select Ordered date from" required >

                                </div>
                                <label class="col-md-2 control-label">To date</label>

                                <div class="col-md-2">
                                    <input id="todate" name="todate" type="date" placeholder="To dateDate" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required data-toggle="tooltip" data-placement="top"
                                           title="Select Ordered Date To" required>
                                </div>

                                <div class="col-md-2">
                                    <button id="find" name="search" class="btn btn-sm  btn-success" type="submit">Find</button>
                                    <a id="print" name="print" class="btn btn-sm  btn-primary"  >Print Result</a>



                                </div>
                            </div>
                    </div>
                    </form>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="alert"></div>
                        <!-- Advanced Tables -->
                        <div class="panel panel-info">
                            <div class="panel-heading">

                            </div>
                            <div class="panel-body " style=" overflow-y: scroll;">
                                <div class="table-responsive">
                                    <table class="table-nonfluid table table-bordered tablesorter " id="resulttable">
                                        <thead>
                                        <tr id="header">

                                            <th>Patient &nbsp;</th>
                                            <th>Lab No</th>
                                            <th>Service</th>
                                            <th class="hidden">Orderid</th>
                                            <th>Method</th>
                                            <th>Normal_Range</th>
                                            <th>Unit</th>
                                            <th>Result</th>
                                            <th>Status</th>
                                            <th>Date Time</th>
                                            <th>Certified/Rectified_By</th>


                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>


                            </div>

                        </div>
                        </div>
                        <div class="col-md-6 col-lg-6 right-div" >
                            Result Legend: <label class="highlightblue label">Result is low </label>
                            <label class="highlightgreen label">Normal Result </label>
                            <label class="highlightred label">Result is high </label>
                            <div class="panel panel-warning">
                                <div class="panel-body col-md-12 ">

                    </div>
                </div>
            </div>
        </div>
        <!-- CONTENT-WRAPPER SECTION END-->
        <?php $this->load->view('includes/footer');?>
        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY  -->
        <?php $this->load->view('includes/js'); ?>
</body>
<script>
    $(document).ready(function () {
        $("#print").hide();
        $('[data-toggle="tooltip"]').tooltip();
        $("#search").submit(function (e) {
            e.preventDefault();
            $("#resulttable td").remove();
            var datastring = $("#search").serialize();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'result_browser/search'?>",
                data: datastring,
                datatype: "html",
                success: function (response) {
                    $("#header").show();
                    $("#resulttable").append(response);
                    $("#print").show();

                }

            });

        });
        $("#print").click(function()
        {
            var labno=$("#labno").val();
            var frmdate=$("#frmdate").val();
            var todate=$("#todate").val();
            if(labno=='' || frmdate=='' || todate=='' )
            {
                Lobibox.notify("warning",
                    {
                        msg: "Please fill all the fields"
                    });
            }
            else
            {
                url="<?php echo base_url().'result_browser/print_result/' ?>";
                window.open(url+labno+'/'+frmdate+'/'+todate)
            }

        });

        $(document).on('click', '#viewreport' , function() {

            var orderid = $(this).closest("tr").find('td:eq(3)').text();

            var url="<?php echo base_url().'report/view/';?>";

            window.open(url+orderid)

        });


    });

</script>

</html>
