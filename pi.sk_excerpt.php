<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SK Excerpt - ExpressionEngine Plugin 
 *
 * @package			SK Excerpt
 * @version			1.1.0
 * @author			Jean-Francois Paradis - https://github.com/skaimauve
 * @copyright 	Copyright (c) 2012 Jean-Francois Paradis
 * @license 		MIT License - please see LICENSE file included with this distribution
 * @link			  http://github.com/skaimauve/excerpt
 *
 */

$plugin_info = array(
	'pi_name'			   => 'sk_excerpt',
	'pi_version'		 => '1.1.0',
	'pi_author'			 => 'Jean-Francois Paradis',
	'pi_description' => 'Displays an automatic excerpt of the given text with [...] at the end',
	'pi_usage'			 => 'http://github.com/skaimauve/excerpt'
);

class Sk_excerpt {

	const default_word_count = 50;
	const default_char_count = 200;

	const threshold_char_per_word = 10;

	const default_more = '&nbsp;[&hellip;]';

	public $return_data;

	protected $EE;
	
	// --------------------------------------------------------------------

	public function __construct() 
	{

		$this->EE =& get_instance();

		// Parameters

		$chars = $this->EE->TMPL->fetch_param('chars');
		$words = $this->EE->TMPL->fetch_param('words');
		$more = $this->EE->TMPL->fetch_param('more');
		
		// Processing & return early

		if (!empty($chars) && empty($words)) return $this->return_data = $this->trim_chars( $this->EE->TMPL->tagdata, $chars, $more );
		if (!empty($words) && empty($chars)) return $this->return_data = $this->trim_words( $this->EE->TMPL->tagdata, $words, $more );
		
		// Defaults to count
				
		return $this->return_data = $this->trim_count( $this->EE->TMPL->tagdata, $chars, $words, $more );
		
	}

	// --------------------------------------------------------------------

	/**
	 * trim_char
	 *
	 * Trims text to a certain number of characters, cut around words (multibyte aware).
	 */
	
	public function trim_chars($text, $char_count, $more) 
	{
		if (!($char_count > 0)) $char_count = self::default_char_count;
		if (empty($more)) $more = self::default_more;
	
		// Remove HTML and line breaks.
		$text = $this->strip_tags( $text, true );

		// Find the next position of a space.
		$pos =	mb_strpos($text,' ', $char_count);

    // Set a default
		if ($pos == 0) {
  		$pos = $char_count;
		}

		// Do we need to cut?
		if ($pos < mb_strlen($text)) {
			$text = mb_substr($text, 0, $pos) . $more;
		}

		return $text;
	}

	// --------------------------------------------------------------------

	/**
	 * trim_words
	 *
	 * Trims text to a certain number of words.
	 */
	
	public function trim_words($text, $word_count, $more) 
	{
		if (!($word_count > 0)) $word_count = self::default_word_count;
		if (empty($more)) $more = self::default_more;
	
		// Remove HTML and line breaks.
		$text = $this->strip_tags( $text, true );

		// Find the position of the nth occurence of a space.
		$pos = $this->mb_strnpos($text, ' ', $word_count);
		
		// Do we need to cut?
		if ($pos > 0 && $pos < mb_strlen($text)) {
  		$text = mb_substr($text, 0, $pos) . $more;
    }

		return $text;
	}

	// --------------------------------------------------------------------

	/**
	 * trim_count
	 *
	 * Trims text to a certain number of words, switch to characters if 
	 * more average than a number of characters per word.
	 */
	
	public function trim_count($text, $char_count, $word_count, $more) 
	{
		if (!($char_count > 0)) $char_count = self::default_char_count;
		if (!($word_count > 0)) $word_count = self::default_word_count;
		if (empty($more)) $more = self::default_more;
	
		// Remove HTML and line breaks.
		$text = $this->strip_tags( $text, true );

		// Find the position of the nth occurence of a space.
		$pos = $this->mb_strnpos($text, ' ', $word_count);

		// Are the words too long?
		if ($pos/$count > self::threshold_char_per_word ) {
		  // Re-cut using characters
  		$pos =	mb_strpos($text,' ', $char_count);
		}

    // Set a default
		if ($pos == 0) {
  		$pos = $char_count;
		}

		// Do we need to cut?
		if ($pos < mb_strlen($text)) {
  		$text = mb_substr($text, 0, $pos) . $more;
   }

		return $text;
	}

	// --------------------------------------------------------------------

	/**
	 * strip_tags
	 *
	 * Properly strip all HTML tags including script and style.
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

	// --------------------------------------------------------------------

	/**
	 * strnpos
	 *
	 * Find the position of nth needle in haystack.
	 */

  public function mb_strnpos($haystack, $needle, $occurrence, $pos = 0) {

      while ($occurrence > 0) {
        $pos = mb_strpos($haystack, $needle, $pos);
        $occurrence--;
        if ($occurrence > 0) $pos++;
      }

      return $pos;
  }
}
// END CLASS

/* End of File: pi.sk_excerpt.php */
/* Location: ./system/expressionengine/third_party/sk_excerpt/pi.sk_excerpt.php */
