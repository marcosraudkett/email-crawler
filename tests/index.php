<?php
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
			$crawler = new email_crawler($_POST['url'], false);
			$crawl = $crawler->crawl_site();
			
			/*
				echo '<pre>';
				
				var_dump($crawler);

				var_dump($test);
				
				echo '</pre>';
			*/
					
			if($crawl != '')
			{
			


				/* ========================================= */

				/* with foreach (same as below "emails_only_plain" but printing it manually)*/
				echo '<b>Emails:</b> <br><br>';
				if($crawl['results'] != '')
				{
					if(count($crawl['results']) != 0) 
					{
						foreach($crawl['results'] as $result) 
						{
							echo $result['email'].' (Element: '.$result['element'].') <br>';
						}
					}
				}
				echo '<br>';

				/* ========================================= */

				/* settings: unique: false, depth: null, print_type: emails_only_plain */
				$crawler = new email_crawler($_POST['url'], false, null, 'emails_only_plain');
				$crawl = $crawler->crawl_site();
				if($crawl != '')
				{
					echo '<b>Plaintext (non-unique):</b> <br><br>';
					print_r($crawl);
					echo '<br><br>';
				}

				/* ========================================= */

				/* settings: unique: true, depth: null, print_type: list (comma separated) */
				$crawler = new email_crawler($_POST['url'], false, null, 'list');
				$crawl = $crawler->crawl_site();
				if($crawl != '')
				{
					echo '<b>Comma separated (unique):</b> <br><br>';
					print_r($crawl);
				}
			} else {
				echo 'Nothing found!';
			}


		}
	}

?>
<br>
<br>

<form method="POST">
	<input type="text" name="url" placeholder="website url" value="<?php if(isset($_POST['url'])) { echo $_POST['url']; } else { echo 'https://marcosraudkett.com/mvrclabs/email-crawler/tests/test_pages/simple/'; }?>">
	<button type="submit" name="crawl">Get Email(s)</button>
</form>