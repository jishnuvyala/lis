<!DOCTYPE html>
<style type="text/css">
    .table-border {
    }
</style>
<head>
    <?php $this->load->view('includes/css');?>
    <?php $this->load->view('includes/js');?>
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
            url, 'popUpWindow', 'height=400,width=500,left=500,top=200,resizable=0,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }
    </script>

<?php $this->load->view('includes/logo');?>
    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container center-block" align="center">
            <div class="row pad-botm row-centered">
                <div class="col-lg-6 col-lg-offset-3 text-center">
                    <h6 class="header-line">Change Password</h6>

                </div>

            </div>


                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="panel panel-primary" style="align: center">
                            <div class="panel-heading">Modify user details</div>
                            <div class="panel-body">
                               <?php $user=$this->session->userdata('logged_in');?>
                                <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="add_user" ><div style="display:none">
                                    </div>
                                    <div class="form-group email required user_basic_email">
                                        <input class="string email required form-control" id="username" name="username" placeholder="Enter user name" type="hidden" value="<?php echo $user['username']; ?>" disabled required/>

                                        <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Password</label><input class="string email required form-control" id="passwd1" name="passwd1" placeholder="Enter Password" type="password" required/>
                                            <p class="help-block">Password</p></div>
                                        <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Confirm Password</label><input class="string email required form-control" id="passwd2" name="passwd2" placeholder="Confirm Password" type="password" required/>
                                            <p class="help-block">Confirm Password</p></div>
                                           <input type="hidden" name="userid" id="userid" value="<?php echo $user['id'];?>">
                                        <div class="form-group center" align="center">
                                            <input class="btn btn-primary" name="commit" type="submit" value="Modify" />
                                        </div>

                                </form>
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

</body>
<script>

    $(document).ready(function() {

        $("#add_user").submit(function (e) {
            e.preventDefault();

            var datastring = $("#add_user").serialize();
            var passwd1 = $("#passwd1").val();
            var passwd2 = $("#passwd2").val();
            if (passwd1 == passwd2) {

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'change_password/password_update_user'?>",
                    data: datastring,
                    datatype: "json",
                    success: function (response) {
                        var response = JSON.parse(response);

                        if (response.status === true) {
                            Lobibox.notify("success",
                                {
                                    msg: "password is modified"
                                });
                        }
                        else {
                            Lobibox.notify("danger",
                                {
                                    msg: "something went wrong"
                                });
                        }
                    }

                });
            }
            else {
                Lobibox.notify("warning",
                    {
                        msg: "Password Doesn't Match"
                    });
            }
        });
    });


</script>
</html>
