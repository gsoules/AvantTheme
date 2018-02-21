<?php
$elementDisplay = new ElementDisplay();
$elementSet = $elementDisplay->orderElementsForDisplay($elementsForDisplay);
?>

<div class="element-set">
    <?php foreach ($elementSet as $elementName => $elementInfo): ?>
        <div id="<?php echo text_to_id(html_escape("{$elementInfo['element']['set_name']} $elementName")); ?>" class="element">
            <div class="field two columns alpha">
                <label><?php echo html_escape(__($elementName)); ?></label>
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
