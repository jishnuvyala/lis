<html>
<head>
    <?php $this->load->view('includes/css');?>
<body>
<div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Add Panel services</div>
        <div class="panel-body">
            <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="add_role" ><div style="display:none">
                </div>


                <div class="form-group email required user_basic_email">

                    <label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>User Name</label>
                    <input type="text" class="form-group email required form-control" id="username" name="username">
                    <p class="help-block">Enter Username and Tab Out</p></div>
                <input class="hidden" id='id' name="id">
                <div class="form-group email required "><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Roles</label>
                    <select class="form-control" id="role" name="role">
                        <option value="1">Billing</option>
                        <option value="2">Lab</option>
                        <option value="3">Lab Manager</option>
                        <option value="4">Master</option>
                        <option value="5">Admin</option>
                    </select>
                    <p class="help-block">Enter Username and Tab Out</p></div>

                <div class="form-group center" align="center">
                <input class="btn btn-primary" name="commit" type="submit"  id= 'add' value="Map Role" />
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

        $("#add").hide();

        $("#username").change(function(){

            var username=$("#username").val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'user_role_master/get_details'?>",
                data: {
                    user:username
                },
                datatype: "json",
                success: function (response) {
                    var data= JSON.parse(response);

                    if (data.status===true) {
                        $("#add").show();
                        $('#username').prop("disabled", true);
                        $('#id').val(data.id);

                    }
                    else {
                        Lobibox.notify("warning",
                            {
                                msg: "User Not Found"
                            });
                    }
                }






            });


        });

            $("#add_role").submit(function (e) {
                e.preventDefault();

                var datastring = $("#add_role").serialize();

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().'user_role_master/add'?>",
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
                                            msg: "New role is mapped"
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
                                        msg: "Selected Role is already mapped"
                                    });
                            }

                        }

                    });



            });
        });
    </script>
</head>

</html>