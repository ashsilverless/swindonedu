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
			<?php if (get_field('learning_objectives')) {?>
			<div class="product-meta__item longform">
				<h4 class="heading heading__6">Learning Objectives</h4>
				<ul>
				<?php if( have_rows('learning_objectives') ):
				$i = 1;
				while( have_rows('learning_objectives') ): the_row(); ?>
					<li><p><span><?=$i;?></span><?php the_sub_field('objective');?></p></li>
				<?php $i++; endwhile; endif;?>
				</ul>
			</div>
			<?php }?>
		</section>
	</div>
	<div class="side-content">
		<section>
			<h3 class="heading heading__5">Details:</h3>	
			<p>Date Of Training: <?php the_field('delivered_on');?></p>
		
			<?php if( have_rows('course_lecturers') ):?>
			<div class="lecturer-wrapper">
			<h4 class="heading heading__6">
				<?php
				$lecturers = get_field('course_lecturers');
				$lecturerCount = count($lecturers);
					if ($lecturerCount <= 1){
						echo 'Lecturer';
					} else {
						echo 'Lecturers';
					};?>
				</h4>
				<?php while( have_rows('course_lecturers') ): the_row(); ?>
					<p><?php the_sub_field('lecturer');?></p>
				<?php endwhile;?>
			</div>
			<?php endif;?>

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