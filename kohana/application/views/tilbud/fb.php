<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta CONTENT="text/html; charset=ISO-8859-1"/>
  <title><?php echo $deal->description ?></title>
	<link rel="stylesheet" media="all" href="<?php echo url::base(TRUE)?>css/main.css"/>
	<meta name="viewport" content="width=device-width; initial-scale=1"/>
	<script>
	  function redirectPage() {
	    var t = setTimeout("location.replace('<?php echo url::base(true) . "deals/view/" . $deal->ID; ?>')", 4000);
	  }
	  
	</script>
</head>
<body onload="redirectPage()">

<div>
  <a href="http://www.tilbudibyen.com">
    <img src="<?php echo URL::base(TRUE); ?>uploads/<?php echo "$deal->ID/$deal->image"; ?>" >
  </a>
</div>


<a href=""><h1><?php echo $deal->title ?></h1></a>
<p><?php echo substr(html_entity_decode(strip_tags($deal->description)), 0, 200); ?></p>


Rabat <?php echo number_format($deal->discount, 0, '.', ''); ?>%
<?= LBL_SPAR ?> <?php echo number_format($deal->discount, 0, '.', ''); ?>%

  
</body>
</html>
