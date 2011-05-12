<?php defined('SYSPATH') or die('No direct script access.');

return array(
      'cardnumber' => array(
         'credit_card' => __(INVALID_CARDNUMBER),
				 'not_empty'	=> __(REQUIRED_FIELD),
       ),
      'cardtype' => array(
         'in_array' => __(INVALID_CARDTYPE),
       ),
      'cardname' => array(
				 'not_empty' => __(REQUIRED_FIELD),
				 'regex' => __(INVALID_CARDNAME),
       ),
      'cardcode' => array(
         'not_empty'  => __(REQUIRED_FIELD),
				 'exact_length' => __(INVALID_CARDCODE),
      ),
      'zipcode' => array(
         'not_empty' => __(REQUIRED_FIELD),
				 'range' => __(INVALID_ZIPCODE),
      ),
);

