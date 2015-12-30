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

                    <label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Panel</label>
                    <select class="input-sm" id="panel" name="panel">
                        <?php foreach($panel as $row)
                        {?>
                            <option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>

                        <?php } ?>

                    </select>
                    <p class="help-block">Select the panel service</p></div>
                <input class="hidden" id='id' name="id">
                <div class="form-group email required "><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>Service</label>
                    <select class="input-sm" id="service" name="service">
                        <?php foreach($service as $row)
                        {?>
                            <option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>

                        <?php } ?>

                    </select>
                    <p class="help-block">Select service for mapping</p></div>

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



            $("#add_role").submit(function (e) {
                e.preventDefault();

                var datastring = $("#add_role").serialize();

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().'panel_service_master/add'?>",
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
                                            msg: "New service is mapped"
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
                                        msg: "Selected service is already mapped with the panel"
                                    });
                            }

                        }

                    });



            });
        });
    </script>
</head>

</html>