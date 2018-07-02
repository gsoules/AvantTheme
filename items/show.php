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
    $itemFiles = $item->Files;

    $info = array();
    $info['contributor'] = get_option('site_title');

    if (count($itemFiles) > 0)
    {
        $file = $itemFiles[0];
        $info['thumbnail'] = $file->getWebPath('thumbnail');
        $info['image'] = $file->getWebPath('original');
    }

    echo json_encode($info);
    return;
}

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
?>
