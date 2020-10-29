<?php
  include('config.php');
	echo'
  	<div class="navbar-fixed">
        <nav class="nav-extended">
          <div class="nav-wrapper white">
            <a href="'.$proxy.'" style="padding: 5px;" class="text-black brand-logo">
              <i class="material-icons">code</i>Stanley
            </a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger text-black">
              <i class="material-icons">menu</i>
            </a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
              <li>
                <a href="'.$proxy.'" class="bg-black btn tooltipped" data-position="bottom" data-tooltip="Home">
                  <span class="material-icons">home</span>
                </a>
                <a href="'.$proxy.'/library/" class="bg-black btn tooltipped" data-position="bottom" data-tooltip="CSS Library">
                  <span class="material-icons">extension</span>
                </a>
                <a href="'.$proxy.'/apps/" class="bg-black btn tooltipped" data-position="bottom" data-tooltip="Apps">
                  <span class="material-icons">apps</span>
                </a>
                <a href="#!" class="bg-black btn-toggle btn tooltipped" data-position="bottom" data-tooltip="Dark/Light Mode" onclick="replace()">
                  	<span class="material-icons">wb_sunny</span>
                </a>';
                if(isset($_COOKIE['token']) && isset($_COOKIE['token_id'])){
                  $token    = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_COOKIE['token']))));
                  $token_id   = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_COOKIE['token_id']))));
                  if(strlen($token) == 40 && strlen($token_id) == 120) {
                    $validate = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE token='$token' AND token_id='$token_id'"));
                    if($validate > 0){
                      echo '
                        <a href="'.$proxy.'/account/" class="bg-black btn tooltipped" data-position="bottom" data-tooltip="Account">
                          <span class="material-icons">account_circle</span>
                        </a>
                        <a href="?logout=true" class="bg-black btn tooltipped" data-position="bottom" data-tooltip="Sign Out">
                          <span class="material-icons">power_settings_new</span>
                        </a>
                        ';
                    }
                  }
                }
                echo'
              </li>
            </ul>
          </div>
        </nav>
      </div>

    <ul id="mobile-demo" class="sidenav">
      <li><a href="'.$proxy.'"><i class="material-icons">home</i>Home</a></li>
      <li><a href="'.$proxy.'/library/"><i class="material-icons">extension</i>CSS Library</a></li>
      <li><a href="'.$proxy.'/apps/"><i class="material-icons">apps</i>Apps</a></li>
      <li><a href="#!" onclick="replace()"><i class="material-icons">wb_sunny</i>Dark/Light Mode</a></li>';
      if(isset($_COOKIE['token']) && isset($_COOKIE['token_id'])){
        $token    = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_COOKIE['token']))));
        $token_id   = mysqli_real_escape_string($connect, htmlspecialchars(addslashes(trim($_COOKIE['token_id']))));
        if(strlen($token) == 40 && strlen($token_id) == 120) {
          $validate = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users WHERE token='$token' AND token_id='$token_id'"));
          if($validate > 0){
            echo '
              <li><a href="?logout=true"><i class="material-icons">power_settings_new</i>Logout</a></li>';
          }
        }
      }
      echo'
    </ul>
    ';
?>