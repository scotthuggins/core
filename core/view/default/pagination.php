


<div id="paginationCorousel" class="carousel slide m-2" data-ride="carousel" data-interval="false" data-touch="true">
  
	<ul class="list-group list-group-horizontal">
		<li class="list-group-item p-0 bg-warning">
			<a class="btn btn-warning w-100 h-100" href="#paginationCorousel" role="button" data-slide="prev">
	    		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    		<span class="sr-only">Previous</span>
	  		</a>
  		</li>
		<nav class="carousel-inner ">
  
  
  
   <?php
   		$pgPerSegment = 5;
   		$segments = ceil(${$plur_entity}->page_count / $pgPerSegment);
		
		$cnt = 0;
		for ($x = 1 ; $x <= $segments ; $x++){
			$cnt++;
			
			$pgBegin = ($x * $pgPerSegment) - $pgPerSegment;
			$pgEnd = $pgBegin + $pgPerSegment;
			
			//if our current page is in our range, mark is as the active segment
			if(${$plur_entity}->page_current > $pgBegin && ${$plur_entity}->page_current <= $pgEnd  ){
				echo'
				<div class="carousel-item active ">
				<ul class="list-group list-group-horizontal d-flex flex-row h-100">';
			} else {
				//Mark is as inactive.
				echo'
				<div class="carousel-item">
				<ul class="list-group list-group-horizontal d-flex flex-row h-100">';
			}
			
			//Place inner page numbers
			for ($pg = $pgBegin + 1 ; $pg <= $pgEnd ; $pg++){
					
				// if the page is greater than existing pages
				if($pg > ${$plur_entity}->page_count){continue;}	
				//If this is the current page, mark the page
				if($pg == ${$plur_entity}->page_current){
					//echo '<li class="list-group-item bg-dark flex-fill p-0"><a class="btn btn-primary w-100 h-100 paginationButton" id="pagination_'.$entity_name.'_'.$pg.'" href="index.php?process=pagination&entity='.$entity_name.'&page='.$pg.'">'.$pg.'</a></li>';
					echo '<li class="list-group-item bg-dark flex-fill p-0"><a class="btn btn-primary w-100 h-100 paginationButton" id="pagination_'.$entity_name.'_'.$pg.'" href="#page_segment_'.$pg.'">'.$pg.'</a></li>';
				} else {
					//echo '<li class="list-group-item bg-dark flex-fill p-0"><a class="btn btn-dark w-100 h-100 paginationButton" id="pagination_'.$entity_name.'_'.$pg.'" href="index.php?process=pagination&entity='.$entity_name.'&page='.$pg.'">'.$pg.'</a></li>';
					echo '<li class="list-group-item bg-dark flex-fill p-0"><a class="btn btn-dark w-100 h-100 paginationButton" id="pagination_'.$entity_name.'_'.$pg.'" href="#page_segment_'.$pg.'">'.$pg.'</a></li>';
				}
			}
			//Close the segment
			echo '</ul></div>';
			if($cnt > 100){ print $cnt; exit; }
		}
	?>
   		</nav>
   		<li class="list-group-item p-0 bg-warning">
			<a class="btn btn-warning w-100 h-100" href="#paginationCorousel" role="button" data-slide="next">
	    		<span class="carousel-control-next-icon" aria-hidden="true"></span>
	    		<span class="sr-only">Previous</span>
	  		</a>
  		</li>
	</ul>
</div> 	
