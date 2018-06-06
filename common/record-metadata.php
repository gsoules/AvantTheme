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

<div class="element-set">
    <?php foreach ($elementSet as $elementName => $elementInfo): ?>
        <div id="<?php echo text_to_id(html_escape("{$elementInfo['element']['set_name']} $elementName")); ?>" class="element">
            <div class="field two columns alpha">
                <?php
                // Style the element label to indicate whether the field is private.
                $class = in_array($elementName, $privateElementsData) ? ' class="private-element"' : '';
                echo "<label$class>" . html_escape(__($elementName)) . "</label>";
                ?>
            </div>
            <?php foreach ($elementInfo['texts'] as $index => $text):
                if ($index == 0): ?>
                    <div class="element-text five columns omega"><p><?php echo $text; ?></p></div>
                <?php else: ?>
                    <div class="element-text five columns offset-by-three"><p><?php echo $text; ?></p></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
