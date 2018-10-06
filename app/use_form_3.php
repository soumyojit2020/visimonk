<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $form_id = clean($_GET['form_id']);
    $visitor_id = clean($_GET['visitor_id']);
	}

  if(isset($_POST) && !empty($_POST)){
    $errors = array();
    $form_id = clean($_POST['form_id']);
    $visitor_id = clean($_POST['visitor_id']);
    $visitor_otp = clean($_POST['visitor_otp']);
		$sql_location_search = "SELECT location_level,location_id FROM visitor WHERE visitor_id=?";
	  if($stmt_location_search = mysqli_prepare($conn, $sql_location_search)){
	    mysqli_stmt_bind_param($stmt_location_search, "s", $param_visitor_id);
	    $param_visitor_id = $visitor_id;
	    if(mysqli_stmt_execute($stmt_location_search)){
	      $result_location_search = mysqli_stmt_get_result($stmt_location_search);
	      $row_location_search = mysqli_fetch_array($result_location_search);
	      $location_level = $row_location_search['location_level'];
	      $location_id = $row_location_search['location_id'];
	    }
	  }

    if(empty($visitor_otp)){
      $errors[] .= 'Please enter OTP!';
    }

    if(strlen($visitor_otp) != 6){
      $errors[] .= 'OTP needs to be 6 digits';
    }

    //verify otp
    $sql_verify_otp = "SELECT * FROM visitor WHERE visitor_id=? AND form_id=?";
    if($stmt_verify_otp = mysqli_prepare($conn, $sql_verify_otp)){
      mysqli_stmt_bind_param($stmt_verify_otp, "ss", $param_visitor_id, $param_form_id);
      $param_visitor_id = $visitor_id;
      $param_form_id = $form_id;
      if(mysqli_stmt_execute($stmt_verify_otp)){
        $result_verify_otp = mysqli_stmt_get_result($stmt_verify_otp);
        $row_verify_otp = mysqli_fetch_array($result_verify_otp, MYSQLI_ASSOC);
        $submitted_visitor_otp = $row_verify_otp['visitor_otp'];
        $visitor_otp_expired = $row_verify_otp['visitor_otp_expired'];
        $visitor_otp_created = $row_verify_otp['visitor_otp_created'];
        if($visitor_otp != $submitted_visitor_otp){
          $errors[] .= 'Entered OTP does not match';
        }
        if($visitor_otp == $submitted_visitor_otp){
          if($visitor_otp_expired == 0){
            $errors[] .= 'OTP has expired. Click RESEND OTP';
          }
          /*if(NOW() <= DATE_ADD($visitor_otp_created, date_interval_create_from_date_string("120 seconds"))){
            $errors[] .= 'OTP has expired. Click RESEND OTP';
          }*/
          $sql_update_otp = "UPDATE visitor SET visitor_otp_expired = 0, date_time_in=? WHERE visitor_id=? AND account_id=?";
          if($stmt_update_otp = mysqli_prepare($conn, $sql_update_otp)){
            mysqli_stmt_bind_param($stmt_update_otp, "sss", $param_date_time_in, $param_visitor_id, $param_account_id);
						$param_date_time_in = date("Y-m-d H:i:s");
            $param_visitor_id = $visitor_id;
						$param_account_id = $accountId;
            if(mysqli_stmt_execute($stmt_update_otp)){
              header("location: visitor_complete.php?fd=$form_id&ll=$location_level&ld=$location_id");
            }
          }
        }
      }
    }
  }



?>
  <body class="nav-md">
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
                <h3>Visitor Form: Enter OTP sent to Phone/Email</h3>
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
                      <!--form start-->
                      <form data-parsley-validate class="form-horizontal form-label-left" action="use_form_3.php?visitor_id=<?=$visitor_id;?>&form_id=<?=$form_id;?>" method="POST">
												<div>
                          <input type="hidden" name="form_id" value="<?=$form_id?>"/>
                          <input type="hidden" name="visitor_id" value="<?=$visitor_id?>"/>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">OTP
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="visitor_otp" class="form-control" required=""/>
                            </div>
                          </div>
	                      <div class="ln_solid"></div>
	                      <div class="form-group">
	                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          <a href="form_edit_view.php" class="btn btn-warning" type="button">Cancel</a>
	                          <button type="submit" class="btn btn-success">Next</button>
	                        </div>
	                      </div>
											</div>
                    </form>
                      <!--form end-->
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
