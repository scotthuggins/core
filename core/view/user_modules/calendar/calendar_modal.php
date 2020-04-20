<?php
 echo '<!-- Modal Header -->
      <div class="modal-header p-0 m-0 bg-secondary">
        <h4 class="modal-title m-2 text-light text-capitalize"></h4>
        <button type="button" class="close btn closeModalButton m-0 " data-dismiss="modal"><span class="text-light">&times;</span></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" style="overflow-y;overflow-y:scroll">';
	  
	  include("dataview_calendar.php");
	  
	  
 echo '</div>'
      
?>