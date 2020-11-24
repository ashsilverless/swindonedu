<div class="sidebar-filter">
	<p>Filter By:</p>
	<div class="sidebar-filter__item dropdown">
		<p>Date</p>
		<select name="date-sort" id="sortbox">						
			<option value="desc">DESCENDING</option>
			<option value="asc">ASCENDING</option>
		</select>
	</div>
	<div class="sidebar-filter__item">
		<p>Subject</p>
		<div class="filter-controls">
			<p class="filter filter-controls__button" data-filter="all">All</p>
			<!--Add conditional for taxonomy-->
			<?php if ( is_page_template( 'page-templates/course-archive.php' ) ) {
				$parentType = 32; //ID for standard
				} elseif ( is_page_template( 'page-templates/gp-training.php' ) ) {
				$parentType = 33; //ID for gp training
				}?>

			<?php
			$term_id = $parentType;
			$taxonomy_name = 'type';
			$termchildren = get_term_children( $term_id, $taxonomy_name);
			
			foreach ( $termchildren as $child ) {
				$term = get_term_by( 'id', $child, $taxonomy_name );
				if ($term->count >=1){
				?>
							
				<p class="filter-controls__button filter <?php echo $term->slug;?>" data-filter=".<?php echo $term->slug;?>">
				<?php echo $term->name;?>
			</p>
			<?php } 
		}?> 
		
		
		<?php
		$term_id = 54;
		$taxonomy_name = 'video_type';
		$termchildren = get_term_children( $term_id, $taxonomy_name);
		
		foreach ( $termchildren as $child ) {
			$term = get_term_by( 'id', $child, $taxonomy_name );
			if ($term->count >=1){
			?>
						
			<p class="filter-controls__button filter <?php echo $term->slug;?>" data-filter=".<?php echo $term->slug;?>">
			<?php echo $term->name;?>
		</p>
		<?php } 
	}?> 
		
		
		
		
		
		
		
		
		</div>
	</div>
</div>