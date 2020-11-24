<?php
/**
 * The template for displaying all course archive custom posts
 *
 * @package swindonedu
 */
get_header(); ?>

<div class="container grid-gap content">
	<div class="main-content">
		<section>
			<?php $courseVideo = get_field('video_file');?>
			<div class="wrapper-video">
				<video class="video-archive-asset" preload controls>
					<source src="<?php echo $courseVideo['url']; ?>" />
				</video>
			</div>	
		</section>
		<section>
			<h3 class="heading heading__5">Overview:</h3>	
			<?php the_field('course_overview');?>
		</section>
	</div>
	<div class="side-content">
		<section>
			<h3 class="heading heading__5">Details:</h3>	
			<p>Date Of Training: <?php the_field('delivered_on');?></p>
			<p>Lecturer: <?php the_field('lecturer');?></p>
		</section>
		
		<?php if( have_rows('attachments') ):
		while( have_rows('attachments') ): the_row(); ?>
		<section>
			<h3 class="heading heading__5">Supporting Materials:</h3>	
			<?php $attachedFile = get_sub_field('attachment');?>
			<p class="file-download">
				<a href="<?php echo $attachedFile['url'];?>" target="_blank"><i class="far fa-file-alt"></i></a>
				<a href="<?php echo $attachedFile['url'];?>" target="_blank"><?php echo $attachedFile['title'];?></a>
			</p>
		</section>
		<?php endwhile; endif;?>
		
		<section>
			<?php get_template_part ('template-parts/courses-sidebar');?>
		</section>
	</div>	
</div>
	
<?php get_footer();?>