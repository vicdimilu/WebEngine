<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 2.0.0
 * @author Lautaro Angelico <https://lautaroangelico.com/>
 * @copyright (c) 2013-2018 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * https://opensource.org/licenses/MIT
 */

// Access
if(!defined('access') or !access) die();

// Template Functions
Handler::loadTemplateFunctions();

// set column size of content when sidebar is on/off
$contentColSize = Handler::showSidebar() ? 8 : 12;

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?php echo Handler::websiteTitle(); ?></title>
		<meta name="generator" content="WebEngine <?php echo Handler::getWebEngineVersion(); ?>"/>
		<meta name="author" content="<?php echo Handler::getWebEngineAuthor(); ?>"/>
		<meta name="description" content="<?php echo Handler::getWebsiteDescription(); ?>"/>
		<meta name="keywords" content="<?php echo Handler::getWebsiteKeywords(); ?>"/>
		<link rel="shortcut icon" href="<?php echo Handler::templateBase(); ?>favicon.ico"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="<?php echo Handler::templateCSS('bootstrap.css'); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo Handler::templateCSS('style.css'); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo Handler::templateCSS('override.css'); ?>" rel="stylesheet" media="screen">
		<script>
			var baseUrl = '<?php echo Handler::websiteLink(); ?>';
		</script>
	</head>
	<body>
		<!-- GLOBAL MENU -->
		<div class="container-fluid globalmenu">
			<div class="row">
				<div class="col-xs-6 col-lg-6 pt-1">
					<a href="<?php echo Handler::getWebEngineWebsite(); ?>" target="_blank"><img class="img-fluid" src="<?php echo Handler::templateIMG('webengine_logo_xs_gs.png'); ?>"/></a>
				</div>
				<div class="col-xs-6 col-lg-6 text-right">
					<?php if(isAdmin()) { ?>
					<a href="<?php echo Handler::websiteLink('admincp'); ?>/" class="btn btn-xs btn-sm btn-lg"><?php echo lang('admincp'); ?></a>
					<?php } ?>
					<?php if(!isLoggedIn()) { ?>
					<a href="<?php echo Handler::websiteLink('login'); ?>" class="btn btn-xs btn-sm btn-lg"><?php echo lang('login'); ?></a>
					<a href="<?php echo Handler::websiteLink('register'); ?>" class="btn btn-xs btn-sm btn-lg btn-red"><?php echo lang('register'); ?></a>
					<?php } else { ?>
					<a href="<?php echo Handler::websiteLink('logout'); ?>" class="btn btn-xs btn-sm btn-lg btn-red"><?php echo lang('logout'); ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<!-- HEADER -->
		<div id="header">
			<div id="headerLogo">
				<a href="<?php echo Handler::websiteLink(); ?>"><img src="<?php echo Handler::templateIMG('logo.png'); ?>" /></a>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-lg-12">
					<!-- NAVBAR -->
					<div class="navbar">
						<?php templateBuildNavbar(); ?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- CASTLE SIEGE BANNER -->
		<!--
		<div class="castle-siege-banner">
			<div class="row">
				<div class="col-xs-3 text-center">
					
				</div>
				<div class="col-xs-6 text-center">
					
				</div>
				<div class="col-xs-3 text-center">
					
				</div>
			</div>
		</div>
		-->
		
		<!-- CONTENT -->
		<div id="content" class="container">
			<div class="row">
				<div class="col-xs-<?php echo $contentColSize; ?> col-lg-<?php echo $contentColSize; ?>">
					<?php Handler::loadModule(); ?>
				</div>
				<?php if(Handler::showSidebar()) { ?>
				<div class="col-xs-4 col-lg-4 sidebar">
					<?php Handler::loadSidebarBlocks(); ?>
				</div>
				<?php } ?>
			</div>
		</div>
		
		<!-- FOOTER -->
		<div class="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-8 col-lg-8">
						<p><?php echo lang('footer_txt_1', array(date("Y"), config('server_name'), Handler::websiteLink('terms-of-service'), Handler::websiteLink('privacy-policy'))); ?></p>
						<p><?php echo lang('footer_txt_2'); ?></p>
						<br />
						<p><?php echo lang('footer_txt_3'); ?></p>
						<br />
						<p><a href="<?php echo Handler::getWebEngineWebsite(); ?>" target="_blank" title="<?php echo Handler::getWebEngineVersion(true); ?>"><img src="<?php echo Handler::templateIMG('webengine_footer_logo.png'); ?>"/></a></p>
					</div>
					<div class="col-xs-4 col-lg-4">
						<div class="row">
							<div class="col-xs-6 col-lg-6 text-center">
								<span><?php echo lang('server_time'); ?></span><br />
								<span class="footer-time"><time id="tServerTime"></time></span>
							</div>
							<div class="col-xs-6 col-lg-6 text-center">
								<span><?php echo lang('user_time'); ?></span><br />
								<span class="footer-time"><time id="tLocalTime"></time></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- JS -->
		<script  src="https://code.jquery.com/jquery-3.4.0.min.js"  integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="  crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="<?php echo Handler::templateJS('main.js'); ?>"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>