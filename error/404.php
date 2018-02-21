<?php
$pageTitle = __('Page Not Found');
echo head(array('title'=>$pageTitle));
?>
<h1><?php echo $pageTitle; ?></h1>
<p><?php echo __('%s', html_escape($badUri)); ?></p>
<?php echo foot(); ?>
