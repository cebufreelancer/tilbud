<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cron_Deals extends Controller {

	public function action_index()
	{
		// Get Deals and Filter it out
		// Date Today > Deals End Date
		$expired_deals = ORM::factory('deal')->get_to_expire_deals();
		
		// Check if reached Minimum Sales
		foreach($expired_deals as $xdeal) {
			
			$end_date = date("Y-m-d"); // returns YYYY-MM-DD Format
			
			// Update Status to Expired	
			$deal = ORM::factory('deal', $xdeal['ID']);
			$deal->status = 'expired';
			
			$deal->save();
			
			// Email Users
			
		}
	}
	
} // End Welcome
