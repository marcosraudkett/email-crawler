<?php
	
	/* inlcude autoloader or email_crawler */
	require_once "../includes/init.php";

	//if form is submitted
	if(isset($_POST["crawl"])) 
	{
		//check that url is set and is not empty
		if (isset($_POST["url"]) && !empty($_POST["url"])) 
		{

			$crawl = email_crawler::crawl_site($_POST['url']);

			/* foreach email */
			foreach($crawl['results'] as $result) 
			{
				echo $result['email'];
			}

		}
	}

?>
	
<form method="POST">
	<input type="text" name="url" placeholder="website url">
	<button type="submit" name="crawl">Get Email(s)</button>
</form>
