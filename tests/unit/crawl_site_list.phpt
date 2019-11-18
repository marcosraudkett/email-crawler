--TEST--
crawl_site() function - Testing if crawl_site() using list mode works
Calling -> new email_crawler($crawl_site, false, null, 'list');
Expecting -> info@examplemail.com, info@example.com, info@divexample.com, info@spanexample.com
--FILE--
<?php
/* inlcude autoloader or email_crawler */
require_once "../../includes/init.php";
/* settings: unique: true, depth: null, print_type: list (comma separated) */
$crawl_site = "https://marcosraudkett.com/mvrclabs/email-crawler/tests/test_pages/simple/";
$crawler = new email_crawler($crawl_site, false, null, 'list');
$list_crawl = $crawler->crawl_site();
if($list_crawl != '')
{
	print_r($list_crawl);
}
?>
--EXPECT--
info@examplemail.com, info@example.com, info@divexample.com, info@spanexample.com