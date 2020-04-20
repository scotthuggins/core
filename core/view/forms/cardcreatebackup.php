<form class="form-horizontal" role="form" method="post" action="index.php/?process=card_create"><div class="form-group">
    <label class="control-label col-sm-2" for="billingNameFirst">billingNameFirst:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="billingNameFirst" value="<?php if(isset($session->form['billingNameFirst'])){echo $session->form['billingNameFirst'];}?>" id="billingNameFirst" placeholder="billingNameFirst of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="billingNameLast">billingNameLast:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="billingNameLast" value="<?php if(isset($session->form['billingNameLast'])){echo $session->form['billingNameLast'];}?>" id="billingNameLast" placeholder="billingNameLast of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="billingAddressLine1">billingAddressLine1:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="billingAddressLine1" value="<?php if(isset($session->form['billingAddressLine1'])){echo $session->form['billingAddressLine1'];}?>" id="billingAddressLine1" placeholder="billingAddressLine1 of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="billingAddressLine2">billingAddressLine2:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="billingAddressLine2" value="<?php if(isset($session->form['billingAddressLine2'])){echo $session->form['billingAddressLine2'];}?>" id="billingAddressLine2" placeholder="billingAddressLine2 of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="billingState">billingState:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="billingState" value="<?php if(isset($session->form['billingState'])){echo $session->form['billingState'];}?>" id="billingState" placeholder="billingState of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="cardType">cardType:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="cardType" value="<?php if(isset($session->form['cardType'])){echo $session->form['cardType'];}?>" id="cardType" placeholder="cardType of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="id">id:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="id" value="<?php if(isset($session->form['id'])){echo $session->form['id'];}?>" id="id" placeholder="id of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="name">name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" value="<?php if(isset($session->form['name'])){echo $session->form['name'];}?>" id="name" placeholder="name of the new card" autocomplet="off" autofocus="on">
    </div>
  </div>
  </form>