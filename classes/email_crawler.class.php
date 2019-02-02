<?php

/**
 * Email Crawler class
 *
 *
 * PHP version 7
 *
 *
 * @category   email_crawler
 * @package    email_crawler
 * @author     Marcos Raudkett <info@marcosraudkett.com>
 * @copyright  2019 Marcos Raudkett
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @version    1.0.1
 */

class email_crawler
{

	/**
     * @var string
     */
	public $url;

	/**
	* Crawl a remote site
	* set depth to true if you wish to also crawl throught other pages on the target website.
	*
	* @param $url    	   - required     [string]
	* @param $element 	   - required     [array]
	* @param $depth   	   - not required [true / null]
	* @param $print_type   - not required [list / emails_only_plain / null]
	* @return array
	*/
	public static function crawl_site($url, $unique = null, $depth = null, $print_type = null) 
	{
		/* useragent */
		self::set_useragent('SEC (http://whx.io/SEC)');

		/* if url is set*/
		if(isset($url))
        { 
        	/* check url */
        	$clean_url = self::clean_url($url);
        	/* test url */
        	$test_url = self::test_url($clean_url);

        	if($test_url == true) 
        	{

        		/* list of elements to crawl */
        		$list_of_elements = self::elements();
        		/* foreach element */
        		foreach($list_of_elements as $element) 
        		{
        			/* if depth is true */
        			if($depth == true)
        			{	
        				/* list of menuElements to crawl */
        				$list_of_menuElements = self::elements();
        				/* foreach menuElements */
        				foreach($list_of_menuElements as $menuElement) 
        				{
	        				/* depth crawl */
	    					$email = self::depth_crawl_site_for_email($clean_url, $element, $menuElement);
    					}
        			} else {
        				/* crawl first page only */
    					$email = self::crawl_site_for_email($clean_url, $element);
        			}
        			if($email != '')
        			{
	        			$result['results'][] = array(
	        				'element' => $element,
	        				'email' => $email
	        			);
        			}
        		}

        		if(isset($print_type))
        		{
	        		switch($print_type)
	        		{
	        			default:
	        			case "list":
	        				$list = array();
	        				foreach($result['results'] as $result_to_list)
	        				{
	        					$list[] = $result_to_list['email'];
	        				}
	        				if($unique == true) { $list = implode(', ', array_unique($list)); } else { $list = implode(', ', $list); }
	        				return $list;
	        			break;

	        			case "emails_only_plain":
	        				if($result['results'] != '')
							{
								if(count($result['results']) != 0) 
								{
									$list = array();
									foreach($result['results'] as $result) 
									{
										$list[] = $result['email'];
									}
									if($unique == true) { $list = implode(' ', array_unique($list)); } else { $list = implode(' ', $list); }
									return $list;
								}
							}
	        			break;
	        		}
        		} else {
        			if(isset($result))
        			{
	        			if($unique == true) 
						{
							if(is_array($result))
							{
			        			return array_unique($result);
							} else {
			        			return $result;
							}
		        		} else {
		        			/* return results */
		        			return $result;
		        		}
        			}
        		}

        	}

        }

	}

	/**
	* crawling
	* set depth to true if you wish to also crawl throught other pages on the target website.
	*
	* @param $url     - required     [string]
	* @param $element - required     [array]
	* @return string
	*/
	public static function crawl_site_for_email($url, $element) 
	{

		/* crawl url */
		$get_html = file_get_html('http://'.$url);
		/* find all url elements */
		$find_element = $get_html->find($element);
		/* foreach element from elements(); */
		foreach($find_element as $this_element) 
    	{

    		if($this_element != 'a') 
    		{
    			/* if the element is not a link but plaintext */
	    		foreach(self::emailPatternList() as $pattern)
	    		{
	    			/* match the element with pattern */
					preg_match_all($pattern, $this_element->plaintext, $matches);
					foreach($matches[0] as $match)
					{
						/* all matches (not unique) */
						$result = $match;
					}
				}
				if(isset($result))
    			{	
					$result = $result;
				}
    		} else {
	    		/* make mailto: empty inside href */
	    		$result = str_replace('mailto:','', $this_element->href);
	    		/* clean out the parameters if it has any */
				$result = strtok($result, '?');
	    		/* replacer */
	    		$result = self::syntax_replacer($result);
    		}

    		if(isset($result))
    		{	
				/* validate if email */
				if(self::validate_email($result) == true)
				{
					/* return validated email */
					return $result;
				}
    		}

    	}

	}

