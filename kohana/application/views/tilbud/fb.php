<h1><a href=""><?php echo $deal->title ?></a></h1>
<h1><?php echo substr(html_entity_decode(strip_tags($deal->description)), 0, 200); ?></h1>

<img src="<?php echo URL::base(TRUE); ?>uploads/<?php echo "$deal->ID/$deal->image"; ?>" >
Rabat <?php echo number_format($deal->discount, 0, '.', ''); ?>%
<?= LBL_SPAR ?> <?php echo number_format($deal->discount, 0, '.', ''); ?>%