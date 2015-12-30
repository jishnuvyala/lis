<head>
<?php $this->load->view('includes/css');?>
<?php $this->load->view('includes/js');?>
</head>
<body>
<div id="test"></div>

<?php $this->load->view('includes/logo'); ?>
    <!-- LOGO HEADER END-->
<?php $this->load->view('includes/menu'); ?>
     <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
             <div class="row pad-botm">

                 <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-info ">
                         <div class="panel-heading">
                             <div class="panel-body">
                                 <form id="billsubmit" >
                                 <div class="col-md-2" id="patientpanel" tabindex="1">
                                     <input id="labno" name="labno" type="text" placeholder="Enter Lab No" class="input-sm" required>
                                 </div>
                                 <div class="col-md-3" id=""> <label>Name : </label><label id="labelname" class=" label label-info"></label></div>
                                 <div class="col-md-3"> <label>Age : </label><label id="labelage" class=" label label-info"></label></div>
                                 <div class="col-md-3"> <label>Phone No : </label><label id="labelphone" class=" label label-info"></label></div>

                             </div>
                         </div>
                     </div>
                     </div>


                         <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="panel panel-danger">

                                 <div class="panel-body">

                                     <div class="form-group">
                                         <label>Cancelled Item</label>
                                         <table class="table table-hover" id="bill">
                                             <thead>
                                             <tr>
                                                 <th id="th">Select</th>
                                                 <th>Service</th>
                                                 <th class="hidden">id</th>
                                                 <th class="hidden">soid</th>

                                                 <th>Original Bill</th>
                                                 <th>Price</th>
                                             </tr>
                                             </thead>
                                             <tbody>
                                             <tr class="">

                                             <tr>



                                             </tbody>
                                         </table>

                                         <button type="button" class='delete btn btn-info btn-sm'><i class=" fa fa-minus-circle "></i>Delete </button>


                                     </div>

                                 </div>
                             </div>
                         </div>
                     </div>

                 <div class="col-md-4" style="float: right">
                     <div class="panel panel-danger">

                         <div class="panel-body">
                             <div class="col-md-2"><label>Total:</label></div>
                            <div class="col-md-2"><input class="input-sm" type="text" id="total" disabled></div>


                         </div>
                     </div>
                 </div>
             </div>


                    <div id ="button" class="center" align="center">
                        <button id="billsavebutton" name="register" class="btn btn-success" type="submit">Save Bill</button> </div>               </div>

                 </form>

             </div>
            <div id="alert" >
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

</body>
<script language="javascript" type="text/javascript">
    $(document).ready(function()
    {
        $("#labno").change(function () {

            $("#labelname").empty();
            $("#labelage").empty();
            $("#labelphone").empty();

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
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url().'refund_bill/get_cancelldetails'?>",
                            data:{id:id},
                            datatpe:"html",
                            success:function(response)
                            {
                                $("#bill").append(response);
                                calcuatetotal();
                            }


                        });

                    }
                    else
                    {
                        alert("patient not found");
                    }

                }

            });

        });
        $("#billsubmit").submit(function(e) {
            e.preventDefault();
            var service_id=[];
            var order_id=[];
            var count=0;



            $.each($('.serviceid'), function () {

                service_id.push($(this).text());
                count++;

            });
            $.each($('.orderid'), function () {

                order_id.push($(this).text());

            });
            var id=$("#labno").val();
            var total=$("#total").val();
            service_id=JSON.stringify(service_id);
            order_id=JSON.stringify(order_id);
            if(count!=0) {


                $.ajax({

                    type: "POST",
                    url: "<?php echo base_url().'refund_bill/add_bill';?>",

                    data: {
                        id: id,
                        serviceid: service_id,
                        total: total,
                        orderid: order_id
                    },
                    datatype: "json",
                    success: function (response) {
                        var data = JSON.parse(response)
                        if (data.status === true) {
                            Lobibox.notify("success",
                                {
                                    msg: "Refund is made sucesfully"
                                });
                            $("#billsavebutton").hide();
                            $('.form-control').prop("disabled", true);
                            $('#button').append('<a class="btn btn-info" role="button" href="<?php echo base_url().'bill_printout/refund_view/'?>' + data.bill_id + '" target="_blank">Print Bill </a> ');


                        }
                        else {
                            Lobibox.notify("danger",
                                {
                                    msg: "Opps! Something went wrong"
                                });
                        }

                    }
                });
            }
            else
            {
                Lobibox.notify("info",
                    {
                        msg: "You need tohave atleast one item in the bill"
                    });
            }
            });
        });






</script>
<script>


    $(".delete").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();

        calcuatetotal();

    });
</script>

<script>
    function calcuatetotal() {
        var total = 0;
        $.each($('.tableprice'), function () {

            var price = parseFloat($(this).text());
            total = total + price;
        });
        $('#total').val(total);
    }


</script>
<script>

</script>


</html>
