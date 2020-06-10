        </article>

       <footer id="footer" role="contentinfo">
            <div id="footer-text">
                <?php
                $themeOptionFooterText = get_theme_option('Footer Text');
                if (plugin_is_active('AvantElasticsearch'))
                {
                    $parts = explode('|', $themeOptionFooterText);
                    if (count($parts) != 2)
                    {
                        // The Footer option on the AvantTheme configuration page should contain a single line
                        // of the form "<organization-name>|<organization-url>". If the organization has no URL,
                        // the second value can be left blank, but the vertical bar delimiter is still required.
                        $footer = __('ORGANIZATION NAME AND URL ARE MISSING FROM THEME CONFIGURATION');
                    }
                    else
                    {
                        $organizationName = $parts[0];
                        $organizationUrl = $parts[1];
                        $organizationLink = empty($parts[1]) ? $organizationName : "<a href=''$organizationUrl' title='$organizationName'>$organizationName</a>";
                        $avantLogicLink = "Created by <a href='http://avantlogic.com/' target='_blank' title='AvantLogic Corporation' rel='noreferrer noopener'>AvantLogic</a>";
                        $loginUrl = url('users/login');
                        $logoutUrl = url('users/logout');

                        // Emit both login and logout links, but only one will appear depending whether the 'logged-out'
                        // or the 'logged-in' class has been dynamically emitted by AvantAdmin::emitDynamicCss().
                        $loginLogoutLink = "<a class='logged-out' href='$loginUrl'>Login</a><a class='logged-in' href='$logoutUrl'>Logout</a>";

                        $copyright = "© " . date("Y");
                        $footer = "$copyright $organizationLink — $avantLogicLink — $loginLogoutLink";
                    }
                    echo $footer;
                }
                else
                {
                    echo $themeOptionFooterText;
                }
                fire_plugin_hook('public_footer', array('view'=>$this));
                ?>
			</div>
        </footer>

    </div><!-- end wrap -->

    <script>
    var state = false;
    jQuery(document).ready(function() {
        Omeka.showAdvancedForm();
        Omeka.skipNav();
        Avant.megaMenu();
		jQuery("#nav-toggle").click(function(){
			jQuery("#top-nav").slideToggle(function(){ if (state) {jQuery(this).removeAttr( 'style' )}; state = ! state; } );
		});
		jQuery("#menu").show();
    });
    </script>

</body>
</html>
