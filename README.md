# email-crawler
A PHP Email Crawler. Crawl a single website or multiple websites for email address(s) using simple_html_dom

### Include Email Crawler
```php
<?php
  /* use autoloader */
  require_once "../includes/init.php";
?>
```

### Include Email Crawler #2
```php
<?php
  /* include email_crawler */
  require_once "../classes/email_crawler.class.php";
?>
```

### Usage
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'https://marcosraudkett.com';
  $crawl = email_crawler::crawl_site($url);
?>
```
