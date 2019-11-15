<?php

/**
 * Email Crawler class
 * 
 *
 * PHP version 5.4 - 7
 *
 *
 * @category   config
 * @package    config
 * @author     Marcos Raudkett <info@marcosraudkett.com>
 * @copyright  2019 Marcos Raudkett
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @version    1.0.2
 */

class config
{
	
	/* update the simple_html_dom if your not using autoloader */
	const
		SIMPLE_HTML_DOM_DIRECTORY = '../vendor/simple_html_dom/simple_html_dom.php'
	;

	private static $PATTERN_LIST = array(
		'/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i', 
		'/[\._a-zA-Z0-9-]+\(at\)[\._a-zA-Z0-9-]+/i', 
		'/[a-z0-9_\-\+\.]+[[:blank:]]\(at\)[[:blank:]]+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+[[:blank:]]@[[:blank:]]+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+@[[:blank:]]+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+[[:blank:]]@+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+[[:blank:]]\([[:blank:]]at[[:blank:]]\)[[:blank:]]+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+[[:blank:]]\([[:blank:]]@[[:blank:]]\)[[:blank:]]+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\([[:blank:]]at[[:blank:]]\)+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\([[:blank:]]@[[:blank:]]\)+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\([[:blank:]]at\)+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\([[:blank:]]@\)+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\(at[[:blank:]]\)+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\(@[[:blank:]]\)+[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\(at\)[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i', 
		'/[a-z0-9_\-\+\.]+\%at\%[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i',
		'/[a-z0-9_\-\+\.]+\%@\%[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i',
		'/[a-z0-9_\-\+\.]+\%\(at\)\%[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i',
		'/[a-z0-9_\-\+\.]+\(ät\)[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i'
	);
	
	private static $SYNTAX_LIST = array(
		'@',  
		'(at)', 
		' (at) ', 
		'%20(at)%20', 
		'%at%',
		'%(at)%',
		'(ät)',
		'&#28450;',
		'&#23383;'
	);

	private static $ELEMENT_LIST = array(
		'a', 
		'p', 
		'b',
		'div',
		'span'
	);

	private static $MENU_ELEMENT_LIST = array(
		'li a',
		'a',
		'li'
	);

	public static function PATTERN_LIST(){
	    return self::$PATTERN_LIST;
	}

	public static function SYNTAX_LIST(){
	    return self::$SYNTAX_LIST;
	}

	public static function ELEMENT_LIST(){
	    return self::$ELEMENT_LIST;
	}

	public static function MENU_ELEMENT_LIST(){
	    return self::$MENU_ELEMENT_LIST;
	}

}


?>
