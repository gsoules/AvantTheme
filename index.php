<?php
$pageTitle = __('Home');
echo head(array('bodyclass' => 'index primary-secondary', 'title' => $pageTitle));

$html = "<h2>Welcome to the Digital Archive</h2>";
$html .= "<p>Choose from the menu options above to explore this site.</p>";
echo $html;

echo foot();


