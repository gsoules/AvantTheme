<nav id="admin-bar">

<?php if($user = current_user()) {

    $links = array(
        array(
            'label' => $user->name,
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

} else {
    $links = array();
}

echo nav($links, 'public_navigation_admin_bar');
?>
</nav>
