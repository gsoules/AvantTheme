<?php
queue_js_file('login');
$pageTitle = __('Log In');
echo head(array('bodyclass' => 'login', 'title' => $pageTitle), $header);
?>
<h1><?php echo $pageTitle; ?></h1>

<p id="login-links">&nbsp;</p>

<?php echo flash(); ?>
    
<?php echo $this->form->setAction($this->url('users/login')); ?>

<?php echo foot(array(), $footer); ?>
