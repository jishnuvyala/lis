<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Login to VLI</title>
        <meta name="description" content="VLI Login Page" />
        <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
        <meta name="author" content="Vyala Technologies" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>loginassets/css/style.css" />
		<script src="js/modernizr.custom.63321.js"></script>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    </head>
    <body background="<?php base_url();?>assets/img/loginbag.jpg">
        <div class="container">
			<header>
				<h1>Login To<strong></strong></h1>
				<h2> <img src="<?php base_url();?>assets/img/logo1.png" /></h2>
			</header>
			<div align="center" style="color: #e13300; font-size:medium;"> <b><?php echo validation_errors(); ?></b></div>
			<section class="main">

				<form class="form-1" method="post" action="<?php echo base_url().'verifylogin'?>">
					<p class="field">
						<input type="text" name="username" placeholder="Username ">
						<i class="icon-user icon-large"></i>
					</p>
						<p class="field">
							<input type="password" name="password" placeholder="Password">
							<i class="icon-lock icon-large"></i>
					</p>
					<p class="submit">
						<button type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button>
					</p>
				</form>
			</section>
        </div>



	</body>
</html>