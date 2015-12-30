<html>
<head>
    <?php $this->load->view('includes/css');?>
<body>
<div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Modify user details</div>
        <div class="panel-body">
            <?php foreach($user as $row)
            {?>
            <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="add_user" ><div style="display:none">
                </div>
                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email">
                        <abbr title="required">*</abbr>User Name</label>
                    <input class="string email required form-control" id="username" name="username" placeholder="Enter user name" type="text" value="<?php echo $row->username; ?>" disabled required/>

                    <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Password</label><input class="string email required form-control" id="passwd1" name="passwd1" placeholder="Enter Password" type="password" required/>
                        <p class="help-block">Password</p></div>
                    <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Confirm Password</label><input class="string email required form-control" id="passwd2" name="passwd2" placeholder="Confirm Password" type="password" required/>
                        <p class="help-block">Confirm Password</p></div>



                   <input type="hidden" name="id" value="<?php echo $row->id; ?>">

                <div class="form-group center" align="center">
                <input class="btn btn-primary" name="commit" type="submit" value="Modify" />
                </div>
        <?php }?>
            </form>
        </div>
    </div>
</div>

</div>
<?php $this->load->view('includes/js');?>
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
                        url: "<?php echo base_url().'user_master/password_update'?>",
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
</head>

</html>