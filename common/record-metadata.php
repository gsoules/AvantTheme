<?php
if (plugin_is_active('AvantElements'))
{
    $elementDisplay = new AvantElements();
    $elementSet = $elementDisplay->orderElementsForDisplay($elementsForDisplay);
}
else
{
    $elementSet = array();
    foreach ($elementsForDisplay as $set)
    {
        foreach ($set as $elementName => $elementInfo)
        {
            $elementSet[$elementName] = $elementInfo;
        }
    }
}

$privateElementsData = CommonConfig::getOptionDataForPrivateElements();
?>

<div class="item-element-metadata">
    <?php foreach ($elementSet as $elementName => $elementInfo): ?>
        <div id="<?php echo text_to_id(html_escape("{$elementInfo['element']['set_name']} $elementName")); ?>" class="element-metadata-row">
            <?php $class = in_array($elementName, $privateElementsData) ? ' private-element' : ''; ?>
            <div class="element-metadata-element<?php echo $class;?>">
                <?php
                echo html_escape(__($elementName)) . ':';
                ?>
            </div>
            <div class="element-metadata-value">
                <?php foreach ($elementInfo['texts'] as $index => $text):
                    if ($index == 0): ?>
                        <div class="element-metadata-value"><?php echo $text; ?></div>
                    <?php else: ?>
                        <div class="element-metadata-value"><?php echo $text; ?></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
