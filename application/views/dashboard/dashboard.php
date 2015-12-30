<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $this->load->view('includes/css');?>
    <style>

        blockquote {
            background: #f9f9f9;
            border-left: 10px solid #ccc;
            margin: 1.5em 10px;
            padding: 0.5em 10px;
            quotes: "\201C""\201D""\2018""\2019";
        }
        blockquote:before {
            color: #ccc;
            content: open-quote;
            font-size: 4em;
            line-height: 0.1em;
            margin-right: 0.25em;
            vertical-align: -0.4em;
        }
        blockquote p {
            display: inline;
        }
    </style>
</head>
<body>
    <?php $this->load->view('includes/logo'); ?>
    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu'); ?>
     <!-- MENU SECTION END-->
    <div class="content-wrapper ">
         <div class="container">
        <div class="row pad-botm">
            <?php
            foreach($totalcoll as $row)
            {
                $total=$row->total;
            }
            foreach($totalrefund as $row)
            {
                $totalrefund=$row->refund;
            }
            $total_collection=$total - $totalrefund;
            ?>
            <div class="col-md-12">
                <h4 class="header-line">Today's Qoute</h4>


                        <?php foreach($qoutes as $row)
                        {?>
                            <blockquote > <?php echo $row->qoute; ?></blockquote>
                        <?php }?>

                <?php
                $role=$this->session->userdata('role');
                if(($role['billing']))
                {
                ?>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bell fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $total_collection; ?> Rs</div>
                                    <div>Total Collection!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bell fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totalrefund; ?> Rs</div>
                                    <div>Total refunds!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-info fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totalcancel; ?> Services</div>
                                    <div>Pending for refund!</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url().'cancel_browser'; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bell fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $totalreg; ?></div>
                                    <div>Registrations!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php }
                if(($role['labuser']) || $role['labmanager'] )
                {


                ?>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-info fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $pendingcoll;?> Pending</div>
                                    <div>Sample Collection !</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url().'sample_collection'; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-info fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $pendingentry;?>  Pending</div>
                                    <div>Result Entry!</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url().'result_processing'; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-info fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $pendingcertify;?>  Pending</div>
                                    <div>Result Certification!</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url().'result_processing'; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2">
                    <div class="panel panel-danger ">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-info fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $pendingreports;?> Pending </div>
                                    <div>Report Entry!</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url().'result_processing'; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
<?php } ?>

            </div>

        </div>
             
             <div class="row">

             </div>
         </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
   <?php $this->load->view('includes/footer');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
  <?php  $this->load->view('includes/js'); ?>
  
</body>
</html>
