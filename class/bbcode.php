<?php
/**
 * BBcode helper class
 *
 * @package    BBcode
 * @category   Helper
 * @author     Chema <chema@garridodiaz.com>
 * @copyright  (c) 2012
 * @license    GPL v3
 */
class bbcode {
	/**
	 *
	 * This function parses BBcode tag to HTML code (XHTML transitional 1.0)
	 *
	 * It parses (only if it is in valid format e.g. an email must to be
	 * as example@example.ext or similar) the text with BBcode and
	 * translates in the relative html code.
	 *
	 * @param string $text
	 * @param boolean $advanced his var describes if the parser run in advanced mode (only *simple* bbcode is parsed).
	 * @return string
	 */
	public static function tohtml($text,$advanced=FALSE,$charset='UTF-8'){
		//special chars
		$text  = htmlspecialchars($text, ENT_QUOTES,$charset);
		/**
		 * This array contains the main static bbcode
		 * @var array $basic_bbcode
		 */
		$basic_bbcode = array(
								'[b]', '[/b]',
								'[i]', '[/i]',
								'[u]', '[/u]',
								'[s]','[/s]',
								'[ul]','[/ul]',
								'[li]', '[/li]',
								'[ol]', '[/ol]',
								'[center]', '[/center]',
								'[left]', '[/left]',
								'[right]', '[/right]',
		);
		/**
		 * This array contains the main static bbcode's html
		 * @var array $basic_html
		 */
		$basic_html = array(
								'<b>', '</b>',
								'<i>', '</i>',
								'<u>', '</u>',
								'<s>', '</s>',
								'<ul>','</ul>',
								'<li>','</li>',
								'<ol>','</ol>',
								'<div style="text-align: center;">', '</div>',
								'<div style="text-align: left;">',   '</div>',
								'<div style="text-align: right;">',  '</div>',
		);
		/**
		 *
		 * Parses basic bbcode, used str_replace since seems to be the fastest
		 */
		$text = str_replace($basic_bbcode, $basic_html, $text);
		//advanced BBCODE
		if ($advanced)
		{
			/**
			 * This array contains the advanced static bbcode
			 * @var array $advanced_bbcode
			 */
			$advanced_bbcode = array(
									 '#\[color=([a-zA-Z]*|\#?[0-9a-fA-F]{6})](.+)\[/color\]#Usi',
									 '#\[size=([0-9][0-9]?)](.+)\[/size\]#Usi',
									 '#\[quote](\r\n)?(.+?)\[/quote]#si',
									 '#\[quote=(.*?)](\r\n)?(.+?)\[/quote]#si',
									 '#\[url](.+)\[/url]#Usi',
									 '#\[url=(.+)](.+)\[/url\]#Usi',
									 '#\[email]([\w\.\-]+@[a-zA-Z0-9\-]+\.?[a-zA-Z0-9\-]*\.\w{1,4})\[/email]#Usi',
									 '#\[email=([\w\.\-]+@[a-zA-Z0-9\-]+\.?[a-zA-Z0-9\-]*\.\w{1,4})](.+)\[/email]#Usi',
									 '#\[img](.+)\[/img]#Usi',
									 '#\[img=(.+)](.+)\[/img]#Usi',
									 '#\[code](\r\n)?(.+?)(\r\n)?\[/code]#si',
									 '#\[youtube]http://[a-z]{0,3}.youtube.com/watch\?v=([0-9a-zA-Z]{1,11})\[/youtube]#Usi',
									 '#\[youtube]([0-9a-zA-Z]{1,11})\[/youtube]#Usi'
			);
			/**
			 * This array contains the advanced static bbcode's html
			 * @var array $advanced_html
			 */
			$advanced_html = array(
									 '<span style="color: $1">$2</span>',
									 '<span style="font-size: $1px">$2</span>',
									 "<div class=\"quote\"><span class=\"quoteby\">Disse:</span>\r\n$2</div>",
									 "<div class=\"quote\"><span class=\"quoteby\">Disse <b>$1</b>:</span>\r\n$3</div>",
									 '<a rel="nofollow" target="_blank" href="$1">$1</a>',
									 '<a rel="nofollow" target="_blank" href="$1">$2</a>',
									 '<a href="mailto: $1">$1</a>',
									 '<a href="mailto: $1">$2</a>',
									 '<img src="$1" alt="$1" />',
									 '<img src="$1" alt="$2" />',
									 '<div class="code">$2</div>',
									 '<object type="application/x-shockwave-flash" style="width: 450px; height: 366px;" data="http://www.youtube.com/v/$1"><param name="movie" value="http://www.youtube.com/v/$1" /><param name="wmode" value="transparent" /></object>',
									 '<object type="application/x-shockwave-flash" style="width: 450px; height: 366px;" data="http://www.youtube.com/v/$1"><param name="movie" value="http://www.youtube.com/v/$1" /><param name="wmode" value="transparent" /></object>'
			);
			$text = preg_replace($advanced_bbcode, $advanced_html,$text);
		}
		//before return convert line breaks to HTML
		return bbcode::nl2br($text);
	}
	/**
	 *
	 * removes bbcode from text
	 * @param string $text
	 * @return string text cleaned
	 */
	public static function remove($text)
	{
		return strip_tags(str_replace(array('[',']'), array('<','>'), $text));
	}
	/**
	 *
	 * Inserts HTML line breaks before all newlines in a string
	 * @param string $var
	 */
	public static function nl2br($var)
	{
		return str_replace(array('\\r\\n','\r\\n','r\\n','\r\n', '\n', '\r'), '<br />', nl2br($var));
	}
}

