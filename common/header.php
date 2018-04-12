<?php
$themeName = Theme::getCurrentThemeName();
$this->addHelperPath(PUBLIC_THEME_DIR . "/$themeName/views/helpers", 'Omeka_View_Helper_');
?>

<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=yes" />
    <?php if ( $description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php endif; ?>
    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>
    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>

    <?php
    queue_css_url('//fonts.googleapis.com/css?family=Lato');
    queue_css_url('//fonts.googleapis.com/css?family=Roboto+Condensed');
    queue_css_url('//fonts.googleapis.com/css?family=Cabin');
    queue_css_file('iconfonts');
    queue_css_file('style');

    $customCss = explode('.', get_theme_option('Custom CSS'))[0];
    if (!empty($customCss))
    {
        try
        {
            queue_css_file($customCss);
        }
        catch (InvalidArgumentException $e)
        {
        }
    }

    echo head_css();
    ?>

    <?php
    queue_js_file('vendor/jquery-accessibleMegaMenu');
    queue_js_file('avant');
    queue_js_file('globals');
    echo head_js();
    ?>
</head>

<?php
$dependentPluginsActive = plugin_is_active('AvantCommon');
if (!$dependentPluginsActive)
{
    echo '<body>';
    echo '<h2 style="color:red;">AvantTheme requires that the AvantCommon plugin be installed.</h2>';
    echo '</body>';
    return;
}
?>

<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
    <div id="wrap">

        <header id="header" role="banner">
            <div id="simple-search-container" role="search">
                <?php
                if (plugin_is_active('AvantSearch'))
                {
                    echo AvantSearchPlugin::emitSearchForm();
                }
                else
                {
                    $advancedOption = get_theme_option('use_advanced_search');
                    echo search_form(array('show_advanced' => $advancedOption === null || $advancedOption == true));
                }
                ?>
            </div>

            <div id="masthead">
				<div id="branding" role="banner">
                    <?php echo link_to_home_page(theme_logo()); ?>
                    <div style="clear:both;"></div>
                </div>

				<!-- Container for mobile menu toggle -->
				<a id="nav-toggle">
					<span></span>
				</a>
				<nav id="top-nav" role="navigation">
					<?php echo public_nav_main(); ?>
				</nav>
            </div>

        </header>

        <div style="clear:both;"></div>

        <article id="content" role="main" tabindex="-1">
