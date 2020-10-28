<?php
  include('../global/config.php');
  include('../global/speedup.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Stanley Owen | Apps</title>
		<?php include('../global/head.php'); ?>
	</head>
	<body>
		<?php include('../global/navbar.php'); ?>
    <style>
      
    </style>
    <div class="container text-center">
      <h1>Apps</h1>
      <h4>Created by Stanley Owen</h4>
      <p>Note : Every Users need to login in order to use these apps</p>
      <h3>General</h3>
      <div class="row">
        <div class="col s12 m3 apps">
          <a href="../todo/">
            <div class="col s12">
              <span class="new badge green" data-badge-caption="New"></span>
              <i class="large material-icons">assignment</i>
              <h5>Todo List</h5>
            </div>
          </a>
        </div>
        <div class="col s12 m3 apps">
          <a href="../notes/">
            <div class="col s12">
              <span class="new badge green" data-badge-caption="New"></span>
              <i class="large material-icons">note</i>
              <h5>Notes</h5>
            </div>
          </a>
        </div>
        <div class="col s12 m3 apps">
          <a href="#!" class="disabled">
            <div class="col s12">
              <span class="new badge red" data-badge-caption="Coming Soon"></span>
              <i class="large material-icons">chat</i>
              <h5>ChatApp MERN</h5>
            </div>
          </a>
        </div>
      </div>

      <h3>Security</h3>
      <div class="row">
        <div class="col s12 m3 apps">
          <a href="../pass-gen/">
            <div class="col s12">
              <span class="new badge green" data-badge-caption="New"></span>
              <i class="large material-icons">lock</i>
              <h5>Password Generator</h5>
            </div>
          </a>
        </div>
        <div class="col s12 m3 apps">
          <a href="../md5/">
            <div class="col s12">
              <span class="new badge green" data-badge-caption="New"></span>
              <i class="large material-icons">lock_outline</i>
              <h5>MD5 Encryption</h5>
            </div>
          </a>
        </div>
        <div class="col s12 m3 apps">
          <a href="../sha1/">
            <div class="col s12">
              <span class="new badge green" data-badge-caption="New"></span>
              <i class="large material-icons">lock_outline</i>
              <h5>SHA1 Encryption</h5>
            </div>
          </a>
        </div>
        <div class="col s12 m3 apps">
          <a href="#!" class="disabled">
            <div class="col s12">
              <span class="new badge red" data-badge-caption="Coming Soon"></span>
              <i class="large material-icons">lock_open</i>
              <h5>MD5 Decryption</h5>
            </div>
          </a>
        </div>
        <div class="col s12 m3 apps">
          <a href="#!" class="disabled">
            <div class="col s12">
              <span class="new badge red" data-badge-caption="Coming Soon"></span>
              <i class="large material-icons">lock_open</i>
              <h5>SHA1 Decryption</h5>
            </div>
          </a>
        </div>
      </div>
    </div>
    <?php include('../global/footer.php'); ?>
    <?php include('../global/javascript.php'); ?>

	</body>
</html>