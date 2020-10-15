<?php
/**
 * The template for displaying all single posts
 *
 * @package swindonedu
 */
get_header(); ?>
<!--<?php get_template_part('inc/img/africa-map');?>-->
<article>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="container container__extra-narrow container__white news-header">
			<div class="left-col news-header__prev">
				<?php previous_post_link('%link', '', true ) ?>
			</div>
			<div class="center-col news-header__detail">
				<p class="entry-author"><?php the_author(); ?></p>
				<p class="entry-date"><?php echo get_the_date(); ?></p>
				<h2 class="heading heading__4"><?php the_field('sub_headline');?></h2>
			</div>
			<div class="right-col news-header__next">
				<?php next_post_link('%link', '', true ); ?>
			</div>
		</div>
		<div class="container container__extra-narrow container__white page-section">
			<div class="left-col"></div>
			<div class="center-col">
				<p><?php the_field('main_copy');?></p>
			</div>
			<div class="right-col"></div>
		</div>

		<div class="container col-2 container__white page-section">
		    <?php get_template_part('template-parts/gallery');?>
		</div>
	<?php endwhile; endif; ?>
</article>

<div class="container col-2">
    <div class="news-leaders">
    <h3 class="heading heading__4 heading__accent">Other News</h3>
    <?php $swindoneduPosts = new WP_Query(array(
        'post_type'=>'post',
        'post_status'=>'publish',
        'posts_per_page'=>9,
		'post__not_in' => array( $post->ID )
    ));
    if ( $swindoneduPosts->have_posts() ) :
    while ( $swindoneduPosts->have_posts() ) :
    $swindoneduPosts->the_post();
    $postImage = get_field('background_image');
    ?>
        <div class="news-leaders__item">
            <div class="image">
                <a href="<?php the_permalink();?>">
                    <div class="background-image">
                        <img <?php $thisImage = $postImage;?>
                        src="<?php echo $thisImage['url'];?>"
                        title="<?php echo $thisImage['title'];?>"
                        alt="<?php echo $thisImage['alt'];?>"
                        />
                    </div>
                </a>
            </div>
            <p class="entry-date"><?php echo get_the_date(); ?></p>
            <h2 class="heading heading__5"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
            <p class="entry-excerpt"><?php echo post_leader_excerpt(); ?></p>
            <a href="<?php the_permalink();?>" class="button">Read More</a>
        </div>
    <?php endwhile; wp_reset_postdata();endif; ?>
    </div>
</div>
<div class="container container__fullwidth align-center page-section">
	<div></div>
	<div>
		<a href="/news" class="button button__boxed button__inline">See More News</a>
	</div>
</div>

<?php get_footer(); ?>
