<head>
    <?php $this->load->view('includes/css'); ?>
    <?php $this->load->view('includes/js'); ?>
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
                            <form id="billsubmit">
                                <div class="col-md-2" id="patientpanel" tabindex="1">
                                    <input id="labno" name="labno" type="text" placeholder="Enter Lab No"
                                           class="input-sm" data-toggle="tooltip" data-placement="top"
                                           title="Enter Lab No and Tab Out" required>
                                </div>
                                <div class="col-md-3" id=""><label>Name : </label><label id="name"
                                                                                         class=" label label-info"></label>
                                </div>
                                <div class="col-md-3"><label>Age : </label><label id="age"
                                                                                  class=" label label-info"></label>
                                </div>
                                <div class="col-md-3"><label>Phone No : </label><label id="phone"
                                                                                       class=" label label-info"></label>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="panel" id="service_panel">
                    <div class="panel-heading">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>

                                        <th>Service</th>
                                        <th></th>
                                        <th></th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="">

                                        <td>
                                            <div class="form-group "><select id="service" name="service"
                                                                             class="form-control" required>
                                                    <option value="select">-----Select Services------</option>
                                                    <?php foreach ($service as $row) { ?>
                                                        <option
                                                            value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                                    <?php } ?>
                                                </select></div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="form-group"><input class="form-control center" type="number"
                                                                           style="width:50px;" name="qnty" id="qnty"
                                                                           value="1"/></div>
                                        </td>
                                        <td>
                                            <div class="form-group"><input class="form-control center" type="text"
                                                                           style="width:50px;" name="price" id="price"
                                                                           disabled/></div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <button type="button" class='delete btn btn-info btn-sm'><i
                                        class=" fa fa-minus-circle "></i>Delete
                                </button>
                                <button type="button" class='addmore btn btn-info btn-sm'><i
                                        class=" fa fa-plus-circle "></i>Add Item
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-danger">

                            <div class="panel-body">

                                <div class="form-group">
                                    <label>Bill Items</label>
                                    <table class="table table-hover" id="bill">
                                        <thead>
                                        <tr>
                                            <th id="th">Select</th>
                                            <th>Service</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="">

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-danger" id="billdetails_panel">

                        <div class="panel-body">

                            <div class="form-group">
                                <label>Bill Details</label>
                                <table class="table table-hover" id="bill">
                                    <thead>
                                    <tr>
                                        <th>Bill Amount</th>
                                        <th>Discount Percentage</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><input class="form-control" type="number" style="width:100px;"
                                                   name="billamt" id="billamt" disabled/></td>
                                        <td><input class="form-control" type="number" style="width:100px;" name="discnt"
                                                   id="discnt" pattern="[0-9.]+"/></td>
                                        <td><input class="form-control" type="number" style="width:100px;"
                                                   name="totalamt" id="totalamt" disabled/></td>
                                        <td><input class="form-control" type="text" style="width:100px;" name="billamt"
                                                   id="paidamt" pattern="[0-9.]+" required/></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div id="button" class="center" align="center">
                    <button id="billsavebutton" name="register" class="btn btn-success" type="submit">Save Bill</button>
                    </form>
                    <button id="resetbutton" name="clear" class="btn btn-info" onClick="history.go(0)">Clear</button>

                </div>
            </div>



        </div>
        <div id="alert">
        </div>
    </div>
</div>
</div>
<!-- CONTENT-WRAPPER SECTION END-->
<?php $this->load->view('includes/footer'); ?>
<!-- FOOTER SECTION END-->
<!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
<!-- CORE JQUERY  -->

