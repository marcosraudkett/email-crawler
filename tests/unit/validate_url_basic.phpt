--TEST--
validate_url() function - Testing if validate_url() works
--FILE--
<?php
/* inlcude autoloader or email_crawler */
require_once "../../includes/init.php";
$crawler = new email_crawler(null);
$input = "http://example.com";
$test = $crawler->validate_url($input);
print_r($test);
?>
--EXPECT--
1