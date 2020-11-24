<div class="course-item mix <?php 
$current_tags = get_the_terms( get_the_ID($post->ID ), 'product_tag' );
if ($current_tags){
	foreach ($current_tags as $tag) {
		$tag_title = $tag->name; // tag name
		$tag_title = str_replace(' ', '-', $tag_title);
		echo strtolower($tag_title). ' ';
	}	
}?>">
	<div class="summary">
		<p><?php the_field('date_of_course');?></p>
		<h2 class="heading heading__5"><?php the_title();?></h2>
		<p><?php the_field('lecturer');?></p>
		<p class="read-more">Read More<i class="fas fa-chevron-right"></i></p>
	</div>
	<a href="<?php the_permalink();?>" class="book">
		<span>
			<i class="fas fa-chevron-right"></i>
			Book Now	
		</span>
	</a>
	<div class="description">
		<?php the_field('synopsis');?>
		<p class="read-less"><i class="fas fa-times"></i></p>
	</div>
</div>
