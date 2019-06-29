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

    <?php
    $globalSiteTag = get_theme_option('Global Site Tag');
    if (!empty($globalSiteTag))
    {
        // Emit Google Analytics tracking code for public users, but not for logged in users.
        // This way admin operations such as data entry won't throw off usage statistics.
        $user = current_user();
        $isLoggedIn = !empty($user);
        if (!$isLoggedIn)
        {
            echo $globalSiteTag;
        }
    }
    ?>

    <?php echo auto_discovery_link_tags(); ?>
    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>

    <?php
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

<?php echo body_tag(array('class' => @$bodyclass)); ?>
    <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
    <div id="wrap">

        <header id="header" role="banner">
            <?php echo link_to_home_page(theme_logo()); ?>
        </header>

        <nav id="menu">
            <a id="nav-toggle">
                <span></span>
            </a>
            <nav id="top-nav" role="navigation">
                <?php echo public_nav_main(); ?>
            </nav>
        </nav>

        <div id="search-container">
        </div>

<!--        <div style="clear:both;"></div>-->

        <article id="content" role="main" tabindex="-1">
