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
			<section class="longform">
			<h3 class="heading heading__5">Details:</h3>	
			<p>Date Of Training: <?php the_field('delivered_on');?></p>
			<p>Lecturer: <?php the_field('lecturer');?></p>
			
			<?php if (get_field('learning_objectives')) {?>
			<p>Learning Objectives:</p>
				<ul>
				<?php if( have_rows('learning_objectives') ):
				$i = 1;
				while( have_rows('learning_objectives') ): the_row(); ?>
					<li><p><span><?=$i;?></span><?php the_sub_field('objective');?></p></li>
				<?php $i++;endwhile; endif;?>
				</ul>
			<?php }?>
			
			<?php if (get_field('curriculum_statement')) {?>
				<p>Curriculum Statement:</p>
				<ul>
				<?php if( have_rows('curriculum_statement') ):
				while( have_rows('curriculum_statement') ): the_row(); ?>
					<li class="large-index"><p><span><?php the_sub_field('number');?></span><?php the_sub_field('statement');?></p></li>
				<?php endwhile; endif;?>
				</ul>
			<?php }?>
			
			</section>
			<section>
			<h3 class="heading heading__5">Overview:</h3>	
			<?php the_field('course_overview');?>
			</section>
		</section>
	</div>
	<div class="side-content">
		<section>
		<h3 class="heading heading__5">Supporting Materials:</h3>	
		<?php if( have_rows('attachments') ):
		while( have_rows('attachments') ): the_row(); ?>
			<?php $attachedFile = get_sub_field('attachment');?>
			<p class="file-download">
				<a href="<?php echo $attachedFile['url'];?>" target="_blank"><i class="far fa-file-alt"></i></a>
				<a href="<?php echo $attachedFile['url'];?>" target="_blank"><?php echo $attachedFile['title'];?></a>
			</p>
		<?php endwhile; endif;?>
		</section>
		<?php get_template_part ('template-parts/courses-sidebar');?>
	</div>	
</div>
	
<?php get_footer();?>