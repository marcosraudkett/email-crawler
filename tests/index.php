<?php
	
	/* inlcude autoloader or email_crawler */
	require_once "../includes/init.php";

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
			$crawl = email_crawler::crawl_site($_POST['url'], true);
			
			if($crawl != '')
			{
			
				echo '<pre>';
				
				var_dump($crawl);
				
				echo '</pre>';


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
				$emails_only = email_crawler::crawl_site($_POST['url'], false, null, 'emails_only_plain');
				if($emails_only != '')
				{
					echo '<b>Plaintext (non-unique):</b> <br><br>';
					print_r($emails_only);
					echo '<br><br>';
				}

				/* ========================================= */

				/* settings: unique: true, depth: null, print_type: list (comma separated) */
				$list_crawl = email_crawler::crawl_site($_POST['url'], true, null, 'list');
				if($list_crawl != '')
				{
					echo '<b>Comma separated (unique):</b> <br><br>';
					print_r($list_crawl);
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
	<input type="text" name="url" placeholder="website url" value="<?php if(isset($_POST['url'])): echo $_POST['url']; endif;?>">
	<button type="submit" name="crawl">Get Email(s)</button>
</form>