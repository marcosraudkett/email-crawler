# email-crawler
A PHP Email Crawler. Crawl a single website or multiple websites for email address(s) using simple_html_dom

### Usage
```php
<?php
  require_once 'classes/Tallink.class.php';
  /* or use autoloader */
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
