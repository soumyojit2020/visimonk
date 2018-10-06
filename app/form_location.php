<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();
  $errors = array();
  $form_id = '';

  if(isset($_GET) && !empty($_GET)){
    $form_id = clean($_GET['fd']);
		$location_level = clean($_GET['ll']);
		$location_id = clean($_GET['ld']);
  }

  if(isset($_POST) && !empty($_POST)){
    $form_id = clean($_POST['form_id']);
    $location_level = clean($_POST['location_level']);
    $location_id = clean($_POST['location_id']);
		$ve = clean($_POST['email']);
		$vp = clean($_POST['phone']);

    if(empty($form_id)){
      $errors[] .= 'Something went wrong. Please try again.';
    }

    if(empty($location_level)){
      $errors[] .= 'Something went wrong. Please try again.';
    }

    if(empty($location_id)){
      $errors[] .= 'Something went wrong. Please try again.';
    }

		if(empty($ve || $vp)){
      $errors[] .= 'Please fill either phone or email!';
    }

    if(empty($errors)){
      header("location: use_form.php?fd=$form_id&ll=$location_level&ld=$location_id&ve=$ve&vp=$vp");
    }
  }
?>
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <?php include 'include/brand.php'; ?>
            <div class="clearfix"></div>
            <br />
            <?php
				include 'include/sidebarMenu.php';
			?>
          </div>
        </div>
        <?php
			include 'include/topNav.php';
		?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Enter Phone or Email</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div>
											<?php
												if(!empty($errors)){
													echo display_errors($errors);
												}
											?>
										</div>
                      <form data-parsley-validate class="form-horizontal form-label-left" action="form_location.php" method="POST">
                        <input type="hidden" name="form_id" value="<?=$form_id?>"/>
												<input type="hidden" name="location_level" value="<?=$location_level?>"/>
												<input type="hidden" name="location_id" value="<?=$location_id?>"/>
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
														</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" id="phone" name="phone" class="form-control col-md-7 col-xs-12" value=""/>
														</div>
													</div>
													<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
		                          <input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" value=""/>
		                        </div>
		                      </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a class="btn btn-warning" href="form_edit_view.php" type="button">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
        <?php
			include 'include/footer.php';
		?>
      </div>
    </div>
<?php
	include 'include/script.php';
?>
