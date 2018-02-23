<?php

// Force PHP errors to be displayed even if the server settings want to hide them.
ini_set('display_errors', true);

$dependentPluginsActive = plugin_is_active('AvantCustom') && plugin_is_active('AvantSearch');

$identifier = ItemView::getItemIdentifier($item);
$zoomDataSources = array();

if (count($item->Files) >= 1 && $dependentPluginsActive)
{
    $zoomDataSources = Custom::getZoomDataSources($identifier);
}

if (count($zoomDataSources) >= 1)
{
    queue_js_file('openseadragon.min');
}

echo head(array('title' => metadata($item, array('Dublin Core', 'Title')), 'bodyclass' => 'items show'));

if (!$dependentPluginsActive)
    return;

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
