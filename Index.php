<?php
    include('./global/config.php');
    include('./global/speedup.php');
    if(isset($_POST['_submit'])){
      $honeypot   = mysqli_real_escape_string($connect, trim(addslashes($_POST['_current'])));
      if(empty($honeypot)){
        $name     = mysqli_real_escape_string($connect, trim(addslashes($_POST['_name'])));
        $email    = mysqli_real_escape_string($connect, trim(addslashes($_POST['_email'])));
        $message  = mysqli_real_escape_string($connect, trim(addslashes($_POST['_message'])));
        $errors   = array();

        if(empty($name)){
          array_push($errors, "Name Field is Required");
        }
        else if(strlen($name) > 40){
          array_push($errors, "Name cannot contain more than 40 characters");
        }
        else if(strlen($name) <= 5){
          array_push($errors, "Username cannot contain less than 5 characters");
        }

        if(empty($email)){
          array_push($errors, "Email Field is Required");
        }
        else if(strlen($email) > 40){
          array_push($errors, "Email cannot contain more than 40 characters");
        }
        else if(strlen($email) <= 15){
          array_push($errors, "Email cannot contain less than 15 characters");
        }

        if(empty($message)){
          array_push($errors, "Message Field is Required");
        }
        else if(strlen($message) > 500){
          array_push($errors, "Message cannot contain more than 500 characters");
        }
        
        if(count($errors) == 0){
          $token_msg = openssl_random_pseudo_bytes(60);
          $token_msg = bin2hex($token_msg);

          mysqli_query($connect, "INSERT INTO messages(name, email, messages, token) VALUES('$name','$email','$message','$token_msg')");
          array_push($errors, "Message sent successfully ! Thank You");
        }
      }
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Stanley Owen</title>
		<?php include('./global/head.php'); ?>
	</head>
	<body>
		<?php include('./global/navbar.php'); ?>

    <div style="height: 85vh" class="container valign-wrapper">
      <div class="row">
        <div class="col s12 center-align">
          <h1>Welcome to<br/>Stanley Owen's<br/>Website</h1>
          <p class="flow-text grey-text text-darken-1">
            <i>" A dream doesn’t become reality through magic. <br/>It takes sweat, determination and hard work "</i>
          </p>
          <br />
          <div class="col s6">
            <a href="<?php echo $proxy ?>/apps/" class="btn btn-large waves-effect waves-light hoverable blue accent-3">
              Apps
            </a>
          </div>
          <div class="col s6">
            <a href="#about" class="btn btn-large btn-flat waves-effect white black-text">
              Get Started
            </a>
          </div>
        </div>
      </div>
    </div>

    <section id="about">
      <div class="container valign-wrapper">
        <div class="row">
          <div class="col s12 m5">
            <img src="img/97735dd3fd46e8f5d741276fcc5bf19d.webp" alt="" />
          </div>
          <div class="col s12 m7">
            <div class="card">
              <div class="card-title">
                <h2>About Me</h2>
              </div>
              <hr></hr>
              <div class="card-content">
                <h4>
                  Stanley Owen,
                </h4>
                <p>
                  A student who never stops learning, develop, and invent somethings new. Skilled
                  in developing Frontend UI (HTML, CSS, Bootstrap, Materialize, etc) and Backend (PHP & mySQL).<br/><br/>
                </p>
                <p>
                  Some achievement Stanley did in the past, such as built his own website, 
                  both being a Co-Founder and instructor of Multitude Developer,
                  Developer of Eternity Esports Web (using HTML, 
                  CSS, Javascript, PHP, and mySQL), etc.<br/><br/>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div id="mern" class="modal">
      <div class="modal-content">
        <h4 style="color: black">MERN STACK (MongoDB, Express, React, Node JS)</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p style="color: black"><i>No Masterpieces Available</i></p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="mongodb" class="modal">
      <div class="modal-content">
        <h4 style="color: black">MongoDB (NoSQL)</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p style="color: black"><i>No Masterpieces Available</i></p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="javascript" class="modal">
      <div class="modal-content">
        <h4 style="color: black">Javascript</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p>
          <a href="http://stanleyowen.atwebpages.com" target="_blank">stanleyowen.atwebpages.com</a><br>
          <a href="http://theeternity.atwebpages.com" target="_blank">theeternity.atwebpages.com</a><br>
          <a href="https://multidev.herokuapp.com" target="_blank">multidev.herokuapp.com</a>
        </p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="codeigniter" class="modal">
      <div class="modal-content">
        <h4 style="color: black">Codeigniter (PHP Framework)</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p style="color: black"><i>No Masterpieces Available</i></p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="php" class="modal">
      <div class="modal-content">
        <h4 style="color: black">PHP (Hypertext Processor)</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p>
          <a href="http://stanleyowen.atwebpages.com" target="_blank">stanleyowen.atwebpages.com</a><br>
          <a href="http://theeternity.atwebpages.com" target="_blank">theeternity.atwebpages.com</a><br>
        </p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="mysql" class="modal">
      <div class="modal-content">
        <h4 style="color: black">MySQL</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p>
          <a href="http://stanleyowen.atwebpages.com" target="_blank">stanleyowen.atwebpages.com</a><br>
          <a href="http://theeternity.atwebpages.com" target="_blank">theeternity.atwebpages.com</a><br>
        </p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="python" class="modal">
      <div class="modal-content">
        <h4 style="color: black">Python</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p>
          <a href="https://github.com/stanleyowen/Samsung-S10-using-Turtle.git" target="_blank">github.com/stanleyowen/Samsung-S10-using-Turtle.git</a><br>
        </p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="java" class="modal">
      <div class="modal-content">
        <h4 style="color: black">Java</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p style="color: black"><i>No Masterpieces Available</i></p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="c" class="modal">
      <div class="modal-content">
        <h4 style="color: black">C++</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p style="color: black"><i>No Masterpieces Available</i></p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="css" class="modal">
      <div class="modal-content">
        <h4 style="color: black">CSS (Cascade Style Sheets)</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p>
          <a href="http://stanleyowen.atwebpages.com" target="_blank">stanleyowen.atwebpages.com</a><br>
          <a href="http://theeternity.atwebpages.com" target="_blank">theeternity.atwebpages.com</a><br>
          <a href="https://multidev.herokuapp.com" target="_blank">multidev.herokuapp.com</a>
        </p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <div id="html" class="modal">
      <div class="modal-content">
        <h4 style="color: black">HTML (Hypertext Markup Language)</h4>
        <p style="color: black">Masterpieces Example :</p>
        <p>
          <a href="http://stanleyowen.atwebpages.com" target="_blank">stanleyowen.atwebpages.com</a><br>
          <a href="http://theeternity.atwebpages.com" target="_blank">theeternity.atwebpages.com</a><br>
          <a href="https://multidev.herokuapp.com" target="_blank">multidev.herokuapp.com</a>
        </p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>

    <section id="timelines">
      <h2><center>Timelines</center></h2>
      <div class="row">
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/6082b3dcdf221774d8345ced51ac68b4.webp"/>
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#mern">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/9fa1b39e7eb877367213e6f7e37d0b01.webp"/>
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#mongodb">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/de9b9ed78d7e2e1dceeffee780e2f919.webp"/>
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#javascript">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/ab664f63c186e43eb51f33c5f1a7e116.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#codeigniter">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/2fec392304a5c23ac138da22847f9b7c.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#php">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/81c3b080dad537de7e10e0987a4bf52e.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#mysql">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/23eeeb4347bdd26bfc6b7ee9a3b755dd.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#python">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/d52387880e1ea22817a72d3759213819.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#java">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/6ce809eacf90ba125b40fa4bd903962e.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#c">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/2c56c360580420d293172f42d85dfbed.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#css">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo $proxy ?>/img/6bff62b10d884fb77428cfe168cd783d.webp" />
                    </div>
                    <div class="card-content">
                        <a class="waves-effect waves-light btn modal-trigger blue" href="#html">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="get-in-touch">
      <div class="container">
        <div class="row">
          <div class="col s12 m6">
            <h3 class="text-center">Contact Stanley</h3>
            <h6>Email : <a href="mailto:stanleyowen06@gmail.com" target="_blank" rel="noopener noreferrer">stanleyowen06@gmail.com</a></h6>
            <h6>Instagram : <a href="https://instagram.com/stanleyowennn" target="_blank" rel="noopener noreferrer">stanleyowennn</a></h6>
            <h6>WhatsApp : <a href="https://wa.me/+6281396590955" target="_blank" rel="noopener noreferrer">+6281396590955</a></h6>
          </div>
          
          <div class="col s12 m6">
            <?php
              if(isset($_POST['_submit'])){
                include('./global/error.php');
              }
            ?>
            <form action="#get-in-touch" method="POST">
              <div class="input-field col s12">
                <input type="text" name="_current" style="display:none">
              </div>
              <div class="input-field col s12">
                <i class="material-icons prefix">account_circle</i>
                <input type="text" name="_name" id="name" placeholder="Your Name">
              </div>
              <div class="input-field col s12">
                <i class="material-icons prefix">email</i>
                <input type="email" name="_email" id="email" placeholder="Your Email Address">
              </div>
              <div class="input-field col s12">
                <i class="material-icons prefix">comment</i>
                <textarea name="_message" id="message" class="materialize-textarea" placeholder="Any messages? Type it here (max 500)" maxlength="500"></textarea>
              </div>
              <button type="submit" name="_submit" class="btn btn-large waves-effect waves-light hoverable blue accent-3" style="width: 100%"><i class="material-icons">send</i></button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <?php include('./global/footer.php'); ?>
    <?php include('./global/javascript.php'); ?>

	</body>
</html>