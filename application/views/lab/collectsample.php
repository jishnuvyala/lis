<!DOCTYPE html>
<head>
    <?php $this->load->view('includes/css'); ?>


</head>
<body>
<style type="text/css">
    table th {

        width: auto;
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
                    <h5 class="header-line">Collect/Recieve Samples</h5>

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

                                <div class="col-md-4">
                                    <button id="find" name="search" class="btn btn-success" type="submit">Find</button>
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
                                    <table class=" table-nonfluid table table-bordered tablesorter-green" id="resulttable">
                                        <thead>
                                        <tr>

                                            <th>Patient</th>
                                            <th>Lab No</th>
                                            <th>Service</th>
                                            <th class="hidden">Order ID</th>
                                            <th class="hidden">Lab Order ID</th>
                                            <th>Specimen</th>
                                            <th>Container</th>
                                            <th>Priority</th>
                                            <th>Ordered_date</th>
                                            <th>Ordered_By</th>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Collect</th>
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
        <?php $this->load->view('includes/js'); ?>
</body>
<script>
    $(document).ready(function () {
        $(function(){
            $("table#resulttable").tablesorter();
        });
        $('[data-toggle="tooltip"]').tooltip();
        $(document).on('submit', '#search', function (e) {
            e.preventDefault();
            $('#resulttable tbody tr').remove();
            var datastring = $("#search").serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'sample_collection/search'?>",
                data: datastring,
                datatype: "html",
                success: function (response) {
                    $("#resulttable tbody").append(response).trigger("update");

                }

            });

        });

        $(document).on('click', '.collect', function () {
            var orderid = $(this).closest("tr").find('td:eq(4)').text();

            var id = parseInt(orderid);
            var hide = $(this).closest("tr");
            var specimen = $(this).closest("tr").find('#specimen').val();
            var container = $(this).closest("tr").find('#container').val();
            var priority = $(this).closest("tr").find('#priority').val();
            var button = $(this).closest("tr").find('#tablebutton');


            if (specimen == 'default' || container == 'default') {
                Lobibox.notify("warning",
                    {
                        msg: "Please choose a valid Specimen/Container"
                    });
            }
            else {

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'sample_collection/update'?>",
                    datatype: "json",
                    data: {
                        id: id,
                        specimen_id: specimen,
                        container_id: container,
                        priority: priority
                    },
                    success: function (response) {
                        var response = JSON.parse(response);
                        if (response.status === true) {
                            button.empty();
                            var barcodeurl = "<?php echo base_url().'card/barcode/';?>";
                            var popup = "javascript:newPopup('";
                            var popup2 = "')";
                            var barcodelink = popup + barcodeurl + response.sample_id + popup2;
                            button.append('<a class="btn btn-info btn-xs" role="button" href="' + barcodelink + '">Print Barcode </a>');

                            Lobibox.notify("success",
                                {
                                    msg: "Sample is Collected.Sample ID is : " + response.sample_id
                                });
                        }
                        else {
                            Lobibox.notify("error",
                                {
                                    msg: "Oops Something went wrong!"
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

        });


    });

</script>

</html>
