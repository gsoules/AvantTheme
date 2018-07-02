<?php
// Force PHP errors to be displayed for debuggin even if the server settings want to hide them.
ini_set('display_errors', true);

if (!plugin_is_active('AvantCommon'))
{
    echo head(array('title' => 'ERROR'));
    return;
}

$requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();

if (isset($requestParams['share']))
{
    // The request is to return the item's sharable assets, namely its thumbnail and image URLs.
    // If the item has no image, just the site name gets returned.

    echo AvantCommon::emitSharedItemAssets($item);
}
else
{
    // Emit the Show page for this item.

    $itemType = ItemMetadata::getElementTextForElementName($item, 'Type');

    if ($itemType == 'Gallery' && plugin_is_active('AvantRelationships'))
    {
        echo $this->partial('/items/show-gallery.php', array('item' => $item));
    }
    else
    {
        echo $this->partial('/items/show-item.php', array('item' => $item));
    }

    echo foot();
}
?>
