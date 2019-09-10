<?php

  /**
	*	
	*	@version	Work in progress!
	*
	*/







	
	/* inlcude autoloader or email_crawler */
	require_once "../includes/init.php";
	/* include tests page menu */
	require_once 'includes/menu.php';

	//if form is submitted
	if(isset($_POST["crawl"])) 
	{
		//check that url is set and is not empty
		if (isset($_POST["url"]) && !empty($_POST["url"])) 
		{

	        $_POST['url'] = htmlspecialchars($_POST['url']);
	        $_POST['url'] = str_replace("'", "&#39;", $_POST['url']);

			/* ========================================= */

			/* printing the whole output (unique is true, if you set it to false you will also get all the empty elements) */
			echo '<b>Output:</b> <br><br>';
			$list = explode(",", $_POST['url']);
			foreach($list as $site)
			{
				$crawler = new email_crawler($site, true);
				$crawl = $crawler->crawl_site();
				
				if($crawl != '')
				{
					echo '<br>Site ('.$site.') ';
					echo '<pre>';
					
					var_dump($crawl);
					
					echo '</pre>';
				}

				$crawler_list = new email_crawler($site, true, true, null, 'list');
				$list_crawl = $crawler_list->crawl_site();

				if($list_crawl != '')
				{
					echo '<br><b>Comma separated (unique):</b> <br><br>';
					print_r($list_crawl);
				}
			}

			


		}
	}

?>
<br>
<br>

<form method="POST">
	<textarea type="text" name="url" placeholder="website url" value="<?php if(isset($_POST['url'])): echo $_POST['url']; endif;?>"></textarea>
	<button type="submit" name="crawl">Get Email(s)</button>
</form>