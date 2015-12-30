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
                    <input class="string email required form-control" id="username" name="username" placeholder="Enter user name" type="text" value="<?php echo $row->username; ?>" required/>

                    <p class="help-block">user name must be unique</p></div>
                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Name</label><input class="string email required form-control" id="name" name="name" placeholder="Enter name" type="text" value="<?php echo $row->name; ?>" required/>
                    <p class="help-block">Name as displayed in the application</p></div>
                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>User Description</label><input class="string email required form-control" id="user_desc" name="user_desc" placeholder="Enter user name" type="text" value="<?php echo $row->user_desc; ?>" required/>
                    <p class="help-block">User Description</p></div>


                <div class="form-group boolean optional user_basic_active">

                        <label class="boolean optional" for="user_basic_active">
                            <input type="checkbox" name= 'active' value="1" <?php if($row->active_yesno==1){ echo "checked";} ?>>Active</label></div>
                    <p class="help-block">Only active user can be used</p></div>
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
                alert(datastring);

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'user_master/update'?>",
                    datatype: "json",
                    success: function (response) {
                        var response=JSON.parse(response);
                        if(response.check==false)
                        {
                            if(response.status===true)
                            {
                                Lobibox.notify("success",
                                    {
                                        msg: "user is modified"
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
                                    msg: "User Name already given for another user"
                                });
                        }

                    }

                });

            });
        });
    </script>
</head>

</html>