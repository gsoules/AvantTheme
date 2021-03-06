<?php
echo head(array(
    'title' => metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title'),
    'bodyclass' => 'exhibits show'));
?>
<div id="exhibit-prev-next-buttons">
    <?php if ($prevLink = exhibit_builder_link_to_previous_page(' ')): ?>
    <div id="exhibit-nav-prev">
    <?php echo $prevLink; ?>
    </div>
    <?php endif; ?>
    <?php if ($nextLink = exhibit_builder_link_to_next_page(' ')): ?>
    <div id="exhibit-nav-next">
    <?php echo $nextLink; ?>
    </div>
    <?php endif; ?>
 </div>

<div id="primary">
    <h1><span class="exhibit-page"><?php echo metadata('exhibit_page', 'title'); ?></h1>
    <div id="exhibit-blocks">
        <?php exhibit_builder_render_exhibit_page(); ?>
    </div>
</div>

<div id="secondary">
    <h2><?php echo exhibit_builder_link_to_exhibit($exhibit); ?></h2>
    <nav id="exhibit-pages">
        <?php echo exhibit_builder_page_tree($exhibit, $exhibit_page); ?>
    </nav>
</div>

<div id="exhibit-prev-next-buttons">
    <?php if ($prevLink = exhibit_builder_link_to_previous_page(' ')): ?>
    <div id="exhibit-nav-prev">
    <?php echo $prevLink; ?>
    </div>
    <?php endif; ?>
    <?php if ($nextLink = exhibit_builder_link_to_next_page(' ')): ?>
    <div id="exhibit-nav-next">
    <?php echo $nextLink; ?>
    </div>
    <?php endif; ?>
</div>

<?php echo foot(); ?>
