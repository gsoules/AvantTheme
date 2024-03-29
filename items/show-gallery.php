<?php
// NOTE: Galleries are now called Sets, but gallery is still used internally.

echo head(array('title' => metadata($item, array('Dublin Core', 'Title')), 'bodyclass' => 'items show'));
?>

<h1 class="gallery"><?php echo metadata($item, array('Dublin Core', 'Title')); ?></h1>

<?php
$relatedItemsModel = new RelatedItemsModel($item, $this);
$relatedItems = $relatedItemsModel->getRelatedItems();

// Find items that contain this gallery. These items will all exist in $relatedItems,
// but they will be the only ones that are the target of the relationship. For example
// the gallery (source) is galleryOf another item (target). Conversely, the items in
// the gallery are all the source of the relationship. For example, gallery item (source)
// is containedIn the gallery (target).
$containerItemIds = array();
foreach ($relatedItems as $relatedItem)
{
    $galleryItem = $relatedItem->getItem();
    if ($galleryItem->id == $relatedItem->getRelationshipRecord()->getTargetItemId())
    {
        // This related item is a target of the gallery and therefore is a container.
        $containerItemIds[] = $galleryItem->id;
    }
}

$numContainerItems = count($containerItemIds);

if ($numContainerItems >= 1)
    echo "<div id=\"container-item-links\"><div class=\"container-item-links-label\">" . __('Items from: ');

foreach ($containerItemIds as $containerItemId)
{
    $containerItem = get_record_by_id('Item', $containerItemId);
    $containerItemTitle = $title = metadata($containerItem, array('Dublin Core', 'Title'), array('no_filter' => true));
    $url = url("items/show/$containerItemId");
    if ($numContainerItems == 1) {
    	echo "<span class=\"element-text single-container-item\"><a href=\"$url\">$containerItemTitle</a></span></div>";
    }
    else {
    	echo "<div class=\"element-text\"><a href=\"$url\">$containerItemTitle</a></div>";
    }
}

if ($numContainerItems >= 1)
    echo "</div>";

$description = metadata($item, array('Dublin Core', 'Description'), array('no_filter' => true));
echo "<div class=\"container-description\">$description</div>";

if ($numContainerItems == 0)
    echo "<div class='container-description' style='font-weight: bold;margin-top:12px;'>This Item Set does not contain any items</div>";

echo "<ul class='item-preview'>";
foreach ($relatedItems as $relatedItem)
{
    /* @var $relatedItem RelatedItem */
    $galleryItem = $relatedItem->getItem();

    // Identify container items so that they won't appear in the gallery.
    $isContainer = false;
    foreach ($containerItemIds as $containerItemId)
    {
        if ($galleryItem->id == $containerItemId)
        {
            $isContainer = true;
            break;
        }
    }

    if ($isContainer)
        continue;

    // Display the gallery item.
    $itemPreview = new ItemPreview($galleryItem);
    echo $itemPreview->emitItemPreviewAsListElement();
}
?>
</ul>

<div id="item-citation" class="element gallery">
    <h2>Citation</h2>
    <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
</div>

<?php
if (is_allowed($item, 'edit'))
    echo AvantCommon::emitAdminLinksHtml($item->id, 'gallery-links', false);
?>