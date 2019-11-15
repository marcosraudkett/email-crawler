# Simple Email Crawler
A PHP Email Crawler. Crawl a single website or multiple websites for email address(s) using simple_html_dom

### Features
<ul>
  <li>Crawl emails from target website(s)</li>
  <li>Crawl's emails even if the @ sign is (at) or something else! (check classes/config.class.php) for controlling the regexes</li>
  <li>Deep crawl (crawler navigates through the target site) (check classes/config.class.php) for controlling the path</li> 
  <li>Easily output into a comma separated list or in plaintext</li>
  <li>Bulk crawl websites (wip)</li>
  <li>Filter out duplicate email address(s)</li>
  <li>Tests site connection and validates link before crawling</li>
  <li>Validates emails before returning to make sure they are valid</li>
</ul>

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
<details>
  <summary>including without autoloader:</summary>

```php
<?php
  /* include email_crawler */
  require_once "/path/to/classes/email_crawler.class.php";
?>
```
</details>

<details>
  <summary>Crawling a site</summary>
  
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'http://example-site.com';
  $crawler = new email_crawler($url, false);
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
  
  /* 
  Example output:
    info@examplemail.com (Element: a) 
    info@example.com (Element: p) 
    info@divexample.com (Element: div) 
    info@spanexample.com (Element: span) 
  */
?>
```
</details>

<details>
  <summary>Crawling a site (into a comma separated list)</summary>
  
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'http://example-site.com';
  /* settings: unique: true, depth: null, print_type: list (comma separated) */
  $crawler = new email_crawler($url, true, null, 'list');
  $crawl = $crawler->crawl_site();
  if($crawl != '') { print_r($crawl); }
  
  /* 
  Example output:
    info@examplemail.com, info@example.com, info@divexample.com, info@spanexample.com
  */
?>
```
</details>

<details>
  <summary>Crawling a site (plain list)</summary>
    
```php
<?php
  /* Your url that you wish to crawl */
  $url = 'http://example-site.com';
  /* settings: unique: false, depth: null, print_type: emails_only_plain */
  $crawler = new email_crawler($url, false, null, 'emails_only_plain');
  $crawl = $crawler->crawl_site();
  if($crawl != '') { print_r($crawl); }
  
  /* 
  Example output:
    info@examplemail.com info@example.com info@divexample.com info@spanexample.com
  */
  
?>
```
</details>

## Contributing
Feel free to help this project or if you've found a bug then feel free to visit [the issues page](https://github.com/marcosraudkett/simple-email-crawler/issues).
