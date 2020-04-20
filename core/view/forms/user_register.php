<form class="form-horizontal" role="form" method="post" action="index.php/?process=user_register">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors(); ?></span>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="username">Username:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="username" value="<?php if(isset($session->form['username'])){echo $session->form['username'];}?>" id="username" placeholder="Enter your username" autocomplet="off" autofocus="on">
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="nameFirst">First Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nameFirst" value="<?php if(isset($session->form['nameFirst'])){echo $session->form['nameFirst'];}?>" id="nameFirst" placeholder="Enter your First Name" autocomplet="off" autofocus="on">
    </div>
  </div>
  
<div class="form-group">
    <label class="control-label col-sm-2" for="nameLast">Last Name:</label>
    <div class="col-sm-10">
      <input type="tel" class="form-control" name="nameLast" value="<?php if(isset($session->form['nameLast'])){echo $session->form['nameLast'];}?>" id="nameLast" placeholder="Enter your Last Name" autocomplet="off" autofocus="on">
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-2" for="nameCompany">Company Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nameCompany" value="<?php if(isset($session->form['nameCompany'])){echo $session->form['nameCompany'];}?>" id="nameCompany" placeholder="Enter your Company Name" autocomplet="off" autofocus="on">
    </div>
  </div>



<div class="form-group">
    <label class="control-label col-sm-2" for="tel">Phone:</label>
    <div class="col-sm-10">
      <input type="tel" class="form-control" name="phone" value="<?php if(isset($session->form['phone'])){echo $session->form['phone'];}?>" id="phone" placeholder="Enter your Phone Number" autocomplet="off" autofocus="on">
    </div>
  </div>

<div class="form-group">
    <label class="control-label col-sm-2" for="email">Email:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="email" value="<?php if(isset($session->form['email'])){echo $session->form['email'];}?>" id="email" placeholder="Enter your E-mail Address" autocomplet="off" autofocus="on">
    </div>
  </div>
<div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="password1"  id="password1" placeholder="Password" autocomplet="off" autofocus="on">
    </div>
  </div>

<div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password Again:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="password2" id="password2" placeholder="Password Again" autocomplet="off" autofocus="on">
    </div>
  </div>

	<input type="hidden" name="activation" value="<?php //echo $activ;?>">
		
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Register</button>
    </div>
  </div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <a href="index.php?pg=user_login">Already registered? Login here.</a>
    </div>
 </div>
</form>
