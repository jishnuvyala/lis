<html>
<head>
    <?php $this->load->view('includes/css');?>
<body>
<div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Modify category details</div>
        <div class="panel-body">
            <?php foreach($category as $row)
            {?>
            <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="add_specimen" ><div style="display:none">
                </div>


                <div class="form-group email required user_basic_email"><label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr> category Name</label><input class="string email required form-control" id="user_basic_email" name="category_name" placeholder="Enter specimen name" type="text" value="<?php echo $row->name; ?>"required/>
                    <p class="help-block">category name must be unique</p></div>


                <div class="form-group boolean optional user_basic_active">

                        <label class="boolean optional" for="user_basic_active">
                            <input type="checkbox" name= 'active' value="1" <?php if($row->active_yesno==1){ echo "checked";} ?>>Active</label></div>
                    <p class="help-block">Only active specimen can be used</p></div>
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

            $("#add_specimen").submit(function (e) {
                e.preventDefault();

                var datastring = $("#add_specimen").serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'category_master/update'?>",
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
                                        msg: "Conatiner is modified"
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
                                    msg: "Name already given for another category"
                                });
                        }

                    }

                });

            });
        });
    </script>
</head>

</html>