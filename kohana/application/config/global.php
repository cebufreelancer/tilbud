<?php defined('SYSPATH') or die('No direct access allowed.');
$tcities = ORM::factory('city')->find_all();

foreach($tcities as $city) {
	$cities[$city->ID] = $city->name;
}

return array(
	'cities'       => $cities,
);
