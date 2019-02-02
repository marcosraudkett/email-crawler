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
 * @version    0.1.0
 */

class email_crawler
{

	/**
     * @var string
     */
	public $url;

	/**
	* Crawl a remote site
	*
	* @param $url
	* @param $unique (true or null)
	* @param $depth
	* @return array
	*/
	public static function crawl_site($url, $unique = null, $depth = null, $print_type = null) 
	{

		if(isset($url))
        { 
        	/* check url */
        	$clean_url = email_crawler::clean_url($url);
        	/* test url */
        	$test_url = email_crawler::test_url($clean_url);

        	if($test_url == true) 
        	{

        		/* list of elements to crawl */
        		$list_of_elements = email_crawler::elements();
        		/* foreach element */
        		foreach($list_of_elements as $element) 
        		{
        			/* crawl element */
    				$email = email_crawler::crawl_site_for_email($clean_url, $element);
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
	        				if($unique == true) { $list = implode(',', array_unique($list)); } else { $list = implode(',', $list); }
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
        			if($unique != true) 
					{
	        			/* return unique results */
	        			return array_unique($result);
	        		} else {
	        			/* return results */
	        			return $result;
	        		}
        		}

        	}

        }

	}

	/**
	* Look for an element
	*
	* @param $url
	* @return string
	*/
	public static function crawl_site_for_email($url, $element) 
	{

		/* crawl url */
		$get_html = file_get_html('http://'.$url);
		/* find all url elements */
		$find_element = $get_html->find($element);

		foreach($find_element as $this_element) 
    	{

    		if($this_element != 'a') 
    		{
    			/* if the element is not a link but plaintext */
    			$pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
    			/* match the element with pattern */
				preg_match_all($pattern, $this_element->plaintext, $matches);
				/* all matches (not unique) */
				$result = $matches[0];
				/* to string */
				$result = implode(' ', $result);
    		} else {
	    		/* make mailto: empty inside href */
	    		$result = str_replace('mailto:','', $this_element->href);
	    		/* clean out the parameters if it has any */
				$result = strtok($result, '?');
    		}

			/* validate if email */
			if(email_crawler::validate_email($result) == true)
			{
				/* return validated email */
				return $result;
			}

    	}

	}

	/**
	* Elements to crawl through
	*
	* @return array
	*/
	public static function elements() 
	{

		/* elements you wish to crawl through */
		$elements = array(
			'a', 
			'p', 
			'b',
			'div',
			'span'
		);

		return $elements;

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

		if(email_crawler::header_matches($http_code) == true)
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


}