<form class="form-horizontal" role="form" method="post" action="index.php/?process=user_login">
  
  <div class="form-group">
  	<span class="col-xs-12 bg-danger"><?php echo GetErrors();?>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2 col-md-4" for="username">Username:</label>
    <div class="col-sm-10 col-md-8">
      <input type="text" class="form-control" name="username" value="" id="username" placeholder="Enter your username" autocomplet="off" autofocus="on">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2 col-md-4" for="pwd">Password:</label>
    <div class="col-sm-10 col-md-8">
      <input type="password" class="form-control" name="password"  id="password" placeholder="Password" autocomplet="off" autofocus="on">
    </div>
  </div>

	
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 col-md-8 col-md-offset-4" >
      <button type="submit" class="btn btn-primary">Login</button>
    </div>
  </div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 col-md-8 col-md-offset-4">
      <a href="index.php?pg=user_register">Click here to sign up!</a>
    </div>
 </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 col-md-8 col-md-offset-4">
      <a href="index.php?pg=user_new password">Forgot your password?</a>
    </div>
 </div>

</form>