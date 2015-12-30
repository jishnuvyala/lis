<!DOCTYPE html>
<style type="text/css">
    .table-border {
    }
</style>
<head>
    <?php $this->load->view('includes/css');?>

</head>
<body>
<script type="text/javascript">
    //Java script to open barcode and Card as a popup

    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url, 'popUpWindow', 'height=400,width=500,left=500,top=200,resizable=0,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }
    </script>

<?php $this->load->view('includes/logo');?>
    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <h6 class="header-line">Specimen</h6>

                </div>

            </div>


            <div class="center-block">

                <div class="panel panel-default">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body panel-default">
                        <form id="search">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input id="name" name="name" type="text" placeholder="Specimen Name" class="form-control input-md" data-toggle="tooltip" data-placement="top"
                                           title="Enter the specimen name to search "  >
                                </div>

                                <div class="col-md-2">
                                    <input type="checkbox" name='active' value="1" checked data-toggle="tooltip" data-placement="top"
                                           title="Search based on the active status" >
                                    <label>Active</label>

                                </div>

                                <div class="col-md-2">
                                    <button id="find" name="search" class="btn btn-success btn-sm" type="submit">Search</button>
                                </div>

                                <div class="col-md-2">
                                    <a class="btn btn-success btn-sm" href="javascript:newPopup('<?php echo base_url()?>specimen_master/add_new_view')" >Add new</a>
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
                                <table  class=" table table-bordered tablesorter-green" id="resulttable">
                                    <thead>
                                    <tr>
                                        <th >Name</th>
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

                <!-- CONTENT-WRAPPER SECTION END-->
  <?php $this->load->view('includes/footer');?>
        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY  -->
<?php $this->load->view('includes/js');?>
</body>
<script>
    $(document).ready(function() {
        $(function(){
            $("table#resulttable").tablesorter();
        });
        $('[data-toggle="tooltip"]').tooltip();



        $("#search").submit(function (e) {
            e.preventDefault();
            $("#resulttable tbody tr").remove();
            var datastring = $("#search").serialize();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'specimen_master/search'?>",
                data: datastring,
                datatype: "html",
                success: function (response) {
                    $("#resulttable tbody").append(response).trigger("update");

                },
                error: function (jqXHR, textStatus, errorThrown) {

                    Lobibox.alert("error",
                        {   width : 300,
                            msg: errorThrown
                        });

                }

            });

        });
        $(document).on('click', '#modify', function () {

            //code here ....
            var orderid = $(this).closest("tr").find('td:eq(2)').text();
            var url="<?php echo base_url().'specimen_master/update_view/';?>"+orderid;
            window.open(url,'popUpWindow', 'height=400,width=500,left=500,top=200,resizable=0,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
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
