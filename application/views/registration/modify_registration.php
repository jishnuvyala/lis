<!DOCTYPE html>

<head>
<?php $this->load->view('includes/css');?>
<?php $this->load->view('includes/js');?>

</head>
<body>
<script>
    /*Ajax POSTING */
    $(document).ready(function()
    {
        $('[data-toggle="tooltip"]').tooltip();
        $("#labno").change(function(){

           var id=$("#labno").val();
           $.ajax({
               type:"post",
               url:"<?php echo base_url().'modify_registration/get_data'?>",
               datatype:"json",
               data:{
                   id:id
               },
               success:function(response) {
                   var response = JSON.parse(response);
                   if (response.status===true) {
                       $("#gender").find("option[value=" + response.gender_id + "]").attr("selected", true);
                       $("#state").find("option[value=" + response.sate_id + "]").attr("selected", true);
                       $("#district").find("option[value=" + response.district_id + "]").attr("selected", true);
                       $("#fname").val(response.first_name);
                       $("#lname").val(response.last_name);
                       $("#age").val(response.age);
                       $("#addr").val(response.address);
                       $("#number").val(response.phone_no);
                       $("#email").val(response.email);
                   }
                   else {
                       Lobibox.alert("warning",
                           {   width : 300,
                               msg: "Patient Not Found"
                           });
                       $(".input-md").val('');
                   }
               }

           });

       });
        //oN SUBMIT
        $("#register").submit(function(e)
        {
            e.preventDefault();
            //COLLECTING FORM DATA
            var datastring=$("#register").serialize();
            //AJAX CALL
            $.ajax({
                type:"POST",
                url:"<?php echo base_url().'modify_registration/update'?>",
                data:datastring,
                datatype:"json",
                success: function(response) {
                  //IFINSERTION IS DONE
                    var response= JSON.parse(response);
                    if(response.status===true)
                    {

                        //CREATING URLS FOR BUTTONS

                        $('.form-control').prop("disabled", true);
                        $('.input-md').prop("disabled", true);

                        //Hiding registration button
                        $("#registerbutton").hide();
                        //Showing new buttons

                        //Showing sucess alert
                        Lobibox.notify("success",
                            {
                                msg: "Details are updated Sucessfully"
                            });


                    }
                    else
                    {
                        //If inserting data failed showing error alert
                        Lobibox.notify("error",
                            {
                                msg: "Oops Something went Wrong !"
                            });

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    Lobibox.alert("error",
                        {   width : 300,
                            msg: errorThrown
                        });

                }


            });
        });



    });
</script>

<script type="text/javascript">
    //Java script to open barcode and Card as a popup

    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url,'popUpWindow','height=200,width=400,left=500,top=200,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }

    function newPopup_barcode(url) {
        popupWindow = window.open(
            url,'popUpWindow','height=50,width=30,left=500,top=200,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }
    <!-- start: Header -->
</script>
<?php $this->load->view('includes/logo'); ?>
    <!-- LOGO HEADER END-->
<?php $this->load->view('includes/menu'); ?>
     <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div  class="container">
             <div class="row pad-botm">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-info">
                         <div class="panel-heading">
                             Modify Registration
                         </div>


                         <div class="panel-body">
                             <div id="alert" tabindex='1' >

                             </div>
                             <form id="register" class="form-horizontal">
                                 <fieldset>
                                     <input id="labno" name="labno" type="number" placeholder="Lab No" class="input-sm input-md" data-toggle="tooltip" data-placement="top" title="Enter Lab No and Tab Out" required>
                                     <!-- Form Name -->
                                     <legend></legend>
                                     <div class="">&nbsp;</div>
                                     <!-- Select Basic -->
                                     <div class="form-group">
                                         <label class="col-md-2 control-label" for="textinput">First Name</label>
                                         <div class="col-md-3">
                                             <input id="fname" name="fname" type="text" placeholder="First Name" class="form-control input-md textinput" required>
                                         </div>
                                         <label class="col-md-2 control-label" for="textinput">Last Name</label>
                                         <div class="col-md-3">

                                             <input id="lname" name="lname" type="text" placeholder="Last Name" name="lname" class="form-control input-md textinput" required>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="col-md-2 control-label" for="selectbasic">Gender</label>
                                         <div class="col-md-3" >
                                             <select id="gender" name="gender" class="form-control" required>
                                                 <?php foreach($gender as $row)
                                                 { ?>
                                                 <option value="<?php echo $row->id;?>"><?php echo $row->gender; ?></option>
                                                 <?php }?>
                                             </select>
                                         </div>
                                         <label class="col-md-2 control-label" for="textinput">Age</label>
                                         <div class="col-md-3">
                                             <input id="age" name="age" type="text" placeholder="Age" class="form-control input-md " required>
                                         </div>
                                     </div>


                                        <div class="form-group">
                                         <label class="col-md-2 control-label" for="selectbasic">State</label>
                                         <div class="col-md-3">
                                             <select id="state" name="state" class="form-control" >

                                                     <?php foreach($district as $row)
                                                     { ?>
                                                         <option value="<?php echo $row->state_id;?>"><?php echo $row->state; ?></option>
                                                     <?php }?>
                                             </select>
                                         </div>
                                         <label class="col-md-2 control-label" for="selectbasic">District</label>
                                         <div class="col-md-3">
                                             <select id="district" name="district" class="form-control" >
                                                 <?php foreach($district as $row)
                                                 { ?>
                                                     <option value="<?php echo $row->district_id;?>"><?php echo $row->district; ?></option>
                                                 <?php }?>
                                             </select>
                                         </div>
                                     </div>

                                     <!-- Textarea -->
                                     <div class="form-group">
                                         <label class="col-md-2 control-label" for="textarea">Address</label>
                                         <div class="col-md-9">
                                             <textarea class="form-control input-md" id="addr" name="addr"></textarea>
                                         </div>
                                     </div>

                                     <!-- Button (Double) -->
                                     <div class="form-group">
                                         <label class="col-md-2 control-label" for="textinput">Mobile Number</label>
                                         <div class="col-md-3">
                                             <input id="number" name="number" type="number" placeholder="Mobile Number" class="form-control input-md textinput" required>
                                         </div>
                                         <label class="col-md-2 control-label" for="textinput">Email Id</label>
                                         <div class="col-md-3">
                                             <input id="email" name="email" type="email" placeholder="Email" name="email" class="form-control input-md textinput">
                                         </div>

                                     </div>
                                     <div class="form-group">
                                         <label class="col-md-2 control-label" for="button1id"></label>
                                         <div id ='button' class="col-md-8">
                                             <button id="registerbutton" name="register" class="btn btn-success" type="submit">Save</button>
                                             <button id="resetbutton" name="clear" class="btn btn-danger" onClick="history.go(0)">Clear</button>

                                         </div>
                                     </div>

                                 </fieldset>
                             </form>



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

</body>

</html>
