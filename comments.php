<h3><?php echo __('Comments'); ?></h3>
<div class="fb-comments" data-href="<?php echo get_permalink(); ?>" data-width="680"></div>
<script>
	(function($) {
		$(function() {
			if ($('#fb-root').length === 0) {
				$('body').append('<div id="fb-root"></div>');
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) {return;}
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/<?php echo get_locale() ?>/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk')); 
			}
		});
	})(jQuery);
</script>
