<nav id="admin-bar">

<?php if (AvantCommon::userIsAdmin())
{
    $links = array(
        array(
            'label' => current_user()->name,
            'uri' => admin_url('/')
        ),
        array(
            'label' => __('Add item'),
            'uri' => admin_url('/items/add/')
        ),
        array(
            'label' => __('Logout'),
            'uri' => url('/users/logout')
        )
    );

}
else
{
    $links = array();
}

echo nav($links, 'public_navigation_admin_bar');
?>
</nav>
