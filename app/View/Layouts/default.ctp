<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'KlokWork: Attorney Billing System (Powered by deftSync)');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $cakeDescription ?>:
			<?php echo $title_for_layout; ?>
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			//echo $this->Html->meta('icon');

			echo $this->Html->css('bootstrap');
			echo $this->Html->css('chosen.min');
			echo $this->Html->css('bootstrap-datetimepicker.min');
			echo $this->Html->css('cake.generic');

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
			echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'));
		?>
	</head>
	<body>

		<div id="container">
			<div id="header">
	        <?php echo $this->Html->image('klokworklaw-web-logo.png', array('style' => 'margin-top:10px;height:auto;', 'alt' => 'Klokwork')); ?>
	        <h1 style="float:right;padding:0;text-transform:uppercase;" class="hidden-xs">Signed In As: <?php echo $userName;?></h1>
				<h1 style="padding:0;text-transform:uppercase;" class="visible-xs">Signed In As: <?php echo $userName;?></h1>
			</div>
			<nav class="navbar-wrapper navbar-default" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="background: -webkit-linear-gradient(top, #6171b6 0%, #1a3f8f 100%);">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			         </button>
					</div>
					<div class="collapse navbar-collapse">
				      <div class="collapse navbar-collapse" id='cssmenu'>
			            <ul class="nav navbar-nav">
			               <li style=" position:relative;" <?php if($this->params['controller']=='home')echo "class='active'";?>><a href='<?php echo Router::url('/');?>home/index/sort:client_last_name/direction:asc'><span>Open Cases</span></a></li>
			               <li style=" position:relative;"<?php if($this->params['controller']=='work_orders')echo "class='active'";?> ><a href='<?php echo Router::url('/');?>work_orders'><span>Case History</span></a></li>
			               <li style=" position:relative;"<?php if($this->params['controller']=='timesheets')echo "class='active'";?> ><a href='<?php echo Router::url('/');?>timesheets'><span>Search</span></a></li>
			               <!--<li id="LogoutBtn" style="position:relative; /*float:right;*/ left:0;"><?php echo $this->Html->link('Log Out', array('controller' => 'users', 'action' => 'logout'));?></li>-->
			               <span id="options">
			               	<li id="helpBtn" style="position:relative;left:0;">
			                		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Help<span class="caret"></span></a>
			                		<ul class="dropdown-menu" role="menu">
			                			<li class="helpMenuItem"><?php echo $this->Html->link('KlokWorkLaw Manual','/Usermanual_Law.pdf'); ?>
			                			</li>
			                		</ul>
			                	</li>
			                	<li id="LogoutBtn" style="position:relative; /*float:right;*/ left:0;"><?php echo $this->Html->link('Log Out', array('controller' => 'users', 'action' => 'logout'));?></li>
			             	</span>
			            </ul>
				     </div>
			     	</div>
				</div>
			</nav>
			<div id="content" style="width:100%;background:#fff !important;">

				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
			</div>
			<div id="footer">
				<p> (c) 2014 KlokWorkLaw. All rights reserved. Powered by deftSync</p>
			</div>
		</div>
 		<?php echo $this->Html->script(array('bootstrap.min.js'));?>
 		<?php echo $this->Html->script(array('moment.min.js'));?>
 		<?php echo $this->Html->script(array('bootstrap-datetimepicker.min.js'));?>
 		<?php echo $this->Html->script(array('chosen.jquery.min.js'));?>
	</body>
</html>
