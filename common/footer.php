        </article>

       <footer id="footer" role="contentinfo">
            <div id="footer-text">
				<?php echo get_theme_option('Footer Text'); ?>
			</div>

           <?php fire_plugin_hook('public_footer', array('view'=>$this)); ?>
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
    });
    </script>

<?php echo $this->partial('avantcommon-script.php'); ?>
</body>
</html>
