<?php
	/* inlcude autoloader or email_crawler */
	require_once "../includes/init.php";
	/* include tests page menu */
	require_once 'includes/menu.php';


	$url = '';
	$crawler = new email_crawler($url);
	$crawl  = $crawler->crawl_site();

	var_dump($crawl);

?>