</body>
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        var serviceprice;
        $("#service_panel").hide();
        $("#billdetails_panel").hide();
        $("#billsavebutton").hide();
        $("#resetbutton").hide();
        //Function to change patient details
        $("#labno").change(function () {
            $('#name').empty();
            $('#age').empty();
            $('#phone').empty();
            var labno = $("#labno").val();
            $.ajax({
                url: "<?php echo base_url().'bill/patient_details';?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: labno
                },
                success: function (response) {
                    if (response['name'] == '') {
                        Lobibox.alert("warning",
                            {
                                width: 300,
                                msg: "Patient Not Found"
                            });

                    }
                    else {

                        $("#service_panel").show();
                        $("#billdetails_panel").show();
                        $('#name').append(response['name']);
                        $('#age').append(response['age']);
                        $('#phone').append(response['phone_no']);
                        $("#billsavebutton").show();
                        $("#resetbutton").show();

                        $("#patientpanel").focus();
                    }
                },
                error: function () {
                    Lobibox.alert("warning",
                        {
                            width: 300,
                            msg: "Patient Not Found"
                        });
                    $("#labno").val('');
                    $("#service_panel").hide();
                    $("#billdetails_panel").hide();
                }// End of success function of ajax form
            }); // End of ajax call
        });
        //Function to display price when a service is selected
        $("#service").change(function () {
            var name = $('#service').val();
            if (name == 'select') {
                $('#price').val('');
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'bill/service_details';?>",
                    datatype: "json",
                    data: {
                        name: name
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.check === true) {
                            $('#qnty').val('1');
                            serviceprice = data.price
                            $('#price').val(serviceprice);
                        }
                        else {
                            $('#qnty').val('1');
                            $('#price').val('');
                            Lobibox.notify("info",
                                {
                                    msg: "The selected panel doesn't have any mappings"
                                });

                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        Lobibox.alert("error",
                            {
                                msg: errorThrown
                            });

                    }

                });
            }
        });

        $('#qnty').change(function () {
            var qnty = $('#qnty').val();
            if (qnty < 0) {

                Lobibox.notify("warning",
                    {
                        msg: "You can't have -ve quantity"
                    });
                $('#qnty').val('0');
                $('#price').val('0');
            }

            else {
                var newprice = qnty * serviceprice;
                $('#price').val(newprice);
            }
        });

        $("#discnt").change(function () {
            var billamt = $("#billamt").val();
            var discnt = $("#discnt").val();
            if (discnt < 0) {
                Lobibox.notify("warning",
                    {
                        msg: "Discount percentage can't be a -ve number"
                    });
                $("#discnt").val('0');
            }
            else {


                var totalamt = billamt - (billamt * discnt) / 100;
                $("#totalamt").val(totalamt);
            }
        });

        $("#billsubmit").submit(function (e) {
            e.preventDefault();
            $("#patientpanel").focus();


            var service = [];
            var qnty = [];
            var price = [];

            var servicecount = 0;
            $.each($('.tableservice'), function () {

                service.push($(this).text());
                servicecount++;
            });

            $.each($('.tableqnty'), function () {

                qnty.push($(this).text());

            });
            $.each($('.tableprice'), function () {

                price.push($(this).text());

            });
            var patientid = $("#labno").val();
            var billamount = $("#billamt").val();
            var discpercentage = $("#discnt").val();
            var totalamount = $("#totalamt").val();
            var paidamount = $("#paidamt").val();
            service = JSON.stringify(service);
            price = JSON.stringify(price);
            qnty = JSON.stringify(qnty);


            if ((paidamount > totalamount) || (paidamount < 0)) {
                Lobibox.notify("warning",
                    {
                        msg: "Paid amount can't be greater than total amount"
                    });
            }
            else if (servicecount == 0) {
                Lobibox.notify("warning",
                    {
                        msg: "You need to add atleast one service to save a bill"
                    });

            }
            else {


                if (confirm("You can't modify a bill once it is saved.Are You sure?")) {


                    $.ajax({

                        type: "POST",
                        url: "<?php echo base_url().'bill/add_bill';?>",

                        data: {
                            patientid: patientid,
                            billamt: billamount,
                            disc: discpercentage,
                            totalamt: totalamount,
                            paidamt: paidamount,
                            servicecount: servicecount,
                            servicearray: service,
                            qntyarray: qnty,
                            pricearray: price
                        },
                        datatype: "json",
                        success: function (response) {
                            var response = JSON.parse(response);
                            if (response.status = true) {
                                Lobibox.notify("success",
                                    {
                                        msg: "Bill is created.Bill No is : " + response.billno
                                    });
                                $("#billsavebutton").hide();
                                $('.form-control').prop("disabled", true);
                                $('#button').append('<a class="btn btn-info" role="button" href="<?php echo base_url().'bill_printout/view/'?>' + response.billid + '" target="_blank">Print Bill </a> ');


                            }
                            else {
                                var alert = " <strong>Oops!</strong> Something went wrong ";
                                $("#alert").addClass('alert alert-success');
                                $("#alert").append(alert);
                            }

                        }

                    });
                }

            }


        });
    });


</script>
<script>
    var i = 1;
    $(".addmore").on('click', function () {
        var service = $('#service').val();
        var qnty = $('#qnty').val();
        var price = $('#price').val();
        if (price == '') {
            Lobibox.notify("info",
                {
                    msg: "Select a valid service"
                });

        }
        else {


            if (i > 10) {
                Lobibox.notify("info",
                    {
                        msg: "You can't addmore than 10 items"
                    });
            }
            else {
                var data = "<tr class=''><td><input type='checkbox' class='checkbox case' style='width:50px;'/>";
                data += "<td class='tableservice'>" + service + "</td><td class='tableqnty'>" + qnty + "</td><td class='tableprice'>" + price + "</td></tr>";
                $('#bill').append(data);
                i++;
                calcuatetotal();
            }

        }
    });

    $(".delete").on('click', function () {
        $('.case:checkbox:checked').parents("tr").remove();
        i--;
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
        $('#billamt').val(total);
        var discnt = $("#discnt").val();
        var disamt = (total * discnt) / 100;
        var totalamt = total - disamt;
        $('#totalamt').val(totalamt);
    }


</script>
<script>

</script>


</html>
