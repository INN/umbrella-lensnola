<div id="homepage-featured" class="row-fluid clearfix">
	<div id="homepage-slider" class="carousel slide clearfix span8">
		<div class="carousel-inner">
			<div class="top-story item active">
				<?php
				global $ids;
				$topstory = largo_get_featured_posts( array(
					'tax_query' => array(
						array(
							'taxonomy' 	=> 'prominence',
							'field' 	=> 'slug',
							'terms' 	=> 'top-story'
						)
					),
					'showposts' => 1,
					'post__not_in' 	=> $ids
				) );
				if ( $topstory->have_posts() ) :
					while ( $topstory->have_posts() ) : $topstory->the_post(); $ids[] = get_the_ID(); $alt_title = get_post_meta(get_the_ID(),'wpcf-alternate-headline',true);?>
						<header>
                            <?php $category = largo_child_get_the_category();?>
					        <h5 class="<?php echo $category->slug;?>">
								<a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
							</h5>
						</header><!-- / entry header -->
					    <div class="carousel-caption">
					    	<h2><a href="<?php the_permalink(); ?>"><?php echo ($alt_title) ? $alt_title : the_title(); ?></a></h2>
					        <div class="carousel-excerpt">
							<div class="carousel-image"><?php the_post_thumbnail('carousel'); ?></div>
							<?php largo_excerpt( $post, 2, false ); ?></div>
					        <span class="byline"><?php largo_byline(); ?><span class="small_comments">&nbsp;&nbsp;&nbsp;&nbsp;<?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' | <span class="edit-link">', '</span>'); ?></span>
					    </div>
					<?php endwhile;
				endif; // end more featured posts ?>
			</div>
			<?php $substories = largo_get_featured_posts( array(
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'prominence',
						'field' 	=> 'slug',
						'terms' 	=> 'top-story'
					)
				),
				'showposts'		=> 3,
				'post__not_in' 	=> $ids
			) );
			if ( $substories->have_posts() ) :
				while ( $substories->have_posts() ) : $substories->the_post(); $ids[] = get_the_ID(); $alt_title = get_post_meta(get_the_ID(),'wpcf-alternate-headline',true);?>
					<div class="item">
						<header>
                            <?php $category = largo_child_get_the_category();?>
					        <h5 class="<?php echo $category->slug;?>">
								<a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
							</h5>
						</header><!-- / entry header -->
						<div class="carousel-caption">
							<h2><a href="<?php the_permalink(); ?>"><?php echo ($alt_title) ? $alt_title : the_title(); ?></a></h2>
							<div class="carousel-excerpt">
							<div class="carousel-image"><?php the_post_thumbnail('carousel'); ?></div>
							<?php largo_excerpt( $post, 2, false ); ?>
                            </div>
					        
							<span class="byline"><?php largo_byline(); ?><span class="small_comments">&nbsp;&nbsp;&nbsp;&nbsp;<?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' <div class="edit-link">', '</div>'); ?></span>
						</div>
					</div>
				<?php endwhile;
			endif; ?>
		</div>
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#homepage-slider" data-slide="prev"></a>
		<a class="carousel-control right" href="#homepage-slider" data-slide="next"></a>
	</div>
	
	<div class="sub-stories span4">
		<?php $substories = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'prominence',
					'field' 	=> 'slug',
					'terms' 	=> 'homepage-featured'
				)
			),
			'showposts'		=> 3,
			'post__not_in' 	=> $ids
		) );
		if ( $substories->have_posts() ) :
			$count = 1;
			while ( $substories->have_posts() ) : $substories->the_post(); $ids[] = get_the_ID();?>
					<div class="story">
						<header>
                            <?php $category = largo_child_get_the_category();?>
					        <h5 class="<?php echo $category->slug;?>">
								<a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
							</h5>
					 		<h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						</header><!-- / entry header -->
					
						<div class="entry-content">
							<?php largo_excerpt( $post, 1, false ); ?>
					        <span class="byline"><?php largo_byline(); ?><span class="smaller_byline_comments">&nbsp;&nbsp;&nbsp;&nbsp;<?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' | <span class="edit-link">', '</span>'); ?></span>
						</div><!-- .entry-content -->
					</div>
			<?php endwhile;
		endif; // end more featured posts ?>
	</div>
</div>