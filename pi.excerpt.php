<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Excerpt - ExpressionEngine Plugin 
 *
 * @package			Excerpt
 * @version			1.0.0
 * @author			Jean-Francois Paradis - https://github.com/skaimauve
 * @copyright 		Copyright (c) 2012 Jean-Francois Paradis
 * @license 		MIT License - please see LICENSE file included with this distribution
 * @link			http://github.com/skaimauve/excerpt
 *
 * This plugin provides a similar functionality to the function the_excerpt() in Wordpress which
 * allows developers to display a post summary based on the number of words. This implementation
 * can also display a post summary based on a minimum number of characters (in that case, the
 * cut will be done at the next word boundary), which works better with languages like Chinese 
 * for which the concept of words are different. An ellipsis ([...] by default) is added at the
 * end of the excerpt.
 * 
 * Setup:
 * Download the "excerpt" folder and upload it to the third party directory of your ExpressionEngine folder.
 *
 * Usage:
 * {exp:excerpt chars=true}{content}{/exp:excerpt}   Use the default 200 characters
 * {exp:excerpt chars='500'}{content}{/exp:excerpt}  Use 500 characters
 *
 * {exp:excerpt words=true}{content}{/exp:excerpt}   Use the default 50 words
 * {exp:excerpt words='55'}{content}{/exp:excerpt}   Use 55 words
 *
 * {exp:excerpt words='55' more='...'}{content}{/exp:excerpt}   Also change the ellipsis to '...'
 *
 * Changelog:
 * 1.0.0 - Initial plugin
 */

$plugin_info = array(
	'pi_name'			=> 'Excerpt',
	'pi_version'		=> '1.0.0',
	'pi_description'	=> 'Displays an automatic excerpt of the given text with [...] at the end',
);

class Excerpt {

	const default_word_count = 50;
	const default_char_count = 200;

	const default_more = '&nbsp;[&hellip;]';

	public $return_data;

	protected $EE;
	
	// --------------------------------------------------------------------

	public function __construct() 
	{

		$this->EE =& get_instance();

		$chars = $this->EE->TMPL->fetch_param('chars');
		$words = $this->EE->TMPL->fetch_param('words');
		$more = $this->EE->TMPL->fetch_param('more');

		if ($chars) $this->return_data = $this->trim_chars( $this->EE->TMPL->tagdata, $chars, $more );
		if ($words) $this->return_data = $this->trim_words( $this->EE->TMPL->tagdata, $words, $more );
		if (!$chars & !$words) $this->return_data = $this->EE->TMPL->tagdata;
		
		return $this->return_data;
	}

	// --------------------------------------------------------------------

	/**
	 * trim_char
	 *
	 * Trims text to a certain number of characters, cut around words (multibyte aware)
	 */
	
	public function trim_chars($text, $char_count, $more) 
	{
		if (!($char_count > 0)) $char_count = self::default_char_count;
		if (empty($more)) $more = self::default_more;
	
		$text = $this->strip_tags( $text );

		if ( mb_strlen($text) > $char_count ) {
			
			$text = mb_substr($text, 0, $char_count) . preg_replace('/^([^\n\r\t ]*).*$/','$1',mb_substr($text, $char_count)) . $more;
		}

		return $text;
	}

	// --------------------------------------------------------------------

	/**
	 * _trim_words
	 *
	 * Trims text to a certain number of words.
	 */
	
	public function trim_words($text, $word_count, $more) 
	{
		if (!($word_count > 0)) $word_count = self::default_word_count;
		if (empty($more)) $more = self::default_more;
	
		$text = $this->strip_tags( $text );

		$words_array = preg_split( '/[\n\r\t ]+/', $text, $word_count + 1, PREG_SPLIT_NO_EMPTY );

		if ( count( $words_array ) > $word_count ) {
			array_pop( $words_array );
			$text = implode( ' ', $words_array ) . $more;
		} else {
			$text = implode( ' ', $words_array );
		}

		return $text;
	}

	// --------------------------------------------------------------------

	/**
	 * strip_tags
	 *
	 * Properly strip all HTML tags including script and style
	 */

	public function strip_tags($text, $remove_breaks = false) {

		// Strip script and style 
		$text = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $text );

		// Strip HTML and PHP tags 
		$text = strip_tags($text);
	
		if ( $remove_breaks )
		{
			// Collapse breaks into a single space 
			$text = preg_replace('/[\r\n\t ]+/', ' ', $text);
		}
	
		return trim($text);
	}
}

/* End of File: pi.summary.php */
