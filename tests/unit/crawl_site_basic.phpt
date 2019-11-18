--TEST--
crawl_site() function - Testing if crawl_site() basic mode works
Calling -> new email_crawler($crawl_site, false);
Expecting -> 
info@examplemail.com (Element: a)
info@example.com (Element: p)
info@divexample.com (Element: div)
info@spanexample.com (Element: span)
--FILE--
<?php
/* inlcude autoloader or email_crawler */
require_once dirname(dirname(__FILE__)) . "/../includes/init.php";
$crawl_site = "https://marcosraudkett.com/mvrclabs/email-crawler/tests/test_pages/simple/";
$crawler = new email_crawler($crawl_site, false);
$crawl = $crawler->crawl_site();
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
?>
--EXPECT--
info@examplemail.com (Element: a) <br>info@example.com (Element: p) <br>info@divexample.com (Element: div) <br>info@spanexample.com (Element: span) <br>