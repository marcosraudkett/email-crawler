# Simple Email Crawler
A PHP Email Crawler. Crawl a single website or multiple websites for email address(s) using simple_html_dom
You can test this crawler here:

https://marcosraudkett.com/mvrclabs/email-crawler/tests/

### Features
<ul>
  <li>Crawl emails from target website(s)</li>
  <li>Crawl's emails even if the @ sign is (at) or something else! (check classes/config.class.php) for controlling the syntax(s)</li>
  <li>Deep crawl (crawler navigates through the target site) (check classes/config.class.php) for controlling the path</li> 
  <li>Easily output into a comma separated list or in plaintext</li>
  <li>Bulk crawl websites (wip)</li>
  <li>Filter out unique email address(s)</li>
  <li>Tests site connection and validates link before crawling</li>
  <li>Validates emails before returning to make sure their valid</li>
</ul>


### todo
- [x] Fix depth search (crawl through other pages on the target site)<br>
- [ ] Multiple site support
- [x] Fix matching bug
- [x] Unique fix

### Installation
```
git clone https://github.com/marcosraudkett/simple-email-crawler.git
```

### Usage
Including with autoloader:
```php
<?php
  /* use autoloader */
  require_once "/path/to/includes/init.php";
?>
```
including without autoloader: 

```php
<?php
  /* include email_crawler */
  require_once "/path/to/classes/email_crawler.class.php";
?>
```
Crawling a site
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'http://example-site.com';
  $crawl = email_crawler::crawl_site($url);
  
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
  
  /* 
  Example output:
    info@examplemail.com (Element: a) 
    info@example.com (Element: p) 
    info@divexample.com (Element: div) 
    info@spanexample.com (Element: span) 
  */
?>
```

Crawling a site (into a comma separated list)
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'http://example-site.com';
  /* settings: unique: true, depth: null, print_type: list (comma separated) */
  $crawl = email_crawler::crawl_site($url, true, null, 'list');
  if($crawl != '') { print_r($crawl); }
  
  /* 
  Example output:
    info@examplemail.com, info@example.com, info@divexample.com, info@spanexample.com
  */
?>
```

Crawling a site (plain list)
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'http://example-site.com';
  /* settings: unique: false, depth: null, print_type: emails_only_plain */
  $crawl = email_crawler::crawl_site($url, false, null, 'emails_only_plain');
  if($crawl != '') { print_r($crawl); }
  
  /* 
  Example output:
    info@examplemail.com info@example.com info@divexample.com info@spanexample.com
  */
  
?>
```

## Contributing
Feel free to help this project or if you've found a bug then feel free to visit [the issues page](https://github.com/marcosraudkett/simple-email-crawler/issues).
