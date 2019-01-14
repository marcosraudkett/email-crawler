# email-crawler
A PHP Email Crawler. Crawl a single website or multiple websites for email address(s) using simple_html_dom

### Usage
```php
<?php
  /* use autoloader */
  require_once "../includes/init.php";
?>
```

### Usage #2
```php
<?php
  /* include email_crawler */
  require_once "../classes/email_crawler.class.php";
?>
```

### Crawl a url
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'https://marcosraudkett.com';
  $crawl = email_crawler::crawl_site($url);
?>
```
