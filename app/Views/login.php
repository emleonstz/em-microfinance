<?php helper('form') ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css') ?>">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
  <script src="<?php echo base_url('assets/jquery/jquery-3.7.0.min.js') ?>"></script>
  <title>Login</title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div>
      <h2 class="text-white">ANY MICROFINANCE</h2>
    </div>
    <div class="login-box">
      <?php if (empty($state)) : ?>
        <form class="login-form" method="post" action="/auth">
          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
              <i class="fa fa-exclamation-triangle fa-2x mx-2" aria-hidden="true"></i>&nbsp;
              <div>
                <?= session()->getFlashdata('error') ?>
              </div>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>
          <?= validation_list_errors() ?>
          <?= csrf_field() ?>
          <center><h3 class="">Ingia ilikuendelea</h3></center>
          <div class="form-group">
            <label class="control-label">BARUAPEPE</label>
            <input class="form-control" name="email" type="text" placeholder="weka barua pepe" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" name="password" type="password" placeholder="weka neno la siri">
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox"><span class="label-text">Stay Signed in</span>
                </label>
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      <?php else : ?>
        <div class="alert alert-danger" role="alert">
          <h4 class="alert-heading">Umepigwa marufuku kwa muda!</h4>
          <p><?= session()->getFlashdata('ban') ?>.</p>
          <hr>
          <p class="mb-0">Jaribu tena baada ya dakika <?php if (!empty($state['ban'])) {
                                                        echo date("i:s", $state['ban']);
                                                      } ?></p>
        </div>

      <?php endif; ?>
      <form class="forget-form" action="index.html">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
        <div class="form-group">
          <label class="control-label">EMAIL</label>
          <input class="form-control" type="text" placeholder="Email">
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
        </div>
      </form>
    </div>
  </section>