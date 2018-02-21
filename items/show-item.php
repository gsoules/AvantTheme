<?php

$type = Custom::getItemBaseType($item);
$class = empty($type) ? '' : " class=\"$type\"";
echo '<h1' . $class . '>' . metadata($item, array('Dublin Core', 'Title'), array('no_filter' => true)) . '</h1>';

$viewerScript = '';
$zoomingEnabled = count($zoomDataSources) >= 1;
if ($zoomingEnabled)
{
    $viewerScript = Custom::emitZoomScript($identifier, $zoomDataSources);
    echo '<div id="openseadragon"></div>';
}?>

<div id="primary">
    <?php

    $itemFiles = $item->Files;
    if (count($itemFiles) > 0)
    {
        echo '<div id="item-files" class="element">';
        $imageHtml = file_markup($itemFiles[0], array('imageSize' => 'fullsize', 'linkAttributes' => array('target' => '_blank')));
        echo "<div class='element-text'>$imageHtml</div>";
        echo '</div>';
    }

    if ($zoomingEnabled)
    {
        echo '<div id="zoom-button-bar">';
        echo '<a id="zoom-button" href="#"></a>';
        echo '</div>';
    }

    echo all_element_texts($item);

    // If this item has a cover image, that image will appear in the sidebar, so pass it to
    // admin_items_show to indicate that the image should be excluded from the list of related items.
    $excludeItem = ItemView::getCoverImageItem($item);
    echo get_specific_plugin_hook_output('AvantCustom', 'admin_items_show', array('view' => $this, 'item' => $item, 'exclude' => $excludeItem));
    echo get_specific_plugin_hook_output('AvantRelationships', 'public_items_show', array('view' => $this, 'item' => $item, 'exclude' => $excludeItem));
    ?>
</div>

<div id="secondary">
    <?php
        $coverImageItem = ItemView::getCoverImageItem($item);
        if (!empty($coverImageItem)) {
            ?>
            <div class="item-preview cover-image">
                <?php
                $itemView = new ItemView($coverImageItem);
                echo $itemView->emitItemPreview($coverImageItem);
                ?>
            </div>
    <?php } ?>

    <!-- The following returns all of the files associated with an item. -->
    <div id="itemfiles" class="element">
        <?php
        $itemFiles = get_current_record('item')->Files;
        if ($itemFiles) {
            // Show all but the first file in the secondary area.
            unset($itemFiles[0]);
        }
        $imageHtml = file_markup($itemFiles, array('imageSize' => 'fullsize', 'linkAttributes' => array('target' => '_blank')));
        ?>
        <?php if ($itemFiles): ?>
            <div class="element-text"><?php echo $imageHtml; ?></div>
        <?php endif; ?>
    </div>

    <?php echo get_specific_plugin_hook_output('AvantRelationships', 'show_relationships_visualization', array('view' => $this, 'item' => $item)); ?>
    <?php echo get_specific_plugin_hook_output('Geolocation', 'public_items_show', array('view' => $this, 'item' => $item)); ?>

    <!-- The following prints a list of all tags associated with the item -->
    <?php if (metadata($item, 'has tags')): ?>
        <div id="item-tags" class="element">
            <h2>Tags</h2>
            <div class="element-text tags"><?php echo tag_string('item', 'find'); ?></div>
        </div>
    <?php endif; ?>

    <!-- The following prints a citation for this item. -->
    <div id="item-citation" class="element">
        <h2>Citation</h2>
        <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
    </div>

    <?php
    if (is_allowed($item, 'edit')) {
        echo 'Admin: ';
        echo '<a href="' . admin_url('/items/edit/' . $item->id) . '">Edit</a>';
        echo ' | ';
        echo '<a href="' . admin_url('/items/show/' . $item->id) . '">Show</a>';
    }
    ?>
</div>

<?php if ($zoomingEnabled): ?>
    <script type="text/javascript">
        jQuery(document).ready(function ()
        {
            <?php echo $viewerScript; ?>

            // Style the zoom navigator dynamically to override its hard-coded element styles.
            var zoomNavigator = jQuery('.navigator');
            zoomNavigator.css({'background-color': 'transparent'});
            zoomNavigator.css({'border-width': '1px'});

            // Override h1 styling when on a page having a zoomable image.
            jQuery('h1').css({'margin-bottom': '4px'});

            var zoomButton = jQuery('#zoom-button');
            var zoomViewerContainer = jQuery('#openseadragon');
            var itemFile = jQuery('#item-files');
            var itemFiles = jQuery('#itemfiles');

            // Don't initially show the zoomable image on mobile devices where users may want to
            // scroll the page, but do so while touching the zoom viewer which only pans the image.
            var isMobile = /Mobi/i.test(navigator.userAgent) || /Android/i.test(navigator.userAgent);
            var showingzoomViewer = !isMobile;

            var buttonTextHide = '<?php echo __('Turn Image Zoom Off'); ?>';
            var buttonTextShow= '<?php echo __('Turn Image Zoom On'); ?>';

            if (showingzoomViewer)
            {
                zoomButton.text(buttonTextHide);
                itemFile.hide();
                itemFiles.hide();
            }
            else
            {
                zoomButton.text(buttonTextShow);
                zoomViewerContainer.hide();
            }

            zoomButton.click(function(e)
            {
                e.preventDefault();
                showingzoomViewer = !showingzoomViewer;
                zoomViewerContainer.toggle();
                itemFile.toggle();
                itemFiles.toggle();
                zoomButton.text(showingzoomViewer ? buttonTextHide : buttonTextShow);
            });
        });
    </script>
<?php endif; ?>

