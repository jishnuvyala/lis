<html>
<head>
    <?php $this->load->view('includes/css');?>
<body>

<div class="col-md-6">
    <?php foreach($orderdetails as $row)
    {
        $order_id=$row->order_id;
    }?>
    <div class="panel panel-primary">
        <div class="panel-heading">Create Report</div>
        <div class="panel-body">
            <form method="post" action="" id="upload_file" enctype="multipart/form-data">
                 <div class="form-control form-group"><input type="file" class="input" name="userfile" id="userfile" size="20" required accept="application/pdf"/></div>
                <p class="help-block">Only PDF  files are allowed</p></div>

                <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="add_specimen" >
                    <input type="hidden" name="orderid" id="orderid" value='<?php echo $order_id;?>' >

                    <div class="form-group center" align="center"><input type="submit" name="submit" id="submit"  value="Upload"  class=" btn btn-sm btn-primary" />
                        <select id="template" class="input-sm">
                            <?php foreach($templates as $row)
                            { ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                            <?php } ?>
                        </select>
                        <a class="btn btn-sm btn-primary" name="download" id="download"">Download Template<a/></div>

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
        $('#upload_file').submit(function(e) {
            e.preventDefault();
            var data = new FormData($('#upload_file')[0]);
            var orderid=$('#orderid').val();
            if(confirm("Are You sure?.This will update the status are Rectified"))
            {


                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url().'report/ammend_upload_file';?>",
                            data: data,
                            mimeType: "multipart/form-data",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data.status === true) {
                                    var filename = data.file_name;
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url().'report/ammend_update_status';?>",
                                        datatype: "json",
                                        data: {
                                            filename: filename, orderid: orderid
                                        },
                                        success: function (response) {
                                            var data = JSON.parse(response);
                                            if (data.status === true) {

                                                Lobibox.notify("success",
                                                    {
                                                        msg: "Report is uploaded and status changed to Rectified"
                                                    });
                                                $("#submit").hide();
                                                $("#userfile").hide();
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
                                            msg: "Uploading failed.Are you sure that it was pdf file?"
                                        });
                                }

                            }
                        });
                    }

        });

          $("#download").click(function(){
              var orderid=$('#orderid').val();
              var templateid=$('#template').val();
              alert(orderid);
              alert(templateid);
              window.location.href = "<?php echo base_url().'report/template/';?>"+templateid+"/"+orderid;


              });



        });
    </script>
</head>

</html>