<?php

/**
 * Email Crawler class
 *
 *
 * PHP version 7
 *
 *
 * @category   config
 * @package    config
 * @author     Marcos Raudkett <info@marcosraudkett.com>
 * @copyright  2019 Marcos Raudkett
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @version    1.0.1
 */

class config
{

	const 

		/* pattern list for finding emails in plaintext */
		PATTERN_LIST = array(
			'/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
			'/[a-z0-9_\-\+\.]+(at)[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
			'/[a-z0-9_\-\+\.]+( at )[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
			'/[a-z0-9_\-\+\.]+%at%[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i',
			'/[a-z0-9_\-\+\.]+%(at)%[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i',
			'/[a-z0-9_\-\+\.]+(ät)[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i'
		),

		/* syntax list */
		SYNTAX_LIST = array(
			'@', 
			'(at)', 
			'( at )', 
			'%at%',
			'%(at)%',
			'(ät)',
			'&#28450;',
			'&#23383;'
		),

		/* element list that you wish to crawl through */
		ELEMENT_LIST = array(
			'a', 
			'p', 
			'b',
			'div',
			'span'
		),

		/* menu elements for deep crawling */
		MENU_ELEMENT_LIST = array(
			'li a'
		)
		
	;

}


?>