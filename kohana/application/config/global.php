<?php defined('SYSPATH') or die('No direct access allowed.');
$tcities = ORM::factory('city')->find_all();
foreach($tcities as $city) {
	$cities[$city->ID] = $city->name;
}

$tcategories = ORM::factory('category')->find_all();
foreach($tcategories as $cat) {
	$categories[$cat->ID] = $cat->name;
}

return array(
	'cities'      => $cities,
	'categories'	=> $categories,
);
