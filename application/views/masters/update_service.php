<html>
<head>
    <?php $this->load->view('includes/css');?>
<body>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading">Add New Service</div>
        <div class="panel-body">
            <form id="save" class="form-horizontal">
                <fieldset>
                    <?php
                    foreach($service as $row)
                    {
                        $service=$row->name;
                        $ct_id=$row->category_id;
                        $sp_id=$row->specimen_id;
                        $un_id=$row->unit_id;
                        $cn_id=$row->container_id;
                        $price=$row->price;
                        $panel_yesno=$row->panel_yesno;
                        $active_yesno=$row->active_yesno;
                        $result_type=$row->result_type;
                        $fromrange=$row->from_range;
                        $torange=$row->to_range;
                        $alphanormal=$row->alpha_normal;
                        $id=$row->service_id;

                    }

                    ?>
                    <div class="form-group required">
                        <label class="col-md-2 control-label" for="textinput">Service Name</label>

                        <div class="col-md-9 ">
                            <input id="name" name="name" type="text" placeholder="Service Name"
                                   class="form-control input-md" value="<?php echo $service;?>" required>
                        </div>

                    </div>
                    <div class="form-group required">
                        <label class="col-md-2 control-label" for="selectbasic">Category</label>

                        <div class="col-md-3">
                            <select id="gender" name="category" class="form-control" required>
                                <?php foreach ($category as $row) { ?>
                                    <option value="<?php echo $row->id; ?>" <?php if($row->id==$ct_id){ echo "selected";}?>><?php echo $row->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label class="col-md-2 control-label" for="textinput">Panel</label>

                        <div class="col-md-2">
                           <label class="label"> <input type="<?php if($panel_yesno==1){ echo "hidden";} else {echo "checkbox";}?>" id="panel" class="checkbox panel"  name='panel' value="1" <?php if($panel_yesno==1){ echo "checked";}?>></label>
                        </div>
                        <label class="col-md-1 control-label" for="textinput">Active</label>

                        <div class="col-md-2">
                            <label class="label"> <input type="checkbox" id="active" class="checkbox"  name='active' value="1" <?php if($active_yesno==1){ echo "checked";}?> ></label>
                        </div>
                    </div>


                    <div class="form-group required">
                        <label class="col-md-2 control-label" for="selectbasic">Price</label>

                        <div class="col-md-3">
                            <input id="price" name="price" type="number" placeholder="Base price"
                                   class="form-control input-md" value="<?php echo $price;?>"required>
                        </div>
                        <?php if($panel_yesno!=1){?>
                        <label class="col-md-2 control-label panel-hide-update" for="selectbasic">Specimen</label>

                        <div class="col-md-3">
                            <select id="specimen" name="specimen" class="form-control panel-hide-update">
                                <?php foreach ($specimen as $row) { ?>
                                    <option
                                        value="<?php echo $row->id; ?>" <?php if($row->id==$sp_id){ echo "selected";}?>><?php echo $row->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group required">
                        <label class="col-md-2 control-label panel-hide-update" for="selectbasic">Container</label>

                        <div class="col-md-3">
                            <select id="container" name="container" class="form-control panel-hide-update">
                                <?php foreach ($container as $row) { ?>
                                    <option
                                        value="<?php echo $row->id; ?>" <?php if($row->id==$cn_id){ echo "selected";}?>><?php echo $row->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label class="col-md-2 control-label panel-hide-update" for="selectbasic">Result Type</label>

                        <div class="col-md-3">
                            <select id="result_type" name="result_type" class="form-control panel-hide-update result_type">
                                <option value="N" <?php if($result_type=='N'){ echo "selected";}?>>Numeric</option>
                                <option value="A" <?php if($result_type=='A'){ echo "selected";}?>>Alpha Numeric</option>
                                <option value="R" <?php if($result_type=='R'){ echo "selected";}?>>Report</option>
                            </select>
                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-2 control-label mandatory panel-hide-update" for="textinput" id="range_frm_label">Normal Range From
                           </label>

                        <div class="col-md-3 ">
                            <input id="range_frm" name="range_frm" type="number" placeholder=""
                                   class="form-control input-md panel-hide-update" value="<?php echo $fromrange;?>" >
                        </div>
                        <label class="col-md-2 control-label panel-hide-update" for="textinput" id="range_to_label">Normal Range To</label>

                        <div class="col-md-3">
                            <input id="range_to" name="range_to" type="number" placeholder=""
                                   class="form-control input-md panel-hide-update" value="<?php echo $torange;?>">
                        </div>


                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label mandatory panel-hide-update" for="textinput" id="alpha_normal_label">Alpha Normal
                        </label>

                        <div class="col-md-3 ">
                            <input id="alpha_normal" name="alpha_normal" type="text" placeholder="Normal Result"
                                   class="form-control input-md panel-hide-update" value="<?php echo $alphanormal;?>">
                        </div>
                        <label id="unit_label" class="col-md-2 control-label panel-hide-update" for="textinput">Result Unit</label>

                        <div class="col-md-3">
                            <select id="unit" name="unit" class="form-control panel-hide-update">
                                <?php foreach ($unit as $row) { ?>
                                    <option
                                        value="<?php echo $row->id; ?>" <?php if($row->id==$un_id){ echo "selected";}?>><?php echo $row->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php }?>
                        </div>
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

                        <div id='button' align="center">
                            <button id="save" name="save" class="btn btn-primary"
                                    type="submit">Save</button>


                    </div>

                </fieldset>
            </form>

        </div>
</div>

</div>
<?php $this->load->view('includes/js');?>
</body>
<script>
    $(document).ready(function() {

        var result_type=$(".result_type").val();
        if(result_type=='A')
        {
            $("#range_frm").hide();
            $("#range_to").hide();
            $("#unit").hide();
            $("#range_frm_label").hide();
            $("#range_to_label").hide();
            $("#unit_label").hide();
            $("#alpha_normal").show();
            $("#alpha_normal_label").show();
        }
        else if(result_type=='R')
        {
            $("#range_frm").hide();
            $("#range_to").hide();
            $("#unit").hide();
            $("#alpha_normal").hide();
            $("#range_frm_label").hide();
            $("#range_to_label").hide();
            $("#unit_label").hide();
            $("#alpha_normal_label").hide();
        }
        else
        {
            $("#range_frm").show();
            $("#range_to").show();
            $("#unit").show();
            $("#range_frm_label").show();
            $("#range_to_label").show();
            $("#unit_label").show();
            $("#alpha_normal_label").show();
        }


        $("#result_type").change(function()
        {
            var result_type =$("#result_type").val();
            if(result_type=='A')
            {
                $("#range_frm").hide();
                $("#range_to").hide();
                $("#unit").hide();
                $("#range_frm_label").hide();
                $("#range_to_label").hide();
                $("#unit_label").hide();
                $("#alpha_normal").show();
                $("#alpha_normal_label").show();
            }
            else if(result_type=='R')
            {
                $("#range_frm").hide();
                $("#range_to").hide();
                $("#unit").hide();
                $("#alpha_normal").hide();
                $("#range_frm_label").hide();
                $("#range_to_label").hide();
                $("#unit_label").hide();
                $("#alpha_normal_label").hide();
            }
            else
            {
                $("#range_frm").show();
                $("#range_to").show();
                $("#unit").show();
                $("#range_frm_label").show();
                $("#range_to_label").show();
                $("#unit_label").show();
                $("#alpha_normal_label").show();
            }

        });

        $("#save").submit(function(e) {
            e.preventDefault();
            var result=$("#result_type").val();
            var range_to=$("#range_to").val();
            var range_frm=$("#range_frm").val();
            var alpha_normal=$("#alpha_normal").val();
            var panel=$("#panel").val();
            var datastring=$("#save").serialize();

            var check=0;
            if(!$("#panel").prop('checked'))
            {


            if(result=='N')
            {
                if(range_to=='' || range_frm=='' )
                {
                    Lobibox.notify("warning",
                        {
                            msg: "Please fill the normal result ranges"
                        });
                    check =1;
                }
            }
            if(result=='A')
            {
                if(alpha_normal=='')
                {
                    Lobibox.notify("warning",
                        {
                            msg: "Please fill the alpha normal result"
                        });
                    check=1;
                }
            }
            }

            if(check==0)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'service_master/update'?>",
                    data: datastring,
                    datatype: "json",
                    success: function (response) {
                        //IFINSERTION IS DONE
                        var response = JSON.parse(response);
                        if(response.check==false) {
                            if (response.status === true) {
                                Lobibox.notify("success",
                                    {
                                        msg: "Service details are modified"
                                    });
                            }
                            else {
                                Lobibox.notify("danger",
                                    {
                                        msg: "Oops! Something went wrong"
                                    });
                            }
                        }

                        else {
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
            }




        });
    });
    </script>
</head>

</html>