	/**
	* depth crawling
	*
	* @param $url     - required     [string]
	* @param $element - required     [array]
	* @param $depth   - not required [true / null]
	* @return string
	*/
	public static function depth_crawl_site_for_email($url, $element, $menuElement) 
	{
		/* extend maximum execution time for deep crawling */
		ini_set('max_execution_time', 300);

		/* crawl url */
		$get_html = file_get_html('http://'.$url);
		/* find all url elements */
		$find_element = $get_html->find($menuElement);
		/* foreach menuElement */
		foreach($find_element as $thisMenuElement)
		{
			/* find thisMenuElement */
			$menuLink = $get_html->find($thisMenuElement);
			/* foreach menuLink */
			foreach($menuLink as $menuLinkContent) 
			{
				/* get that menuLink href */
				$menuLinkContent = $menuLinkContent->href;
				/* only crawl sites that have the same host */
				if (strpos($menuLinkContent, $url) !== false) 
				{
					/* make sure that it's a valid link */
					if(self::validate_url($menuLinkContent) == true)
					{
						/* check url */
			        	$clean_url = self::clean_url($menuLinkContent);
						print_r($clean_url);
			        	/* test url */
			        	$test_url = self::test_url($clean_url);
			        	if($test_url == true) 
	        			{
				        	/* get that page html */
				        	$this_page = file_get_html('http://'.$clean_url);
				        	/* find all url elements */
							$find_depth_element = $this_page->find($element);
							/* foreach element on that page */
							foreach($find_depth_element as $this_element) 
					    	{

					    		if($this_element != 'a') 
					    		{
					    			/* if the element is not a link but plaintext */
						    		foreach(self::emailPatternList() as $pattern)
						    		{
						    			/* match the element with pattern */
										preg_match_all($pattern, $this_element->plaintext, $matches);
										foreach($matches[0] as $match)
										{
											/* all matches (not unique) */
											$result = $match;
										}
									}
									if(isset($result))
					    			{	
										$result = $result;
									}
					    		} else {
						    		/* make mailto: empty inside href */
						    		$result = str_replace('mailto:','', $this_element->href);
						    		/* clean out the parameters if it has any */
									$result = strtok($result, '?');
						    		/* replacer */
						    		$result = self::syntax_replacer($result);
					    		}

					    		if(isset($result))
					    		{	
									/* validate if email */
									if(self::validate_email($result) == true)
									{
										/* return validated email */
										return $result;
									}
					    		}

					    	}
					    }
				    }
				}
		    }
	    }

	}

	/**
	* syntax_replacer
	*
	* @param $replace_in
	* @return string
	*/
	public static function syntax_replacer($replace_in) 
	{

		/* email syntax */
		$es = '@';
		/* replace */
		$replaced = str_replace(config::SYNTAX_LIST, $es, $replace_in);
		/* return replaced */
        return $replaced;

	}

	/**
	* syntaxList
	*
	* @return array
	*/
	public static function syntaxList() 
	{

		/* syntaxList */
		$syntaxList = config::SYNTAX_LIST;
		/* return syntaxList */
		return $syntaxList;

	}

	/**
	* emailSyntaxList
	*
	* @return array
	*/
	public static function emailPatternList() 
	{

		/* emailSyntaxList you wish to crawl through */
		$emailSyntaxList = config::PATTERN_LIST;
		/* return emailSyntaxList */
		return $emailSyntaxList;

	}

	/**
	* Elements to crawl through
	*
	* @return array
	*/
	public static function elements() 
	{

		/* elements you wish to crawl through */
		$elements = config::ELEMENT_LIST;
		/* return elements */
		return $elements;

	}

	/**
	* Menu elements
	*
	* @return array
	*/
	public static function menuElements() 
	{

		/* menuElements you wish to crawl through */
		$menuElements = config::MENU_ELEMENT_LIST;
		/* return menuElements */
		return $menuElements;

	}


	/**
	* clean url (add http in front)
	*
	* @param $url
	* @return string
	*/
	public static function clean_url($url) 
	{

		if (preg_match('/^https/', $url)) 
		{
          $url_prefix = 'https://';
        } else {
          $url_prefix = 'http://';
        }

        $url = str_replace(array('http://','https://'), '', $url);

        return $url;

	}

	/**
	* Test a remote site before crawling
	*
	* @param $url
	* @return boolean
	*/
	public static function test_url($url) 
	{

		$timeout = 10;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );

		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

		$http_respond = curl_exec($ch);

		$http_respond = trim(strip_tags($http_respond));

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if(self::header_matches($http_code) == true)
		{
			return true;
		} else {
			return false;
		}

		curl_close( $ch );

	}

	/**
	* check if $input_header_code matches with any codes in header_codes array
	*
	* @param $input_header_code
	* @return boolean
	*/
	public static function header_matches($input_header_code) 
	{

		$header_codes = array(
			'200',
			'302'
		);

		foreach ($header_codes as $header_code) 
		{
			if (strpos($input_header_code, $header_code) !== FALSE) 
			{
				return true;
			}
		}

		return false;

	}

	/**
	* Validate website
	*
	* @param $url
	* @return boolean
	*/
	public static function validate_url($url) 
	{

		if(filter_var($url, FILTER_VALIDATE_URL)) 
		{
			return true;
		} else {
			return false;
		}

	}

	/**
	* Validate email
	*
	* @param $email_address
	* @return boolean
	*/
	public static function validate_email($email_address) 
	{

		if(filter_var($email_address, FILTER_VALIDATE_EMAIL)) 
		{
			return true;
		} else {
			return false;
		}

	}

	/**
	* remove empty array
	*
	* @param $email_address
	* @return boolean
	*/
	public static function remove_empty($array) 
	{
		return array_filter($array, '_remove_empty_internal');
	}

	public static function _remove_empty_internal($value) 
	{
		return !empty($value) || $value === 0;
	}

	/**
	* set useragent
	*
	* @param $useragent
	*/
	public static function set_useragent($useragent)
	{
		ini_set('user_agent', $useragent);
	}

}