<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();
  $errors = array();

  if(isset($_POST) && !empty($_POST)){
		$ve = clean($_POST['email']);
		$vp = clean($_POST['phone']);

		if(empty($ve || $vp)){
      $errors[] .= 'Please fill either phone or email!';
    }

    if(empty($errors)){
			if(!empty($_POST['email'])){
				print_r($_POST);
				$sql_email_visitor = "SELECT * FROM visitor WHERE visitor_email=? AND account_id=? ORDER BY date_time_in DESC";
				if($stmt_email_visitor = mysqli_prepare($conn, $sql_email_visitor)){
					mysqli_stmt_bind_param($stmt_email_visitor, "ss", $param_visitor_email, $param_account_id);
					$param_visitor_email = $ve;
					$param_account_id = $accountId;
					if(mysqli_stmt_execute($stmt_email_visitor)){
						$result_email_visitor = mysqli_stmt_get_result($stmt_email_visitor);
						if(mysqli_num_rows($result_email_visitor) != 0){
							$row_email_visitor = mysqli_fetch_array($result_email_visitor);
							$form_id = $row_email_visitor['form_id'];
							$visitor_id = $row_email_visitor['visitor_id'];
						}
					}
				}
			}

			if(!empty($_POST['phone'])){
				$sql_phone_visitor = "SELECT * FROM visitor WHERE visitor_phone=? AND account_id=? ORDER BY date_time_in DESC";
				if($stmt_phone_visitor = mysqli_prepare($conn, $sql_phone_visitor)){
					mysqli_stmt_bind_param($stmt_phone_visitor, "ss", $param_visitor_phone, $param_account_id);
					$param_visitor_phone = $vp;
					$param_account_id = $accountId;
					if(mysqli_stmt_execute($stmt_phone_visitor)){
						$result_phone_visitor = mysqli_stmt_get_result($stmt_phone_visitor);
						if(mysqli_num_rows($result_phone_visitor) != 0){
							$row_phone_visitor = mysqli_fetch_array($result_phone_visitor);
							$form_id = $row_phone_visitor['form_id'];
							$visitor_id = $row_phone_visitor['visitor_id'];
						}
					}
				}
			}

      header("location: visitor_out.php?form_id=$form_id&visitor_id=$visitor_id");
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
                <h3>Visitor Out:Enter Phone or Email</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="exit_visitor.php" method="POST">
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
