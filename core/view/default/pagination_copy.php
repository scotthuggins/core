<ul class="pagination m-2 ml-3">
	<li class="page-item"><a class="page-link" href="#">Previous</a></li>
	<?php
		
		for ($x = (${$plur_entity}->page_current - 3) ; $x <= 7 + ${$plur_entity}->page_current; $x++){
			if($x > ${$plur_entity}->page_current + 3
				|| $x > ${$plur_entity}->page_count ){
				continue;
			}
			if($x <= 0){
				continue;
			}
			
			if($x == ${$plur_entity}->page_current){
				echo '<li class="page-item active"><a class="page-link" href="index.php?process=pagination&entity='.$entity_name.'&page='.$x.'">'.$x.'</a></li>';
			}
			else{echo '<li class="page-item"><a class="page-link" href="index.php?process=pagination&entity='.$entity_name.'&page='.$x.'">'.$x.'</a></li>';}
			
		}
		
	?>
	<li class="page-item"><a class="page-link" href="#">Next</a></li>
</ul>