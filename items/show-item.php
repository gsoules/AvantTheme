<?php
$viewerScript = plugin_is_active('AvantZoom') ? ImageZoom::generateOpenSeadragonViewer($item) : '';
$zoomingEnabled = !empty($viewerScript);

if ($zoomingEnabled)
{
    // This must be emitted before the call to the head() function below.
    queue_js_file('openseadragon.min');
}

$title = ItemMetadata::getItemTitle($item);
echo head(array('title' => $title, 'bodyclass' => 'items show'));

$type = '';
$itemType = ItemMetadata::getElementTextFromElementName($item, array('Dublin Core', 'Type'));
if ($itemType)
{
    // Get just the first part of a hierarchical type value e.g. just "Document" from "Document, Letter".
    $parts = explode(',', $itemType);
    $type = strtolower(trim($parts[0]));
}
$class = empty($type) ? '' : " class=\"$type\"";
echo '<h1' . $class . '>' . $title . '</h1>';

if ($zoomingEnabled)
{
    echo '<div id="openseadragon"></div>';
}
?>

<div id="primary">
    <?php
    $itemFiles = $item->Files;
    if (count($itemFiles) > 0)
    {
        echo '<div id="item-files" class="element">';
        $imageHtml = ItemPreview::getFileHtml($itemFiles[0], false);
        echo "<div class='element-text'>$imageHtml</div>";
        echo '</div>';
    }

    if ($zoomingEnabled)
    {
        echo '<div id="zoom-toggle">';
        echo '<a id="zoom-toggle-link" href="#"></a>';
        echo '</div>';
    }

    echo all_element_texts($item);

    // If this item has a cover image, that image will appear in the sidebar, so pass it to
    // admin_items_show to indicate that the image should be excluded from the list of related items.
    $excludeItem = ItemPreview::getCoverImageItem($item);
    echo get_specific_plugin_hook_output('AvantCustom', 'admin_items_show', array('view' => $this, 'item' => $item, 'exclude' => $excludeItem));
    echo get_specific_plugin_hook_output('AvantRelationships', 'public_items_show', array('view' => $this, 'item' => $item, 'exclude' => $excludeItem));
    ?>
</div>

<div id="secondary">
    <?php
        $coverImageItem = ItemPreview::getCoverImageItem($item);
        if (!empty($coverImageItem)) {
            ?>
            <div class="item-preview cover-image">
                <?php
                $itemPreview = new ItemPreview($coverImageItem);
                echo $itemPreview->emitItemPreview($coverImageItem);
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
        $imageHtml = '';
        foreach ($itemFiles as $itemFile)
        {
            $imageHtml .= ItemPreview::getFileHtml($itemFile, true);
        }
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

<?php
if ($zoomingEnabled)
{
    echo $this->partial('avantzoom-script.php', array('viewerScript' => $viewerScript));
}
?>

