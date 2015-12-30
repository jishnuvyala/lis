<!DOCTYPE html>
<style type="text/css">
    .table-border {
    }
</style>
<head>
    <?php $this->load->view('includes/css');?>

    <style type="text/css">
    </style>
    <style type="text/css">
        .highlightred { background-color: indianred; }
        .highlightgreen { background-color: greenyellow; }

    </style>
</head>
<body>
<script type="text/javascript">
    //Java script to open barcode and Card as a popup

    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url, 'popUpWindow', 'height=600,width=1200,left=100,top=10,resizable=0,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }
    </script>

<?php $this->load->view('includes/logo');?>
    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12 col-sm-12 col-xs-12 center-block text-center">
                    <h6 class="header-line">Service Master</h6>

                </div>

            </div>

            <div class="text-center center-block" >

                <div class="panel panel-default center-block">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body panel-default text-center">
                        <form id="search">
                            <div class="form-group">
                                <div class="col-md-2 required"><input type="text" name="name" class="form-control input-md-sm" data-toggle="tooltip" data-placement="top" title="Enter the service name to search" placeholder="Service Name"></div>
                                <div class="col-md-2"><select name="category" class="form-control input-md-sm" data-toggle="tooltip" data-placement="top" title="Choose the appropriate category to search">
                                        <option value="default">Category</option>
                                        <?php foreach($category as $row){?>
                                            <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                        <?php }?>

                                    </select></div>
                                <div class="col-md-2"><select name="result_type" class="form-control input-md" data-toggle="tooltip" data-placement="top" title="Choose the appropriate result type to search">
                                        <option value="default">Result Type</option>
                                        <option value="N">Numeric</option>
                                        <option value="A">Alpha Numeric</option>
                                        <option value="R">Report</option>
                                    </select></div>
                                <div class="col-md-2"><input type="checkbox" name='active' value="1" checked>
                                    <label>Active</label></div>
                                <div class="col-md-2"><input type="checkbox" name='panel' value="1" >
                                    <label>Panel</label></div>
                                <div class="col-md-2"><button class="btn btn-sm btn-primary" type="submit">Search</button> <a class="btn btn-success btn-sm" href="javascript:newPopup('<?php echo base_url()?>service_master/add_new_view')" >Add new</a></div>
                                <div class="col-md-2">

                                </div>
                                </div>

                    </div>
                    </form>

                </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div id="alert"></div>
                        <!-- Advanced Tables -->
                        <div class="panel panel-info">
                            <div class="panel-heading">

                            </div>
                            <div class="panel-body " style=" overflow-y: scroll;">
                                <div class="table-responsive ">
                                    <table  class="table table-hover tablesorter-green" id="resulttable">
                                        <thead>
                                        <tr>
                                            <th >Name</th>
                                            <th >Category</th>
                                            <th >Result_Type</th>
                                            <th >Price</th>
                                            <th >Active Status</th>
                                            <th class="hidden">id</th>
                                            <th >Edit</th>
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
    </div>
<?php $this->load->view('includes/footer');?>
<!-- CONTENT-WRAPPER SECTION END-->

<!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
<!-- CORE JQUERY  -->
<?php $this->load->view('includes/js');?>
        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY  -->

</body>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $(function(){
            $("table#resulttable").tablesorter();
        });

        $("#search").submit(function (e) {
            e.preventDefault();
            $("#resulttable tbody tr").remove();
            var datastring = $("#search").serialize();


            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'service_master/search'?>",
                data: datastring,
                datatype: "html",
                success: function (response) {
                    $("#resulttable tbody").append(response).trigger("update");

                }

            });

        });
        $(document).on('click', '#modify', function () {

            //code here ....
            var orderid = $(this).closest("tr").find('td:eq(5)').text();

            var url="<?php echo base_url().'service_master/update_view/';?>"+orderid;
            window.open(url,'popUpWindow', 'height=600,width=1200,left=100,top=10,resizable=0,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
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
