<div class="post-social clearfix">
	<span class="facebook"><fb:like href="<?php echo the_permalink(); ?>" send="false" layout="button_count" show_faces="false" action="recommend" font=""></fb:like></span>
	<span class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink(); ?>" data-text="<?php echo the_title(); ?>" <?php if ( of_get_option( 'twitter_link' ) ) : ?>data-via="<?php echo largo_twitter_url_to_username( of_get_option( 'twitter_link' ) ); ?>"<?php endif; ?> data-count="none">Tweet</a></span>
	<span class="print"><a href="#" class="button_link" onclick="window.print()" title="print this article" rel="nofollow">PRINT</a></span>
</div>
