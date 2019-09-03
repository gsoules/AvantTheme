<?php
$viewerScript = plugin_is_active('AvantZoom') ? ImageZoom::generateOpenSeadragonViewer($item) : '';
$zoomingEnabled = !empty($viewerScript);

// Specify whether the Show page displays the cover image for a reference item. When enabled, and when the item has a
// cover image, the image displays at the top of the left-side panel along with the image's item number and that item's
// title, both of which can be clicked to go to the cover image's item. To prevent that same image from appearing twice
// on the page, the cover image is excluded from the Images section. While this seemed like a good feature, it has
// caused confusion among users who are interested in the cover image itself as opposed to the reference item. When
// referring to the image, they often use the reference item number and when referring to the reference item, use the
// cover image's item number. It's also confusing that the cover image does not appear in the Images section where
// people are used to clicking to see an item's images, whereas they don't tend to click the cover image or its links.
// For now, this feature is getting disabled to see if it's better to not display the cover image at upper left on the
// Show page and instead just display it as a thumbnail in the Images section.
$coverImageEnabledOnShowPage = true;

if ($zoomingEnabled)
{
    // This must be emitted before the call to the head() function below.
    queue_js_file('openseadragon.min');
}

$title = ItemMetadata::getItemTitle($item);
echo head(array('title' => $title, 'bodyclass' => 'items show'));

$type = '';
$itemType = ItemMetadata::getElementTextForElementName($item, 'Type');
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
    $file = count($itemFiles) > 0 ? $itemFiles[0] : null;

    // Get the HTML for the image that appears at the top of the Show page above the fields.
    $imageHtml = ItemPreview::getFileHtml($item, $file, false);

    if (strlen($imageHtml) > 0)
    {
        echo '<div id="item-files" class="element">';
        echo "<div class='element-text'>$imageHtml</div>";
        echo '</div>';
    }

    if ($zoomingEnabled)
    {
        echo '<div id="zoom-toggle">';
        echo '<a id="zoom-toggle-link" href="#"></a>';
        echo '</div>';
    }

    // Emit the item's fields.
    echo all_element_texts($item);

    // If this item has a cover image, that image will appear in the sidebar, so pass it to
    // admin_items_show to indicate that the image should be excluded from the list of related items.
    $excludeItem = $coverImageEnabledOnShowPage ? ItemPreview::getCoverImageItem($item) : null;
    echo get_specific_plugin_hook_output('AvantCustom', 'admin_items_show', array('view' => $this, 'item' => $item, 'exclude' => $excludeItem));
    echo get_specific_plugin_hook_output('AvantRelationships', 'public_items_show', array('view' => $this, 'item' => $item, 'exclude' => $excludeItem));
    ?>
</div>

