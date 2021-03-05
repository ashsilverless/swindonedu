<?php $simpleDate = get_field('delivered_on');
$timestamp = (strtotime($simpleDate));?>

<div class="course-item course-archive-item mix
<?php //loop through child tax terms in type tax
$current_tags = get_the_terms( get_the_ID($post->ID ), 'type' );
if ($current_tags){
	foreach ($current_tags as $tag) {
		$tag_title = $tag->name; // tag name
		$tag_title = str_replace(' ', '-', $tag_title);
		echo strtolower($tag_title). ' ';
	}	
}?>
<?php //loop through child tax terms in video_type tax
$current_tags = get_the_terms( get_the_ID($post->ID ), 'video_type' );
if ($current_tags){
	foreach ($current_tags as $tag) {
		$tag_title = $tag->name; // tag name
		$tag_title = str_replace(' ', '-', $tag_title);
		echo strtolower($tag_title). ' ';
	}	
}?>
" data-datestamp="<?php echo $timestamp;?>">
	<div class="summary">
		<p><?php the_field('delivered_on');?></p>
		<h2 class="heading heading__5"><?php the_title();?></h2>
		<div class="lecturer-wrapper">
		<?php while( have_rows('course_lecturers') ): the_row(); ?>
		<p><?php the_sub_field('lecturer');?></p>
		<?php endwhile;?>
		</div>
	</div>
	<a href="<?php the_permalink();?>" class="book">
		<span>
			<i class="fas fa-chevron-right"></i>
			See More	
		</span>
	</a>
</div>		