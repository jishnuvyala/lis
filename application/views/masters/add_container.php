<html>
<head>
    <?php $this->load->view('includes/css');?>
<body>
<div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Add New Container</div>
        <div class="panel-body">
            <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="add_container" ><div style="display:none">
                </div>


                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr> Container Name</label><input class="string email required form-control" id="user_basic_email" name="container_name" placeholder="Enter container name" type="text" required/>
                    <p class="help-block">Container name must be unique</p></div>


                <div class="form-group boolean optional user_basic_active">

                        <label class="boolean optional" for="user_basic_active">
                            <input type="checkbox" name= 'active' value="1" checked>Active</label></div>
                    <p class="help-block">Only Active container can be used</p></div>

                <div class="form-group center" align="center">
                <input class="btn btn-primary" name="commit" type="submit" value="Add container" />
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

            $("#add_container").submit(function (e) {
                e.preventDefault();

                var datastring = $("#add_container").serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'container_master/add'?>",
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
                                        msg: "New container is added"
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
                                    msg: "Name already Exist"
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
</head>

</html>