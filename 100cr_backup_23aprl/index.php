<?php

	session_start();
	include('php/config.php');
	if(isset($_SESSION["100c_user_info"])){
		header("Location:dashboard.php");
	}

?>
  <title>Infrastructure - Projects</title>
  <link rel="shortcut icon" type="image/png" href="images/logo2.png" />

  <!-- Bootstrap core CSS -->
 <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<script src="js/jquery-min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  
  <style>



body {
  background: url("images/pic2.jpg")
    no-repeat bottom fixed #000;
  background-size: cover;
}

#hero-img {
  height: 100vh;
}

/*#login-form {
  background: linear-gradient(rgba(96, 102, 125,0.6) 100%, rgba(96, 102, 125, 0.6) 100%);
}*/

#circle {
  height: 8rem;
  width: 8rem;
  border-radius: 50%;
  border: 0.3rem solid rgba(242,246,248,1);
  position: relative;
  bottom: 2rem;
  margin: auto;
}

.hero-text {
  font-family: "Times New Roman", Times, serif;
  font-size: 1.3vw;
 background: linear-gradient(rgba(1,112,171, 0.7) 100%, rgba(1,112,171, 0.7) 100%);


}

.fas,
.fa-user {
  color: rgba(242,246,248,1);
  display: flex;
  align-items: center;
  margin: auto;
  font-size: 4.5rem;
}

.card {
  background: linear-gradient(rgba(1,112,171, 0.7) 100%, rgba(1,112,171, 0.7) 100%);
}

.btn {
  border-color: #2473bd;
  color: #2473bd;
}

.btn:hover {
  border-color: #094f91;
  color: #094f91;
  background: #094f91;
  color: #fff;
}

.btn:active {
  border-color: #094f91;
  color: #094f91;
  background: #094f91;
  color: #fff;
}

@media (max-width: 992px) {
  #hero-img {
    height: 0vh;
  }

  #login-form {
    height: 100vh;
  }
}

