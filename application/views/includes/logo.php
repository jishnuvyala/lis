<div>
    <div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url().'dashboard'?>">

                    <img src="<?php base_url();?>assets/img/logo1.png" />
                </a>


            </div>
            <?php
            $user=$this->session->userdata('logged_in');
            ?>
            <div class="center-block col-md-6 text-center"><label class="label label-warning">Currently logged in as : <?php echo $user['username']; ?> Welcome : <?php echo $user['name']; ?></label></div>

            <div class="right-div  btn-group">

                <a href="<?php echo base_url().'login/logout'?>" class=" btn btn-xs btn-primary pull-right ">LOG OUT</a>

            </div>

            </div>
        </div>
    </div>