<?php 



echo '

<div class="calendar_actions_toolbar mt-2" id="'.$entity->class_name . '_' . $entity->id . '"  >

<button class="btn p-0">
	<span class="fa-stack fa-1x calendarBack">
		<i class="fa fa-circle fa-stack-2x text-secondary "></i>
		<i class="fa fa-angle-left fa-stack-1x text-light"></i>
	</span>
</button>
<button class="btn p-0">
	<span class="fa-stack fa-1x calendarForward">
		<i class="fa fa-circle fa-stack-2x text-secondary "></i>
		<i class="fa fa-angle-right fa-stack-1x text-light"></i>
	</span>
</button>
<button class="btn p-0">
	<span class="fa-stack fa-1x calendarReset">
		<i class="fa fa-circle fa-stack-2x text-secondary "></i>
		<i class="fa fa-rotate-left fa-stack-1x text-light"></i>
	</span>
</button>

<button class="btn p-0">
	<span class="fa-stack fa-1x calendarMonth">
		<i class="fa fa-circle fa-stack-2x text-secondary "></i>
		<i class="fa fa-calendar fa-stack-1x text-light"></i>
	</span>
</button>
<button class="btn p-0">
	<span class="fa-stack fa-1x calendarWeek">
		<i class="fa fa-circle fa-stack-2x text-secondary "></i>
		<i class="fa fa-calendar-week fa-stack-1x text-light"></i>
	</span>
</button>
<button class="btn p-0">
	<span class="fa-stack fa-1x calendarDay">
		<i class="fa fa-circle fa-stack-2x text-secondary "></i>
		<i class="fa fa-calendar-day fa-stack-1x text-light"></i>
	</span>
</button>



<button class="btn p-0">
	<span class="fa-stack fa-1x calendarFullScreen">
		<i class="fa fa-circle fa-stack-2x text-secondary "></i>
		<i class="fa fa-expand-arrows-alt fa-stack-1x text-light"></i>
	</span>
</button>
</div>'


; ?>