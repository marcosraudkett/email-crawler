--TEST--
validate_email() function - Testing if validate_email() works
--FILE--
<?php
/* inlcude autoloader or email_crawler */
require_once dirname(dirname(__FILE__)) . "/../includes/init.php";
$crawler = new email_crawler(null);
$email = "info@example.com";
$test = $crawler->validate_email($email);
print_r($test);
?>
--EXPECT--
1