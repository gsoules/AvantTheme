<?php
// Force PHP errors to be displayed for debuggin even if the server settings want to hide them.
ini_set('display_errors', true);

if (!plugin_is_active('AvantCommon'))
{
    echo head(array('title' => 'ERROR'));
    return;
}

// Emit the Show page for this item.

$itemType = ItemMetadata::getElementTextForElementName($item, 'Type');

if (strpos($itemType, 'Set') === 0 && plugin_is_active('AvantRelationships'))
{
    echo $this->partial('/items/show-gallery.php', array('item' => $item));
}
else
{
    echo $this->partial('/items/show-item.php', array('item' => $item));
}

$emitFooter = !(plugin_is_active('AvantReport') && isset($_GET['report']));

if ($emitFooter)
    echo foot();
?>
