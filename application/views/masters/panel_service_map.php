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
            url, 'popUpWindow', 'height=400,width=500,left=400,top=100,resizable=0,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
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
                    <h6 class="header-line">Panel Service Map</h6>

                </div>

            </div>

            <div class="text-center center-block" >

                <div class="panel panel-default center-block">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body panel-default text-center">
                        <form id="search">
                            <div class="form-group">

                                <div class="col-md-3">
                                    <select class="input-sm" id="panel" name="panel">
                                        <?php foreach($panel as $row)
                                        {?>
                                            <option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>

                                        <?php } ?>

                                    </select>
                                </div>



                                <div class="col-md-2">
                                    <button id="find" name="search" class="btn btn-success btn-sm" type="submit">Search</button>
                                </div>

                                <div class="col-md-2">
                                    <a class="btn btn-success btn-sm" href="javascript:newPopup('<?php echo base_url()?>panel_service_master/add_new_view')" >Add new</a>
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
                                    <table  class="table table-hover tablesorter-green " id="resulttable">
                                        <thead>
                                        <tr>
                                            <th >Panel Name</th>
                                            <th>Mapped Services</th>
                                            <th class="hidden">id</th>
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
<?php $this->load->view('includes/js');?>
        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY  -->

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
                url: "<?php echo base_url().'panel_service_master/search'?>",
                data: datastring,
                datatype: "html",
                success: function (response) {
                    $("#resulttable tbody").append(response).trigger("update");

                }

            });

        });
        $(document).on('click', '#delete', function () {

            //code here ....
            var panel_id = $(this).closest("tr").find('td:eq(2)').text();
            var service_id=$(this).closest("tr").find('td:eq(3)').text();

            var tr=$(this).closest("tr");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'panel_service_master/delete'?>",
                data: {
                panelid:panel_id, serviceid:service_id
                    },
                datatype: "json",
                success: function (response) {
                    var data=JSON.parse(response);
                    if(data.status===true)
                    {
                        Lobibox.notify("success",
                            {
                                msg: "Selected mapping is removed"
                            });
                        tr.hide();
                    }
                    else
                    {
                        Lobibox.notify("danger",
                            {
                                msg: "Oops something went wrong"
                            });
                    }
                }

            });

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