function bbcode_to_html($bbtext){
	$bbtags = array(
			'[heading1]' => '<h1>','[/heading1]' => '</h1>',
			'[heading2]' => '<h2>','[/heading2]' => '</h2>',
			'[heading3]' => '<h3>','[/heading3]' => '</h3>',
			'[h1]' => '<h1>','[/h1]' => '</h1>',
			'[h2]' => '<h2>','[/h2]' => '</h2>',
			'[h3]' => '<h3>','[/h3]' => '</h3>',

			'[paragraph]' => '<p>','[/paragraph]' => '</p>',
			'[para]' => '<p>','[/para]' => '</p>',
			'[p]' => '<p>','[/p]' => '</p>',
			'[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
			'[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
			'[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
			'[justify]' => '<p style="text-align:justify;">','[/justify]' => '</p>',

			'[bold]' => '<span style="font-weight:bold;">','[/bold]' => '</span>',
			'[italic]' => '<span style="font-weight:bold;">','[/italic]' => '</span>',
			'[underline]' => '<span style="text-decoration:underline;">','[/underline]' => '</span>',
			'[b]' => '<span style="font-weight:bold;">','[/b]' => '</span>',
			'[i]' => '<span style="font-weight:bold;">','[/i]' => '</span>',
			'[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
			'[break]' => '<br>',
			'[br]' => '<br>',
			'[newline]' => '<br>',
			'[nl]' => '<br>',

			'[unordered_list]' => '<ul>','[/unordered_list]' => '</ul>',
			'[list]' => '<ul>','[/list]' => '</ul>',
			'[ul]' => '<ul>','[/ul]' => '</ul>',

			'[ordered_list]' => '<ol>','[/ordered_list]' => '</ol>',
			'[ol]' => '<ol>','[/ol]' => '</ol>',
			'[list_item]' => '<li>','[/list_item]' => '</li>',
			'[li]' => '<li>','[/li]' => '</li>',

			'[*]' => '<li>','[/*]' => '</li>',
			'[code]' => '<code>','[/code]' => '</code>',
			'[preformatted]' => '<pre>','[/preformatted]' => '</pre>',
			'[pre]' => '<pre>','[/pre]' => '</pre>',
	);

	$bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);

	$bbextended = array(
			"/\[url](.*?)\[\/url]/i" => "<a href=\"http://$1\" title=\"$1\">$1</a>",
			"/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href=\"$1\" title=\"$1\">$2</a>",
			"/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
			"/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
			"/\[img\]([^[]*)\[\/img\]/i" => "<img src=\"$1\" alt=\" \" />",
			"/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" />",
			"/\[image_left\]([^[]*)\[\/image_left\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_left\" />",
			"/\[image_right\]([^[]*)\[\/image_right\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_right\" />",
			"/\[color=(.*?)\](.*?)\[\/color\]/i" => "<span style=\"color: $1\">$2</span>",
	);

	foreach($bbextended as $match=>$replacement){
		$bbtext = preg_replace($match, $replacement, $bbtext);
	}
	return $bbtext;
}