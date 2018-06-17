<?php
$title = __('Exhibits');
echo head(array('title' => $title, 'bodyclass' => 'exhibits browse'));
?>
<div id="primary">
<h1><?php echo $title; ?></h1>
<p class='exhibit-intro'>Exhibits are themed presentations of items in the Digital Archive. The exhibit presented here is an online version of the Southwest Harbor Then & Now Exhibit presented at the library in July 2015. Our hope is to add other recent summer exhibits such as Visions of Acadia National Park 2016, and to create other exhibits that tell some of the wonderful stories in the collection.</p>

<?php if (count($exhibits) > 0): ?>

<?php echo pagination_links(); ?>

<?php $exhibitCount = 0; ?>

<?php foreach (loop('exhibit') as $exhibit): ?>
    <?php $exhibitCount++; ?>

    <div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">

        <h2><?php echo link_to_exhibit(); ?></h2>

        <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
        	<div class="description">
        		<?php echo $exhibitDescription; ?>
        	</div>
        <?php endif; ?>

        <?php if ($exhibitTags = tag_string('exhibit', 'exhibits')): ?>
        	<p class="tags"><?php echo $exhibitTags; ?></p>
        <?php endif; ?>

    </div>
<?php endforeach; ?>

<?php echo pagination_links(); ?>

<?php else: ?>
<p><?php echo __('There are no exhibits available yet.'); ?></p>
<?php endif; ?>
</div>

<?php echo foot(); ?>