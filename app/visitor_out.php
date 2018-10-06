 <?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();
  $errors = array();
  $form_id = '';
  $visitor_id = '';


  if(isset($_GET) && !empty($_GET)){
    $form_id = clean($_GET['form_id']);
    $visitor_id = clean($_GET['visitor_id']);
    $sql_field_search = "SELECT * FROM form_structure WHERE form_id=? AND account_id=?";
		if($stmt_field_search = mysqli_prepare($conn, $sql_field_search)){
			mysqli_stmt_bind_param($stmt_field_search, "ss", $param_form_id, $param_account_id);
			$param_form_id = $form_id;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_field_search)){
				$result_field_search = mysqli_stmt_get_result($stmt_field_search);
				$row_field_search = mysqli_fetch_array($result_field_search);
			}
		}

    $sql_visitor_detail = "SELECT * FROM visitor WHERE visitor_id=?";
    if($stmt_visitor_detail = mysqli_prepare($conn, $sql_visitor_detail)){
      mysqli_stmt_bind_param($stmt_visitor_detail, "s", $param_visitor_id);
      $param_visitor_id = $visitor_id;
      if(mysqli_stmt_execute($stmt_visitor_detail)){
        $result_visitor_detail = mysqli_stmt_get_result($stmt_visitor_detail);
        $row_visitor_detail = mysqli_fetch_array($result_visitor_detail, MYSQLI_ASSOC);
      }
    }
  }

  if(isset($_POST) && !empty($_POST)){
    $visitor_id = clean($_POST['visitor_id']);
    $form_id = clean($_POST['form_id']);

    if(!empty($_POST['host_otp'])){
      $submitted_host_otp = '';
      $submitted_host_otp = clean($_POST['host_otp']);
      if(strlen($submitted_host_otp) != 6){
        $errors[] .= 'OTP needs to be 6 digits';
      }
      $sql_host_otp = "SELECT * FROM visitor WHERE visitor_id=? AND form_id=? AND account_id=?";
      if($stmt_host_otp = mysqli_prepare($conn, $sql_host_otp)){
        mysqli_stmt_bind_param($stmt_host_otp, "sss", $param_visitor_id, $param_form_id, $param_account_id);
        $param_visitor_id = $visitor_id;
        $param_form_id = $form_id;
        $param_account_id = $accountId;
        if(mysqli_stmt_execute($stmt_host_otp)){
          $result_host_otp = mysqli_stmt_get_result($stmt_host_otp);
          $row_host_otp = mysqli_fetch_array($result_host_otp);
          $host_otp = $row_host_otp['host_otp'];
          $host_otp_expired = $row_host_otp['host_otp_expired'];
          $host_otp_created = $row_host_otp['host_otp_created'];
          if($submitted_host_otp != $host_otp){
            $errors[] .= 'OTP does not match!';
          }

          if($submitted_host_otp == $host_otp){
            if($host_otp_expired == 0){
              $errors[] .= 'OTP has expired. Click RESEND OTP';
            }

            $sql_update_otp = "UPDATE visitor SET host_otp_expired = 0, date_time_out=? WHERE visitor_id=? AND account_id=?";
            if($stmt_update_otp = mysqli_prepare($conn, $sql_update_otp)){
              mysqli_stmt_bind_param($stmt_update_otp, "sss", $param_date_time_in, $param_visitor_id, $param_account_id);
  						$param_date_time_in = date("Y-m-d H:i:s");
              $param_visitor_id = $visitor_id;
              $param_account_id = $accountId;
              if(mysqli_stmt_execute($stmt_update_otp)){
                header("location: index.php");
              }
            }
          }
        }
      }
    }else{
      $host_otp = '';
    }

    if(!empty($_POST['exit_visitor'])){
      $exit_visitor = clean($_POST['exit_visitor']);
      if($exit_visitor == "No"){
        header('Location: index.php');
      }

      if($exit_visitor == 1){
        $sql_update_otp = "UPDATE visitor SET date_time_out=? WHERE visitor_id=? AND account_id=?";
        if($stmt_update_otp = mysqli_prepare($conn, $sql_update_otp)){
          mysqli_stmt_bind_param($stmt_update_otp, "sss", $param_date_time_out, $param_visitor_id, $param_account_id);
          $param_date_time_out = date("Y-m-d H:i:s");
          $param_visitor_id = $visitor_id;
          $param_account_id = $accountId;
          if(mysqli_stmt_execute($stmt_update_otp)){
            header("location: index.php");
          }
        }
      }

    }else{
      $exit_visitor = '';
    }




  }//post
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
                <h3>Visitor Out</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="visitor_out.php?visitor_id=<?=$visitor_id;?>&form_id=<?=$form_id;?>" method="POST">
                        <div>
                          <input type="hidden" name="form_id" value="<?=$form_id?>"/>
                          <input type="hidden" name="visitor_id" value="<?=$visitor_id?>"/>
                          <?php
                            if($row_field_search['email_notification'] == "both" || $row_field_search['email_notification'] == "host"){
                              echo '<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">OTP
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" name="host_otp" class="form-control" required=""/>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <a href="visitor_view.php" class="btn btn-warning" type="button">Cancel</a>
                                  <button type="submit" class="btn btn-success">Next</button>
                                </div>
                              </div>';
                            }else{
                              echo'<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Exit Visitor?
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="exit_visitor">
                                  <option value="1">Yes</option>
                                  <option>No</option>
                                </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <a href="visitor_view.php" class="btn btn-warning" type="button">Cancel</a>
                                  <button type="submit" class="btn btn-success">Next</button>
                                </div>
                              </div>';
                            }
                          ?>


                        <div class="ln_solid"></div>
                      </div>
                    </form>
                      <!--form end-->
                      <div class="clearfix"></div>
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                            <div class="clearfix"></div>
                            <div class="x_content">
          										<div class="table-responsive">
          											<table class="table table-bordered">
          												<tbody>
          													<tr>
          														<td><b>Visitor Name</b></td>
          														<td><?=$row_visitor_detail['visitor_name']?></td>
          														<td><b>Host Name</b></td>
          														<td><?=$row_visitor_detail['host_name']?></td>
          													</tr>
          													<tr>
          														<td><b>Visitor Email</b></td>
          														<td><?=$row_visitor_detail['visitor_email']?></td>
          														<td><b>Host Email</b></td>
          														<td><?=$row_visitor_detail['host_email']?></td>
          													</tr>
          													<tr>
          														<td><b>Visitor Phone</b></td>
          														<td><?=$row_visitor_detail['visitor_phone']?></td>
          														<td><b>Host Phone</b></td>
          														<td><?=$row_visitor_detail['host_phone']?></td>
          													</tr>
          													<tr>
          														<td><b>In</b></td>
          														<td><?=$row_visitor_detail['date_time_in']?></td>
          														<td><b>Location Level</b></td>
          														<td><?=$row_visitor_detail['host_name']?></td>
          													</tr>
          													<tr>
          														<td><b>Out</b></td>
          														<td><?=$row_visitor_detail['date_time_out']?></td>
          														<td><b>Location Name</b></td>
          														<td><?=$row_visitor_detail['host_name']?></td>
          													</tr>
          													<tr>
          														<td><b>ID</b></td>
          														<td><?=$row_visitor_detail['id']?></td>
          														<td><b>Notes</b></td>
          														<td><?=$row_visitor_detail['notes']?></td>
          													</tr>
          												</tbody>
          											</table>
          										</div>
          										<div class="table-responsive">
          											<table class="table table-bordered">
          												<tbody>
          													<tr>
          														<td><b>Visitor Photo</b></td>
          														<td><b>ID Card Photo</b></td>
          													</tr>
          													<tr>
          														<td><div class="image view view-first"><img style="width:100%" src="<?=$row_visitor_detail['image_path']?>" alt="VisiMonk - Visitor Image Not Available." /></div></td>
          														<td><div class="image view view-first"><img style="width:100%" src="<?=$row_visitor_detail['photo_id_path']?>" alt="VisiMonk - Visitor ID Image Not Available." /></div></td>
          													</tr>
          												</tbody>
          											</table>
          										</div>
                            </div>
                          </div>
                        </div>
                      </div>
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
