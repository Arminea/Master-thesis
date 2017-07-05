<?php
	require_once ('const.php');

	//check if form was submitted 
	if(isset($_POST['SubmitButton'])){ 
	  	header('Location: ' . INDEX_PAGE . "?lang=" . $_POST['lang'] . '#gallery' , TRUE, 302);
		exit(0);
	}    

	switch ($_GET['lang']) {
    	case 'cz':
    		require_once ('../lang/cz.php');
    		break;
    	case 'en':
    		require_once ('../lang/en.php');
    		break;
    	default:
    		require_once ('../lang/en.php');
    }
?>

<!DOCTYPE HTML>
<html lang="cz">
	<head>
		<title>Master thesis</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />

		<!-- <meta name=”google” content=”notranslate” /> -->
		<!-- <meta name="robots" content="noindex,nofollow"> dat do administrace -->

	</head>
	<body class="landing">


		<!-- Banner -->
		<a id="home" name="home"></a>
			<section id="banner">
				<h2><?php echo $lang['TITLE']; ?></h2>
			</section>


			<a id="form" name="form"></a>
			<section id="two" class="wrapper style1 special">
				<div class="inner adult">
					<header class="major narrow">
						<h2><?php echo $lang['WARNING']; ?></h2>
					</header>
					
					<ul>
						<li><?php echo $lang['COND_1']; ?></li>
						<li><?php echo $lang['COND_2']; ?></li>
						<li><?php echo $lang['COND_3']; ?></li>
						<li><?php echo $lang['COND_4']; ?></li>
					</ul>

				</div>

				<form id="form" method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
					<div class="container 75%">
						<input type="hidden" name="lang" value="<?php echo $_GET['lang']; ?>" />
						<input name="SubmitButton" type="submit" class="special" value="<?php echo $lang['WARNING_BACK']; ?>" />
					</div>
				</form>

			</section> 

			<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<div class="left">
						<ul class="icons">
							<li><img src="../images/icons/microsoft.png" /> <span class="label"><a href="https://github.com/Microsoft/CNTK" target="_blank"><?php echo $lang['CNTK']; ?></a></span></li>
						</ul>
					</div>
					<div class="right">
						<!-- <h4>Sitemap</h4>
						<ul>
							<!--<li><a class="toscroll" href="#home"><img src="../images/bg/up_1.png" /></a></li>
							<li><a class="toscroll" href="#imageUploadForm">Try me!</a></li>
							<li><a class="toscroll" href="#about">About my thesis</a></li>
							<li><a class="toscroll" href="#news">News</a></li>
							<li><a class="toscroll" href="#faq">FAQ</a></li>
							<!--<li><a class="toscroll" href="#how">How does it work?</a></li>
							<li><a class="toscroll" href="#gallery">Gallery</a></li>
							<li><a class="toscroll" href="#contact">Contact</a></li>
						</ul>

					-->
					</div>
				</div>
			</footer>

				<!-- Scripts -->
		<script src="../assets/js/jquery-1.12.1.min.js"></script>
		<script src="../assets/lightbox/js/lightbox.js"></script>
		<script src="../assets/js/skel.min.js"></script>
		<script src="../assets/js/util.js"></script>
		<script src="../assets/js/main.js"></script>
		

	</body>
</html>