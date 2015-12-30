<section class="menu-section">
    <div class="container-fluid header-bottom">
        <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-kiri navbar-right" id="bottom_menu">
                <li><a href="<?php echo base_url().'dashboard'?>"><i class="fa fa-home"></i> Home</a></li>
                <?php
                $role=$this->session->userdata('role');
                if(($role['billing'])||($role['admin']))
                {
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                        Registration <span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'registration'?>">New Registration</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'modify_registration'?>">Modify Registration</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'patient_browser'?>">Patient Browser</a></li>
                    </ul>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                        Billing <span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'bill'?>">New Bill</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'bill_browser'?>">Bill Browser</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'refund_bill'?>">Refunds</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'refundbill_browser'?>">Refund Browser</a></li>
                    </ul>
                </li>
                <?php }
                if(($role['labuser'])||($role['admin'])||($role['labmanager']))
                {?>

                <li class="dropdown">


                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                       Lab<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'sample_collection'?>">Sample Collection</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'result_processing'?>">Result Processing</a></li>
                        <li class="divider"></li>

                        <li><a href="<?php echo base_url().'result_browser'?>">Result Browser</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'cancel_order'?>">Cancel Orders</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'cancel_browser'?>">Cancel Order Browser</a></li>


                    </ul>

                </li>
                <?php }?>
                <?php  if(($role['master'])||($role['admin']))
                {?>

                <li class="dropdown">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                       Masters<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'service_master'?>">Service Master</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'panel_service_master'?>">Panel Service Map</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'specimen_master'?>">Specimen Master</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'container_master'?>">Container Master</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'unit_master'?>">Result Unit Master</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'category_master'?>">Category Master</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'method_master'?>">Method Master</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'template_master'?>">Template Master</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'remove_template'?>">Remove Template</a></li>
                    </ul>
                </li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                       User Administration<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'user_master'?>">Manage User</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'user_role_master'?>">User Role Map</a></li>


                    </ul>
                </li>
                <?php }
                if(($role['billing'])||($role['admin']))
                   {?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                        Billing Reports<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'bill'?>">Report 1</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Report 2 </a></li>
                        <li class="divider"></li>
                        <li><a href="#">Report 3</a></li>

                    </ul>
                </li>
                <?php }
if(($role['billing'])||($role['admin']))
{?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                       Registration Reports<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'bill'?>">Report 1</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Report 2 </a></li>
                        <li class="divider"></li>
                        <li><a href="#">Report 3</a></li>

                    </ul>
                </li>
                <?php }
if(($role['labuser'])||($role['admin'])||($role['labmanager']))
{ ?>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-arrow-down"></i>
                        Lab Reports<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-top-front" role="menu">
                        <li><a href="<?php echo base_url().'bill'?>">Report 1</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Report 2 </a></li>
                        <li class="divider"></li>
                        <li><a href="#">Report 3</a></li>

                    </ul>
                </li>
                <?php }
                 if(($role['admin']))
                 { ?>
                <?php } ?>
                <li><a href="<?php echo base_url().'change_password'?>"><i class="fa fa-sliders"></i>Change Password</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- container fluid 2 -->
    </div><!-- main header -->
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
        </div><!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">

        </div><!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/'?>js/jquery.min.js"></script>
    <script src="<?php echo base_url().'assets/'?>js/bootstrap.min.js"></script>
</section>