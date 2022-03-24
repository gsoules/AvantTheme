        </article>

       <footer id="footer" role="contentinfo">
            <div id="footer-text">
                <?php
                $avantLogicLink = "Created by <a href='https://avantlogic.com/' target='_blank' title='AvantLogic Corporation' rel='noreferrer noopener'>AvantLogic</a>";
                $loginUrl = url('users/login');
                $logoutUrl = url('users/logout');

                // Emit both login and logout links, but only one will appear depending whether the 'logged-out'
                // or the 'logged-in' class has been dynamically emitted by AvantAdmin::emitDynamicCss().
                $loginLogoutLink = "<a class='logged-out' href='$loginUrl'>Login</a><a class='logged-in' href='$logoutUrl'>Logout</a>";

                $copyright = "© " . date("Y");
                $siteTitle = get_option('site_title');
                $footer = "$copyright $siteTitle — $avantLogicLink — $loginLogoutLink";

                $themeOptionFooterText = get_theme_option('Footer Text');
                if ($themeOptionFooterText)
                {
                    $footer = "$themeOptionFooterText<br/>";
                }
                else
                {
                    $footer = "$copyright $siteTitle";
                }
                $footer = "<div>$footer</div><div id='footer-loginout'><span>$avantLogicLink — $loginLogoutLink</span></div>";
                echo $footer;

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