.slideshow,
.slideshow:after {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    z-index: 0;
}
.slideshow:after {
    content: '';
    background: transparent url(../images/pattern.png) repeat top left;
}
.slideshow li span {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0px;
    left: 0px;
    color: transparent;
    background-size: cover;
    background-position: 50% 50%;
    background-repeat: none;
    opacity: 0;
    z-index: 0;
	-webkit-backface-visibility: hidden;
    -webkit-animation: imageAnimation 36s linear infinite 1s;
    -moz-animation: imageAnimation 36s linear infinite 1s;
    -o-animation: imageAnimation 36s linear infinite 1s;
    -ms-animation: imageAnimation 36s linear infinite 1s;
    animation: imageAnimation 36s linear infinite 1s;
}
.slideshow li div {
    z-index: 1000;
    position: absolute;
    bottom: 30px;
    left: 0px;
    width: 100%;
    text-align: center;
    opacity: 0;
    -webkit-animation: titleAnimation 36s linear infinite 0s;
    -moz-animation: titleAnimation 36s linear infinite 0s;
    -o-animation: titleAnimation 36s linear infinite 0s;
    -ms-animation: titleAnimation 36s linear infinite 0s;
    animation: titleAnimation 36s linear infinite 0s;
}
.slideshow li div h3 {
  font-family: "helvetica neue", helvetica;
  text-transform: uppercase;
  font-size: 80px;
  padding: 0;
  line-height: 200px;
	color: rgba(255,255,255, 0.8);
}
.slideshow li:nth-child(1) span { background-image: url(images/gis.jpg) }
.slideshow li:nth-child(2) span {
    background-image: url(images/gis6.jpg);
    -webkit-animation-delay: 6s;
    -moz-animation-delay: 6s;
    -o-animation-delay: 6s;
    -ms-animation-delay: 6s;
    animation-delay: 6s;
}
.slideshow li:nth-child(3) span {
    background-image: url('images/gis7.jpg');
    -webkit-animation-delay: 12s;
    -moz-animation-delay: 12s;
    -o-animation-delay: 12s;
    -ms-animation-delay: 12s;
    animation-delay: 12s;
}
.slideshow li:nth-child(4) span {
    background-image: url(images/gis5.jpg);
    -webkit-animation-delay: 18s;
    -moz-animation-delay: 18s;
    -o-animation-delay: 18s;
    -ms-animation-delay: 18s;
    animation-delay: 18s;
}
.slideshow li:nth-child(5) span {
    background-image: url(images/gis6.jpg);
    -webkit-animation-delay: 24s;
    -moz-animation-delay: 24s;
    -o-animation-delay: 24s;
    -ms-animation-delay: 24s;
    animation-delay: 24s;
}
.slideshow li:nth-child(6) span {
    background-image: url(images/gis7.jpg);
    -webkit-animation-delay: 30s;
    -moz-animation-delay: 30s;
    -o-animation-delay: 30s;
    -ms-animation-delay: 30s;
    animation-delay: 30s;
}
.slideshow li:nth-child(2) div {
    -webkit-animation-delay: 6s;
    -moz-animation-delay: 6s;
    -o-animation-delay: 6s;
    -ms-animation-delay: 6s;
    animation-delay: 6s;
}
.slideshow li:nth-child(3) div {
    -webkit-animation-delay: 12s;
    -moz-animation-delay: 12s;
    -o-animation-delay: 12s;
    -ms-animation-delay: 12s;
    animation-delay: 12s;
}
.slideshow li:nth-child(4) div {
    -webkit-animation-delay: 18s;
    -moz-animation-delay: 18s;
    -o-animation-delay: 18s;
    -ms-animation-delay: 18s;
    animation-delay: 18s;
}
.slideshow li:nth-child(5) div {
    -webkit-animation-delay: 24s;
    -moz-animation-delay: 24s;
    -o-animation-delay: 24s;
    -ms-animation-delay: 24s;
    animation-delay: 24s;
}
.slideshow li:nth-child(6) div {
    -webkit-animation-delay: 30s;
    -moz-animation-delay: 30s;
    -o-animation-delay: 30s;
    -ms-animation-delay: 30s;
    animation-delay: 30s;
}
/* Animation for the slideshow images */
@-webkit-keyframes imageAnimation { 
	0% {
	    opacity: 0;
	    -webkit-animation-timing-function: ease-in;
	}
	8% {
	    opacity: 1;
	    -webkit-transform: scale(1.05);
	    -webkit-animation-timing-function: ease-out;
	}
	17% {
	    opacity: 1;
	    -webkit-transform: scale(1.1);
	}
	25% {
	    opacity: 0;
	    -webkit-transform: scale(1.1);
	}
	100% { opacity: 0 }
}
@-moz-keyframes imageAnimation { 
	0% {
	    opacity: 0;
	    -moz-animation-timing-function: ease-in;
	}
	8% {
	    opacity: 1;
	    -moz-transform: scale(1.05);
	    -moz-animation-timing-function: ease-out;
	}
	17% {
	    opacity: 1;
	    -moz-transform: scale(1.1);
	}
	25% {
	    opacity: 0;
	    -moz-transform: scale(1.1);
	}
	100% { opacity: 0 }
}
@-o-keyframes imageAnimation { 
	0% {
	    opacity: 0;
	    -o-animation-timing-function: ease-in;
	}
	8% {
	    opacity: 1;
	    -o-transform: scale(1.05);
	    -o-animation-timing-function: ease-out;
	}
	17% {
	    opacity: 1;
	    -o-transform: scale(1.1);
	}
	25% {
	    opacity: 0;
	    -o-transform: scale(1.1);
	}
	100% { opacity: 0 }
}
@-ms-keyframes imageAnimation { 
	0% {
	    opacity: 0;
	    -ms-animation-timing-function: ease-in;
	}
	8% {
	    opacity: 1;
	    -ms-transform: scale(1.05);
	    -ms-animation-timing-function: ease-out;
	}
	17% {
	    opacity: 1;
	    -ms-transform: scale(1.1);
	}
	25% {
	    opacity: 0;
	    -ms-transform: scale(1.1);
	}
	100% { opacity: 0 }
}
@keyframes imageAnimation { 
	0% {
	    opacity: 0;
	    animation-timing-function: ease-in;
	}
	8% {
	    opacity: 1;
	    transform: scale(1.05);
	    animation-timing-function: ease-out;
	}
	17% {
	    opacity: 1;
	    transform: scale(1.1);
	}
	25% {
	    opacity: 0;
	    transform: scale(1.1);
	}
	100% { opacity: 0 }
}
/* Animation for the title */
@-webkit-keyframes titleAnimation { 
	0% {
	    opacity: 0;
	    -webkit-transform: translateY(200px);
	}
	8% {
	    opacity: 1;
	    -webkit-transform: translateY(0px);
	}
	17% {
	    opacity: 1;
	    -webkit-transform: scale(1);
	}
	19% { opacity: 0 }
	25% {
	    opacity: 0;
	    -webkit-transform: scale(10);
	}
	100% { opacity: 0 }
}
@-moz-keyframes titleAnimation { 
	0% {
	    opacity: 0;
	    -moz-transform: translateY(200px);
	}
	8% {
	    opacity: 1;
	    -moz-transform: translateY(0px);
	}
	17% {
	    opacity: 1;
	    -moz-transform: scale(1);
	}
	19% { opacity: 0 }
	25% {
	    opacity: 0;
	    -moz-transform: scale(10);
	}
	100% { opacity: 0 }
}
@-o-keyframes titleAnimation { 
	0% {
	    opacity: 0;
	    -o-transform: translateY(200px);
	}
	8% {
	    opacity: 1;
	    -o-transform: translateY(0px);
	}
	17% {
	    opacity: 1;
	    -o-transform: scale(1);
	}
	19% { opacity: 0 }
	25% {
	    opacity: 0;
	    -o-transform: scale(10);
	}
	100% { opacity: 0 }
}
@-ms-keyframes titleAnimation { 
	0% {
	    opacity: 0;
	    -ms-transform: translateY(200px);
	}
	8% {
	    opacity: 1;
	    -ms-transform: translateY(0px);
	}
	17% {
	    opacity: 1;
	    -ms-transform: scale(1);
	}
	19% { opacity: 0 }
	25% {
	    opacity: 0;
	    -webkit-transform: scale(10);
	}
	100% { opacity: 0 }
}
@keyframes titleAnimation { 
	0% {
	    opacity: 0;
	    transform: translateY(200px);
	}
	8% {
	    opacity: 1;
	    transform: translateY(0px);
	}
	17% {
	    opacity: 1;
	    transform: scale(1);
	}
	19% { opacity: 0 }
	25% {
	    opacity: 0;
	    transform: scale(10);
	}
	100% { opacity: 0 }
}
/* Show at least something when animations not supported */
.no-cssanimations .slideshow li span{
	opacity: 1;
}
@media screen and (max-width: 1140px) { 
	.slideshow li div h3 { font-size: 100px }
}
@media screen and (max-width: 600px) { 
	.slideshow li div h3 { font-size: 50px }
}

