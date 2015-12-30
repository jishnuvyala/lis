<html>
<head>
    <?php $this->load->view('includes/css');?>
<body>
<div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Add New user</div>
        <div class="panel-body">
            <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="add_user" ><div style="display:none">
                </div>


                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>User Name</label><input class="string email required form-control" id="username" name="username" placeholder="Enter user name" type="text" required/>
                    <p class="help-block">user name must be unique</p></div>
                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Name</label><input class="string email required form-control" id="name" name="name" placeholder="Enter name" type="text" required/>
                    <p class="help-block">Name as displayed in the application</p></div>
                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>User Description</label><input class="string email required form-control" id="user_desc" name="user_desc" placeholder="Enter user name" type="text" required/>
                    <p class="help-block">User Description</p></div>
                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Password</label><input class="string email required form-control" id="passwd1" name="passwd1" placeholder="Enter Password" type="password" required/>
                    <p class="help-block">Password</p></div>
                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Confirm Password</label><input class="string email required form-control" id="passwd2" name="passwd2" placeholder="Confirm Password" type="password" required/>
                    <p class="help-block">Confirm Password</p></div>


                <div class="form-group boolean optional user_basic_active">

                        <label class="boolean optional" for="user_basic_active">
                            <input type="checkbox" name= 'active' value="1" checked>Active</label></div>
                    <p class="help-block">Only Active user can be used</p></div>

                <div class="form-group center" align="center">
                <input class="btn btn-primary" name="commit" type="submit" value="Add user" />
                </div>
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
                var passwd1=$("#passwd1").val();
                var passwd2=$("#passwd2").val();
                if(passwd1==passwd2)
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().'user_master/add'?>",
                        data: datastring,
                        datatype: "json",
                        success: function (response) {
                            var response=JSON.parse(response);
                            if(response.check==false)
                            {
                                if(response.status===true)
                                {
                                    Lobibox.notify("success",
                                        {
                                            msg: "New user is added"
                                        });
                                }
                                else
                                {
                                    Lobibox.notify("danger",
                                        {
                                            msg: "something went wrong"
                                        });
                                }


                            }
                            else
                            {
                                Lobibox.notify("warning",
                                    {
                                        msg: "User Name already Exist"
                                    });
                            }

                        }

                    });

                }
                else
                {
                    Lobibox.notify("warning",
                        {
                            msg: "Password doesn't match"
                        });
                }


            });
        });
    </script>
</head>

</html>