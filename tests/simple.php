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

?>
<br>
<br>

<form method="POST">
	<input type="text" name="url" placeholder="website url" value="<?php if(isset($_POST['url'])): echo $_POST['url']; endif;?>">
	<button type="submit" name="crawl">Get Email(s)</button>
</form>