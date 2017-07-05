<?php
	$selectedLang = $_GET['lang'];
	if(isset($selectedLang)){

		switch ($selectedLang) {
	    	case 'cz':
	    		require_once ('lang/cz.php');
	    		break;
	    	case 'en':
	    		require_once ('lang/en.php');
	    		break;
	    	default:
	    		require_once ('lang/en.php');
	    }
	} else {
		$selectedLang = 'en';
		require_once ('lang/en.php');
	}

?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Master thesis</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />

		<meta name=”google” content=”notranslate” />

		<link href="assets/lightbox/css/lightbox.css" rel="stylesheet" />
		<link rel="shortcut icon" href="">


	</head>
	<body class="landing">

		<nav id="nav">
			<div class="inner">
			<ul>
				<li><a class="toscroll" href="#imageUploadForm"><?php echo $lang['TRY_ME']; ?></a></li>
				<li><a class="toscroll" href="#about"> <?php echo $lang['ABOUT']; ?> </a></li>
				<li><a class="toscroll" href="#news"> <?php echo $lang['NEWS']; ?> </a></li>
				<li><a class="toscroll" href="#faq"> <?php echo $lang['FAQ']; ?> </a></li>
				<!--<li><a class="toscroll" href="#how">How does it work?</a></li>-->
				<li><a class="toscroll" href="#gallery"> <?php echo $lang['GALLERY']; ?> </a></li>
				<li><a class="toscroll" href="#contact"> <?php echo $lang['CONTACT']; ?> </a></li>
				<li>
					<a href="index.php?lang=en"><img class="flag" src="images/icons/flags/en.png" alt="English" title="<?php echo $lang['LANG_TITLE']; ?>" /></a>
					<a href="index.php?lang=cz"><img class="flag" src="images/icons/flags/cz.png" alt="Čeština" title="<?php echo $lang['LANG_TITLE']; ?>" /></a>
				</li>
			</ul>
		</div>
		</nav>	

		<!-- Banner -->
		<a id="home"></a>
		<section id="banner">
			<h2><?php echo $lang['TITLE']; ?></h2>
		</section>

			<a id="imageUploadForm"></a> 
			<section id="one" class="wrapper style1 special">
				<div class="inner">
					<header class="major narrow">
						<h2><?php echo $lang['TRY_ME']; ?></h2>
					</header>
					
					<div class="upload">
						<p><?php echo $lang['UPLOAD_1']; ?></p>
						<p><?php echo $lang['UPLOAD_2']; ?></p>
					</div>

					<form id="uploadForm" action="/cgi-bin/pdetect_linux.py" method="POST" enctype="multipart/form-data">
						<div class="container 75%">
							<div id="imageForm-messages" class="displayNope">
								<div id="imageForm-messages-text"></div>
								<div id="imageForm-messages-feedback" class="displayNope">
									<input type="hidden" id="path-imageForm-messages-feedback" value="" />
									<input type="hidden" id="P-class-imageForm-messages-feedback" value="" />
									<table style="margin-bottom: 0;">
										<tr> <td colspan="2" style="text-align: center; padding-top: 0.5em; padding-bottom: 0;"> <?php echo $lang['FEEDBACK']; ?> </td></tr>
										<tr>
											<td style="float: right;"> <button id="imageForm-messages-button-yes" name="imageForm-messages-button-yes" type="button"><?php echo $lang['BUTTON_YES']; ?></button> </td>
											<td> <button id="imageForm-messages-button-no" name="imageForm-messages-button-no" type="button"><?php echo $lang['BUTTON_NO']; ?></button> </td>
										</tr>
									</table>
								</div>
							</div>
							<div class="custom-upload"  >
								<input type="file" id="inputImage" name="inputImageUpload" value="" />
								<div class="fake-file">
									<input disabled="disabled" />
									<button id="fake-button" class="special"><?php echo $lang['BUTTON_SELECT_IMAGE']; ?></button>
								</div>
							</div>
						</div>
						<ul class="actions">
							<input type="hidden" value="<?php echo $selectedLang; ?>" id="hiddenLangUpload" name="hiddenLangUpload" />
							<li><input type="submit" class="special" value="<?php echo $lang['BUTTON_SEND']; ?>" id="uploadButton" /></li>
							<li><input type="reset" class="alt" value="<?php echo $lang['BUTTON_RESET']; ?>" id="imageResetButton" /></li>
						</ul>
					</form>

					<div id="loader" class="displayNope"></div>
					
    				<img id="outputImage" alt="outputImage" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" />
				</div>
			</section> 

			<a id="about"></a>
			<section id="two" class="wrapper special style2">
				<div class="inner">
					<header class="major narrow">
						<h2><?php echo $lang['ABOUT_MORE']; ?></h2>
					</header>

					<!--<div class="feature left">
						<span class="image"><img src="images/me.jpg" alt="" /></span>
						<div class="content">
							<p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est.</p>
						</div>
					</div>-->

					<p><?php echo $lang['ABOUT_ME']; ?></p>
					<p><?php echo $lang['ABOUT_PROJECT']; ?></p>
					
				</div>
			</section>


			<a id="news"></a>
			<section id="five" class="wrapper special news">
				<div class="inner">
					<header class="major narrow">
						<h2><?php echo $lang['NEWS']; ?></h2>
					</header>

					<div id="news_list" class="news_list_min_height">
						<?php
							$xml_path = $lang['NEWS_FILE'];
							if (file_exists($xml_path)) {
								$xml = simplexml_load_file($xml_path);
								foreach ($xml->news as $news) {

									echo "<h4>". $news->header ."<h4>";
									echo "<p id=\"date\">". $news->date ."</p>";
									echo "<p>". $news->text->asXML() ."</p>";
								}
							} else {
							    echo "<h4><?php echo $lang[NEWS_ERR]; ?></h4>";
							}
						?>
					</div>

					<button id="news_see_more" ><?php echo $lang['BUTTON_SEE_MORE']; ?></button>
					<button id="news_see_less" class="displayNope"><?php echo $lang['BUTTON_SEE_LESS']; ?></button>
				</div>
			</section>
			

			<a id="faq"></a>
			<section id="three" class="wrapper special style4 faq">
				<div class="inner">
					<header class="major narrow">
						<h2><?php echo $lang['FAQ']; ?></h2>
					</header>

					<div id="faq_list" > <!-- class="faq_list_min_height" -->
						<?php
							$xml_path = $lang['FAQ_FILE'];
							if (file_exists($xml_path)) {
								$xml = simplexml_load_file($xml_path);
								echo "<ol>";
								foreach ($xml->faq as $faq) {
									echo "<li>";
									echo "<p class=\"question\">". $faq->question ."</p>";
									echo "<p class=\"answer\">". $faq->answer->asXML() ."</p>";
									echo "</li>";
								}
								echo "</ol>";
							} else {
							    echo "<h4><?php echo $lang[FAQ_ERR]; ?></h4>";
							}
						?>
					</div>

					<!--<button id="faq_see_more" ><?php echo $lang['BUTTON_SEE_MORE']; ?></button>
					<button id="faq_see_less" class="displayNope"><?php echo $lang['BUTTON_SEE_LESS']; ?></button>-->
				</div>
			</section>

			<!--
			<a id="how"></a>
			<section id="four" class="wrapper special">
				<div class="inner">
					<header class="major narrow">
						<h2>How does it work?</h2>
					</header>

				</div>
			</section> -->
			

			<a id="gallery"></a>
			<section id="seven" class="wrapper special news">
				<div class="inner">
					<header class="major narrow">
						<h2><?php echo $lang['GALLERY']; ?></h2>
					</header>

					<h4><?php echo $lang['GALLERY_NONTARGET']; ?></h4>
					<p><?php echo $lang['GALLERY_NONTARGET_TEXT']; ?></p>
					<div class="image-grid">
						<span class="image"><a href="images/gallery/nontarget/1.jpg" data-lightbox="nontarget" data-title="Source: www.flickr.com/photos/one_x/" ><img src="images/gallery/nontarget/1.jpg" alt=""/></a></span>
						<span class="image"><a href="images/gallery/nontarget/2.jpg" data-lightbox="nontarget" data-title="Source: www.flickr.com/photos/roccosart/" ><img src="images/gallery/nontarget/2.jpg" alt="" /></a></span>
						<span class="image"><a href="images/gallery/nontarget/3.jpg" data-lightbox="nontarget" data-title="Source: www.flickr.com/photos/soymae/" ><img src="images/gallery/nontarget/3.jpg" alt="" /></a></span>
						<span class="image"><a href="images/gallery/nontarget/4.jpg" data-lightbox="nontarget" data-title="Source: www.flickr.com/photos/lucyndskywdmnds/" ><img src="images/gallery/nontarget/4.jpg" alt="" /></a></span>
					</div>

					<h4><?php echo $lang['GALLERY_QUESTIONABLE']; ?></h4>
					<p><?php echo $lang['GALLERY_QUESTIONABLE_TEXT']; ?></p>
					<div class="image-grid">
						<span class="image"><a href="images/gallery/questionable/1.jpg" data-lightbox="questionable" data-title="Source: Getty Images, Model: Bella Hadid" ><img src="images/gallery/questionable/1.jpg" alt=""/></a></span>
						<span class="image"><a href="images/gallery/questionable/2.jpg" data-lightbox="questionable" data-title="Source: Getty Images, Model: Rose McGowan" ><img src="images/gallery/questionable/2.jpg" alt="" /></a></span>
						<span class="image"><a href="images/gallery/questionable/3.PNG" data-lightbox="questionable" data-title="Source: www.instagram.com/beautifulbusts, Model: Raven Lexy" ><img src="images/gallery/questionable/3.PNG" alt="" /></a></span>
						<span class="image"><a href="images/gallery/questionable/4.PNG" data-lightbox="questionable" data-title="Source: www.instagram.com/beautifulbusts, Model: Kate Upton" ><img src="images/gallery/questionable/4.PNG" alt="" /></a></span>
					</div>

					<h4><?php echo $lang['GALLERY_TARGET']; ?></h4>
					<p><?php echo $lang['GALLERY_TARGET_TEXT']; ?></p>
					<button id="gallery_see_more" ><?php echo $lang['GALLERY_TARGET_BUTTON']; ?></button>
					<div id="gallery-target-images" class="displayNope"> <!--  -->
						<div class="image-grid">
							<span class="image"><a href="images/gallery/target/1.jpg" data-lightbox="target" data-title="Source: www.navratdoreality.cz" ><img src="images/gallery/target/1.jpg" alt=""/></a></span>
							<span class="image"><a href="images/gallery/target/2.jpg" data-lightbox="target" data-title="Source: www.navratdoreality.cz" ><img src="images/gallery/target/2.jpg" alt="" /></a></span>
							<span class="image"><a href="images/gallery/target/3.jpg" data-lightbox="target" data-title="Source: www.navratdoreality.cz" ><img src="images/gallery/target/3.jpg" alt="" /></a></span>
							<span class="image"><a href="images/gallery/target/4.jpg" data-lightbox="target" data-title="Source: www.navratdoreality.cz" ><img src="images/gallery/target/4.jpg" alt="" /></a></span>
						</div>
					</div>
				</div>
			</section>

		
			<a id="contact"></a>
			<section id="six" class="wrapper style2 special">
				<div class="inner">
					<header class="major narrow">
						<h2><?php echo $lang['CONTACT']; ?></h2>
						<p><?php echo $lang['CONTACT_TEXT']; ?></p>
					</header>

					<form id="contactForm" action="scripts/contact.php" method="POST">
						<div class="container 75%">
							<div id="contactForm-messages"></div>

							<div class="row uniform 50%">
								<div class="6u 12u$(xsmall)">
									<input id="contactFormName" name="name" placeholder="<?php echo $lang['CONTACT_NAME']; ?>" type="text" required="required" />
								</div>
								<div class="6u$ 12u$(xsmall)">
									<input id="contactFormEmail" name="email" placeholder="<?php echo $lang['CONTACT_EMAIL']; ?>" type="email" required="required" />
								</div>
								<div class="12u$">
									<textarea id="contactFormMessage" name="message" placeholder="<?php echo $lang['CONTACT_MESSAGE']; ?>" rows="4" required="required"></textarea>
								</div>
							</div>
						</div>
						<ul class="actions">
							<input type="hidden" value="<?php echo $selectedLang; ?>" id="hiddenLangContact" />
							<li><input type="submit" class="special" value="<?php echo $lang['BUTTON_SEND']; ?>" /></li>
							<li><input type="reset" class="alt" value="<?php echo $lang['BUTTON_RESET']; ?>" id="contactResetButton" /></li>
						</ul>
					</form>

				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<div class="left">
						<ul class="icons">
							<li><img src="images/icons/microsoft.png" /> <span class="label"><a href="https://github.com/Microsoft/CNTK" target="_blank"><?php echo $lang['CNTK']; ?></a></span></li>
							<!--
							<li><img src="images/icons/facebook.png" /> <span class="label"><a href="https://www.facebook.com/tereza.stanglova" target="_blank"> Facebook </a></span></li>
							<li><img src="images/icons/instagram.png" /> <span class="label"><a href="https://www.instagram.com/teri_elvenwarrior/" target="_blank"> Instagram </a></span></li>
							-->
						</ul>
					</div>
					<div class="right">
						<h4><?php echo $lang['SITEMAP']; ?></h4>
						<ul>
							<li><a class="toscroll" href="#imageUploadForm"> <?php echo $lang['TRY_ME']; ?> </a></li>
							<li><a class="toscroll" href="#about"> <?php echo $lang['ABOUT']; ?> </a></li>
							<li><a class="toscroll" href="#news"> <?php echo $lang['NEWS']; ?> </a></li>
							<li><a class="toscroll" href="#faq"> <?php echo $lang['FAQ']; ?> </a></li>
							<!--<li><a class="toscroll" href="#how">How does it work?</a></li>-->
							<li><a class="toscroll" href="#gallery"> <?php echo $lang['GALLERY']; ?> </a></li>
							<li><a class="toscroll" href="#contact"> <?php echo $lang['CONTACT']; ?> </a></li>		
						</ul>
					</div>
				</div>
			</footer>

		<!-- Scripts -->
		<script src="assets/js/jquery-1.12.1.min.js"></script>
		<script src="assets/lightbox/js/lightbox.js"></script>
		<script src="assets/js/skel.min.js"></script>
		<script src="assets/js/main.js"></script>
		<script src="assets/js/util.js"></script>
		
	</body>
</html>