</style>

</head>

<body>
	<!--<ul class="slideshow">
  <li><span>Image 01</span><div></div></li>
  <li><span>Image 02</span></li>
  <li><span>Image 03</span></li>
  <li><span>Image 04</span></li>
  <li><span>Image 05</span></li>
  <li><span>Image 06</span></li>
</ul>-->
  <div class="container-fluid">
    <div class="row">
      <div id="hero-img" class="col img-fluid d-flex align-items-center justify-content-center">
        <h1 class="hero-text text-light d-none d-lg-block "><img src="<?php echo DOMAIN . 'images/logo.png'; ?>" width="70" height="70" class="d-inline-block align-left" alt=""><b>Web-GIS for Monitoring the Major Infrastructure Projects</b><img src="<?php echo DOMAIN . 'images/logo2.png'; ?>" width="70" height="80" class="d-inline-block align-left" alt=""> <span style="right:0px;position: absolute;"></span></h1>
      </div>
      <div id="login-form" class="col-lg d-flex align-items-center justify-content-center">

        <form class="w-75" action="login.php" method="post">
          <!-- Not to sure about the line below, d-flex alone centered the icon in the circle. ask about this 7-20-2020 -->
          <div id="circle" class="d-flex"><i class="fas fa-user"></i></div>
          <div class="card">
            <div class="card-body">
                <label for="email"></label>
                <input type="text" class="form-control" id="email" name="u" aria-describedby="emailHelp" placeholder="Username">
                <small id="emailHelp" class="form-text text-white"></small>
              
              <div class="form-group">
                <label for="password"></label>
                <input type="password" class="form-control" name="p" id="password" placeholder="Password">
              </div>
              <br>
              <button type="submit" id="btn" class="btn btn-block">Login</button>
            </div>
           <!--  <a href="#" class="ml-4 mb-3 text-light">Forgot passowrd?</a> -->
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
 <!--  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> -->
</body>

</html>
