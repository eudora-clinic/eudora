<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
 
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
	  Login System App
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="<?=base_url()?>assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?=base_url()?>assets/demo/demo.css" rel="stylesheet" />
  <style>
    .main-panel {
      width: 100%;
    }

    .card-profile {
      text-align: left;
    }
    .card-profile .card-avatar {
		max-width: 100px;
		max-height: 100px;
		border-radius: 5px;
		padding: 5px;
	}
  </style>
</head>
<body class="" style="background-image: url(assets/img/imagebed.jpg);background-size: cover;">
  <div class="wrapper ">
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <div class="card card-profile">
                <!-- <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="<?=base_url()?>assets/img/oriskin.png" style="margin-top: 0;">
                  </a>
                </div> -->
                <div class="card-body">
                  <?php 
                    $pesan = $this->session->flashdata('pesan');

                    if (isset($pesan) && $pesan != '') { 
                      echo '<div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                              </button>
                              <span>
                                <b> Peringatan - </b>'.$pesan.'</span>
                            </div>';
                    } else {
                      echo '';
                    }
                  ?>
                  <form method="post" action="<?=base_url()?>login">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Username</label>
                          <input type="text" name="name" class="form-control">
                        </div>
                      </div>
                       <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">Password</label>
                          <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password">
                            <div class="input-group-append">
                              <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                <i class="material-icons" id="toggleIcon">visibility_off</i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn" style="width: 100%; background-color: #8c5e4e;">Login<div class="ripple-container"></div></button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4"></div>
          </div>
        </div>
      </div>  
      <!-- <footer class="footer">
        <div class="container-fluid">
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>
          </div>
        </div>
      </footer> -->
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?=base_url()?>assets/js/core/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/js/core/popper.min.js"></script>
  <script src="<?=base_url()?>assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="<?=base_url()?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url()?>assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const toggleIcon = document.getElementById("toggleIcon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.textContent = "visibility";
      } else {
        passwordInput.type = "password";
        toggleIcon.textContent = "visibility_off";
      }
    }
  </script>
</body>
</html>
