<?php
$identifier = ItemView::getItemIdentifier($item);
$zoomDataSources = count($item->Files) >= 1 ? Custom::getZoomDataSources($identifier) : array();

if (count($zoomDataSources) >= 1)
{
    queue_js_file('openseadragon.min');
}

echo head(array('title' => metadata($item, array('Dublin Core', 'Title')), 'bodyclass' => 'items show'));

$itemType = metadata($item, array('Dublin Core', 'Type'), array('no_filter' => true));
if ($itemType == 'Gallery')
{
    echo $this->partial('/items/show-gallery.php', array('item' => $item));
}
else
{
    echo $this->partial('/items/show-item.php', array('item' => $item, 'identifier' => $identifier, 'zoomDataSources' => $zoomDataSources));
}

echo foot();
?>
