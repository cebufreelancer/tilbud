<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 */
class Model_Email extends ORM {
	
	protected $_table_name = 'mail_templates';
	protected $_primary_key = 'ID';
	protected $_primary_val = 'ID';
	
	protected $_table_columns = array(
		'ID'		=> array('data_type' => 'int'),
		'name'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'text'	=> array('data_type' => 'string', 'is_nullable' => TRUE),
		'subject' => array('data_type' => 'string', 'is_nullable' => TRUE),
		);

	public function template_deals($deals)
	{
		// 2 = Deal Template
		$emails = ORM::factory('email', 2);
		// Load Variables
		$DEAL 					= html_entity_decode($deals->description);
		$EMAILFORMATURL = HTML::anchor(Url::base(TRUE) . 'deals/email_format/'.$deals->ID, 'klik her');
		$BGHEADER				= url::base(TRUE) . 'images/bg-header.png';
		$LOGO						= HTML::Image(Url::base(TRUE).'images/logo.png');
		$FACEBOOK				= HTML::Image(Url::base(TRUE).'images/facebook-like.png');
		
		$DEALTITLE			= $deals->title;
		$DEALURL				= HTML::anchor(Url::base(TRUE) . 'deals/view/' . $deals->ID, 
											HTML::Image(Url::base(TRUE) . 'images/ordernow.png', array('alt' => 'Order Now',
																																								 'style' => 'margin-bottom: 20px;')));
		$DEALREGPRICE		= $deals->regular_price;
		$DEALPRICE			= ($deals->regular_price * (100 - $deals->discount)) / 100;
		$DEALCLASS			= strlen($DEALPRICE) > 5 ? ' font-size: 45px;' : '';
		$DEALDISCOUNT		= $deals->discount;
		$DEALSAVINGS		= $deals->regular_price - $DEALPRICE;
		$DEALINFO				= html_entity_decode($deals->information);
		$DEALIMAGE			= HTML::Image(Url::base(TRUE) . 'uploads/' . $deals->ID . '/' . rawurlencode($deals->image), 
													array('width' => 445, 
																'height' => 300, 
																'style' => 'margin-bottom: 20px;'));
		$DEALCONTENTS 	= $deals->contents;
		$SEE_VIDEO_DEALS = mb_convert_encoding("Se dagens tilbud på video - klik her.", "ISO-8859-1", "UTF-8");
		
		$LOCATION				= $deals->addresses;
		
		$body = addslashes($emails->text);
		eval("\$text=\"$body\";");
		
		return html_entity_decode($text);
	}
	
} // End of Mail Model