<div id="secondary">
    <?php
        $coverImageItem = $coverImageEnabledOnShowPage ? ItemPreview::getCoverImageItem($item) : null;
        if (!empty($coverImageItem)) {
            ?>
            <div class="item-preview cover-image">
                <?php
                $itemPreview = new ItemPreview($coverImageItem);
                echo $itemPreview->emitItemPreview($coverImageItem);
                ?>
            </div>
    <?php } ?>

    <div id="itemfiles" class="element">
        <?php
        // Display thumbnails for additional files (when there is more than one) that are attached to this item.
        $itemFiles = get_current_record('item')->Files;
        if ($itemFiles)
        {
            // Remove the first file because it appears in the Primary section above the fields.
            unset($itemFiles[0]);
        }

        if ($itemFiles)
        {
            $imageCount = 0;
            $documentCount = 0;
            foreach ($itemFiles as $itemFile)
            {
                $isImage = substr($itemFile->mime_type, 0, 6) == 'image/';
                if ($isImage)
                {
                    $imageCount++;
                }
                else
                {
                    $documentCount++;
                }
            }

            $sectionContents = 'Images';
            if ($imageCount == 0)
            {
                $sectionContents = 'Documents';
            }
            else
            {
               if ($documentCount > 0)
               {
                   $sectionContents = 'Images and Documents';
               }
            }
            echo "<h2>Other $sectionContents</h2>";
        }

        $imageHtml = '';
        foreach ($itemFiles as $itemFile)
        {
            $showThumbnail = true;
            $imageHtml .= ItemPreview::getFileHtml($item, $itemFile, $showThumbnail);
        }
        ?>

        <?php if ($itemFiles): ?>
            <div class="element-text"><?php echo $imageHtml; ?></div>
        <?php endif; ?>
    </div>

    <?php
    if (is_allowed($item, 'edit')) {
        echo 'Admin: ';
        echo '<a href="' . admin_url('/items/edit/' . $item->id) . '" target="_blank">Edit</a>';
        echo ' | ';
        echo '<a href="' . admin_url('/items/show/' . $item->id) . '" target="_blank">View</a>';
    }
    ?>

    <?php echo get_specific_plugin_hook_output('AvantRelationships', 'show_relationships_visualization', array('view' => $this, 'item' => $item)); ?>
    <?php echo get_specific_plugin_hook_output('Geolocation', 'public_items_show', array('view' => $this, 'item' => $item)); ?>

    <?php if (metadata($item, 'has tags')): ?>
        <div id="item-tags" class="element">
            <h2>Tags</h2>
            <div class="element-text tags"><?php echo tag_string('item', 'find'); ?></div>
        </div>
    <?php endif; ?>

    <div id="item-citation" class="element">
        <h2>Citation</h2>
        <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
    </div>

    <div id="recently-viewed-items">
    <?php
    $cookieValue = isset($_COOKIE['ITEMS']) ? $_COOKIE['ITEMS'] : '';
    $recentItemIds = empty($cookieValue) ? array() : explode(',', $cookieValue);

    $showRecentItems = count($recentItemIds) >= 1;
    if ($showRecentItems && count($recentItemIds) == 1 && $recentItemIds[0] == $item->id)
    {
        // Don't show recent items if the only item is the one currently being shown.
        $showRecentItems = false;
    }

    if ($showRecentItems)
    {
        echo '<div id="recently-viewed-items">';
        echo "<div id='recently-viewed-items-title'>Recently Viewed Items</div>";
        $thisItemIdentifier = ItemMetadata::getItemIdentifier($item);

        $identifierList = $thisItemIdentifier;
        echo "<div class='recently-viewed-item'>$title</div>";
        $count = 1;

        foreach ($recentItemIds as $recentItemId)
        {
            if (intval($recentItemId) == 0)
            {
                // This should never happen, but check in case the cookie is somehow corrupted.
                continue;
            }

            $recentItem = ItemMetadata::getItemFromId($recentItemId);

            if (empty($recentItem))
            {
                // Ignore any items that no longer exist.
                continue;
            }

            $recentIdentifier = ItemMetadata::getItemIdentifier($recentItem);

            if ($recentIdentifier == $thisItemIdentifier)
            {
                // Skip the item currently being shown.
                continue;
            }

            $identifierList .= '|' . $recentIdentifier;
            $title = ItemMetadata::getItemTitle($recentItem);
            $itemUrl = public_url('/items/show/' . $recentItem->id);
            $toolTip = __('Item %s', $recentIdentifier);
            echo "<div id='recent-$recentItemId' class='recently-viewed-item' data-identifier='$recentIdentifier'><a href='$itemUrl' title='$toolTip'>$title</a> <span class='recently-viewed-item-removed' data-item-id='$recentItemId'>" . '&#10006;' . '</span></div>';
            $count += 1;
        }

        $viewAllText = __('View these %s recent items as search results', $count);
        $clearAllText = __('Clear all recent items');
        $findUrl = ItemSearch::getAdvancedSearchUrl(ItemMetadata::getIdentifierElementId(), $identifierList, 'contains');
        echo "<div id='recently-viewed-all'><a href='$findUrl'>$viewAllText</a></div>";
        echo "<div id='recently-viewed-clear'>$clearAllText <span id='recently-viewed-clear-x'>" . '&#10006;' . '</span></div>';
        echo '</div>'; // recently-viewed-items
    }
    ?>
</div>

<?php
echo $this->partial('recent-items-script.php', array('itemId' => $item->id));

if ($zoomingEnabled)
{
    echo $this->partial('avantzoom-script.php', array('viewerScript' => $viewerScript));
}
?>

