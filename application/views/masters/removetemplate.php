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
                    <h6 class="header-line">Inactive Templates</h6>

                </div>

            </div>


                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="panel panel-primary" style="align: center">
                            <div class="panel-heading">Inactivate Templates</div>
                            <div class="panel-body">
                                <form accept-charset="UTF-8"  class="simple_form new_user_basic"  id="upload_file" ><div style="display:none">
                                    </div>
                                    <div class="form-group email required user_basic_email">
                                        <div class="form-group email required user_basic_email">
                                            <label class="email required control-label" for="user_basic_email"><abbr title="required">*</abbr>choose template</label>
                                             <select id="template" name="template">
                                                 <?php foreach($template as $row)
                                                        { ?>
                                                  <option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>

                                             <?php } ?>

                                             </select>
                                        <div class="form-group center" align="center">
                                            <input class="btn btn-primary" name="commit" type="submit" value="delete" />
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
        $('#upload_file').submit(function (e) {
            e.preventDefault();
            var id=$("#template").val();
            $.ajax({
                url:"<?php echo base_url().'template_master/remove'?>",
                data:{
                    id:id
                },
                datatype:"json",
                type:"post",
                success:function(response)
                {
                    var data=JSON.parse(response);
                    if(data.status===true)
                    {
                        Lobibox.notify("success",
                            {
                                msg: "Status is updated"
                            });
                    }
                    else{
                        Lobibox.notify("warning",
                            {
                                msg: "Oops something went wrong"
                            });
                    }
                }


            });
        });


    });


</script>
</html>
