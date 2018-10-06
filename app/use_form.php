<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$errors = array();
	$form_id = '';
	$visitor_name = '';
	$gender = '';
	$visitor_type='';
	$visitor_email = '';
	$visitor_phone = '';
	$id = '';
	$id_photo = '';
	$host_name = '';
	$host_email = '';
	$host_phone = '';
	$notes = '';
	$location_level = '';
	$location_id = '';


	if(isset($_GET) && !empty($_GET)){
		$form_id = clean($_GET['fd']);
		$location_level = clean($_GET['ll']);
		$location_id = clean($_GET['ld']);
		$visitor_email = clean($_GET['ve']);
		$visitor_phone = clean($_GET['vp']);

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

		$text = $location_level.'_id';

		$sql_location = "SELECT * FROM `$location_level` WHERE $text=?";
		if($stmt_location = mysqli_prepare($conn, $sql_location)){
			mysqli_stmt_bind_param($stmt_location, "s", $param_location_id);
			$param_location_id = $location_id;
			if(mysqli_stmt_execute($stmt_location)){
				$result_location = mysqli_stmt_get_result($stmt_location);
				$row_location = mysqli_fetch_array($result_location);
				$location_name = $row_location[$location_level."_description"];
			}
		}



		if(!empty($_GET['ve'])){
			$sql_email_visitor = "SELECT * FROM visitor WHERE visitor_email=? AND account_id=?";
			if($stmt_email_visitor = mysqli_prepare($conn, $sql_email_visitor)){
				mysqli_stmt_bind_param($stmt_email_visitor, "ss", $param_visitor_email, $param_account_id);
				$param_visitor_email = $visitor_email;
				$param_account_id = $accountId;
				if(mysqli_stmt_execute($stmt_email_visitor)){
					$result_email_visitor = mysqli_stmt_get_result($stmt_email_visitor);
					if(mysqli_num_rows($result_email_visitor) != 0){
						$row_email_visitor = mysqli_fetch_array($result_email_visitor);
						$visitor_name = $row_email_visitor['visitor_name'];
						$visitor_email = $row_email_visitor['visitor_email'];
						$visitor_phone = $row_email_visitor['visitor_phone'];
						$gender = $row_email_visitor['gender'];
						$visitor_type = $row_email_visitor['visitor_type'];
						$host_name = $row_email_visitor['host_name'];
					}else{
						$visitor_email = clean($_GET['ve']);
						$visitor_phone = clean($_GET['vp']);
					}
				}
			}
		}

			if(!empty($_GET['vp'])){
				$sql_phone_visitor = "SELECT * FROM visitor WHERE visitor_phone=? AND account_id=?";
				if($stmt_phone_visitor = mysqli_prepare($conn, $sql_phone_visitor)){
					mysqli_stmt_bind_param($stmt_phone_visitor, "ss", $param_visitor_phone, $param_account_id);
					$param_visitor_phone = $visitor_phone;
					$param_account_id = $accountId;
					if(mysqli_stmt_execute($stmt_phone_visitor)){
						$result_phone_visitor = mysqli_stmt_get_result($stmt_phone_visitor);
						if(mysqli_num_rows($result_phone_visitor) != 0){
							$row_phone_visitor = mysqli_fetch_array($result_phone_visitor);
							$visitor_name = $row_phone_visitor['visitor_name'];
							$visitor_email = $row_phone_visitor['visitor_email'];
							$visitor_phone = $row_phone_visitor['visitor_phone'];
							$gender = $row_phone_visitor['gender'];
							$visitor_type = $row_phone_visitor['visitor_type'];
							$host_name = $row_phone_visitor['host_name'];
						}else{
							$visitor_email = clean($_GET['ve']);
							$visitor_phone = clean($_GET['vp']);
						}
					}
				}
			}
	}

	if(isset($_POST) && !empty($_POST)){
		$form_id = clean($_POST['form_id']);
		$visitor_name = clean($_POST['visitor_name']);
		$gender = clean($_POST['gender']);
		$visitor_type = clean($_POST['visitor_type']);
		$visitor_email = clean($_POST['visitor_email']);
		$visitor_phone = clean($_POST['visitor_phone']);
		$id = clean($_POST['id']);
		$host_name = clean($_POST['host_name']);
		$host_email = clean($_POST['host_email']);
		$host_phone = clean($_POST['host_phone']);
		$notes = clean($_POST['notes']);
		$location_level = clean($_POST['location_level']);
		$location_id = clean($_POST['location_id']);


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

		//create a visitor id
		$visitor_id = md5($userId.microtime());
		$sql_visitor = "INSERT INTO visitor (visitor_id,account_id,location_level,location_id,date_time_in) VALUES(?,?,?,?,?)";
		if($stmt_visitor = mysqli_prepare($conn, $sql_visitor)){
			mysqli_stmt_bind_param($stmt_visitor, "sssss", $param_visitor_id, $param_account_id, $param_location_level, $param_location_id, $param_date_time_in);
			$param_visitor_id = $visitor_id;
			$param_account_id = $accountId;
			$param_location_level = $location_level;
			$param_location_id = $location_id;
			$param_date_time_in = date("Y-m-d H:i:s");
			if(!mysqli_stmt_execute($stmt_visitor)){
				echo 'Something went wrong. Please try again!';
			}
		}

		//update visitor table with input data
		$sql_visitor_update = "UPDATE visitor
														SET visitor_name = '$visitor_name',
																gender = '$gender',
																visitor_type = '$visitor_type',
														 		visitor_email = '$visitor_email',
																visitor_phone = '$visitor_phone',
																id = '$id',
																host_name = '$host_name',
																host_email = '$host_email',
																host_phone = '$host_phone',
																notes = '$notes',
																user_id = $userId,
																form_id = $form_id
														WHERE visitor_id=?";
		if($stmt_visitor_update = mysqli_prepare($conn, $sql_visitor_update)){
			mysqli_stmt_bind_param($stmt_visitor_update, "s", $param_visitor_id);
			$param_visitor_id = $visitor_id;
			if(mysqli_stmt_execute($stmt_visitor_update)){


				if($row_field_search['email_notification'] == "off"){
					if($row_field_search['camera'] == 1){
						header("location: use_form_2.php?form_id=$form_id&visitor_id=$visitor_id");
					}elseif($row_field_search['id_photo'] == 1){
						header("location: use_form_4.php?form_id=$form_id&visitor_id=$visitor_id");
					}else{
						$sql_update_in = "UPDATE visitor SET date_time_in=? WHERE visitor_id=? AND account_id=?";
						if($stmt_update_in = mysqli_prepare($conn, $sql_update_in)){
							mysqli_stmt_bind_param($stmt_update_in, "sss", $param_date_time_in, $param_visitor_id, $param_account_id);
							$param_date_time_in = date("Y-m-d H:i:s");
							$param_visitor_id = $visitor_id;
							$param_account_id = $accountId;
							if(mysqli_stmt_execute($stmt_update_in)){
								header("location: visitor_complete.php?fd=$form_id&ll=$location_level&ld=$location_id");
							}
						}
					}
				}

				//otp process begin
				if($row_field_search['email_notification'] == "both"){
					$visitor_otp = rand(100000, 999999);
					$host_otp = rand(100000, 999999);
					//mail function to send OTP
					//update database
					$sql_otp = "UPDATE visitor SET visitor_otp = ?,
											visitor_otp_created = ?,
											visitor_otp_expired = ?,
											host_otp = ?,
											host_otp_created = ?,
											host_otp_expired = ?
											WHERE visitor_id = ?";
					if($stmt_otp = mysqli_prepare($conn, $sql_otp)){
						mysqli_stmt_bind_param($stmt_otp, "sssssss", $param_visitor_otp, $param_visitor_otp_created, $param_visitor_otp_expired,
						$param_host_otp, $param_host_otp_created, $param_host_otp_expired, $param_visitor_id);
						$param_visitor_otp = $visitor_otp;
						$param_visitor_otp_created = date("Y-m-d H:i:s");
						$param_visitor_otp_expired = 0;
						$param_host_otp = $host_otp;
						$param_host_otp_created = date("Y-m-d H:i:s");
						$param_host_otp_expired = 0;
						$param_visitor_id = $visitor_id;
						if(mysqli_stmt_execute($stmt_otp)){
							$sql_visitor_data = "SELECT * FROM visitor WHERE visitor_id = ? AND account_id=?";
							if($stmt_visitor_data = mysqli_prepare($conn, $sql_visitor_data)){
								mysqli_stmt_bind_param($stmt_visitor_data, "ss", $param_visitor_id, $param_account_id);
								$param_visitor_id = $visitor_id;
								$param_account_id = $accountId;
								if(mysqli_stmt_execute($stmt_visitor_data)){
									$result_visitor_data = mysqli_stmt_get_result($stmt_visitor_data);
									$row_visitor_data = mysqli_fetch_array($result_visitor_data, MYSQLI_ASSOC);
										$visitor_name = clean($row_visitor_data['visitor_name']);
										$visitor_email = clean($row_visitor_data['visitor_email']);
										$host_name = clean($row_visitor_data['host_name']);
										$host_email = clean($row_visitor_data['host_email']);
										$visitor_otp = clean($row_visitor_data['visitor_otp']);
										$host_otp = clean($row_visitor_data['host_otp']);
										$to = "$visitor_email";
										$subject = 'VisiMonk OTP!';
										$message = 'Dear '.$visitor_name.",". "\r\n"."\r\n".
						        'Thank you for using VisiMonk'. "\r\n".
						        'Please enter the below OTP to validate your visit!'. "\r\n".
						        $visitor_otp. "\r\n"."\r\n".
						        'Regards,'. "\r\n".
										'Team VisiMonk'. "\r\n";
										$headers = 'From: visitorotp@visimonk.com' . "\r\n" .
				             'Reply-To: support@visimonk.com' . "\r\n" .
				             'X-Mailer: PHP/' . phpversion();
										 mail($to, $subject, $message, $headers);

										 $to = "$host_email";
 										$subject = 'VisiMonk OTP!';
 										$message = 'Dear '.$host_name.",". "\r\n"."\r\n".
 						        'Thank you for using VisiMonk'. "\r\n".
 						        'Please give the below OTP to: '.$visitor_name. "\r\n".
										'Visitor Email: '.$visitor_email. "\r\n".
 						        $host_otp. "\r\n"."\r\n".
 						        'Regards,'. "\r\n".
 										'Team VisiMonk'. "\r\n";
 										$headers = 'From: hostotp@visimonk.com' . "\r\n" .
 				             'Reply-To: support@visimonk.com' . "\r\n" .
 				             'X-Mailer: PHP/' . phpversion();
 										 mail($to, $subject, $message, $headers);
								}
							}

							if($row_field_search['camera'] == 1){
								header("location: use_form_2.php?form_id=$form_id&visitor_id=$visitor_id");
							}elseif($row_field_search['id_photo'] == 1){
								header("location: use_form_4.php?form_id=$form_id&visitor_id=$visitor_id");
							}else{
								header("location: use_form_3.php?form_id=$form_id&visitor_id=$visitor_id");
							}
						}
					}
				}//both

				if($row_field_search['email_notification'] == "host"){
					$host_otp = rand(100000, 999999);
					//mail function to send OTP
					//update database
					$sql_otp = "UPDATE visitor SET host_otp = ?,
											host_otp_created = ?,
											host_otp_expired = ?
											WHERE visitor_id = ?";
					if($stmt_otp = mysqli_prepare($conn, $sql_otp)){
						mysqli_stmt_bind_param($stmt_otp, "ssss", $param_host_otp, $param_host_otp_created, $param_host_otp_expired, $param_visitor_id);
						$param_host_otp = $host_otp;
						$param_host_otp_created = date("Y-m-d H:i:s");
						$param_host_otp_expired = 0;
						$param_visitor_id = $visitor_id;
						if(mysqli_stmt_execute($stmt_otp)){
							$sql_visitor_data = "SELECT * FROM visitor WHERE visitor_id = ? AND account_id=?";
							if($stmt_visitor_data = mysqli_prepare($conn, $sql_visitor_data)){
								mysqli_stmt_bind_param($stmt_visitor_data, "ss", $param_visitor_id, $param_account_id);
								$param_visitor_id = $visitor_id;
								$param_account_id = $accountId;
								if(mysqli_stmt_execute($stmt_visitor_data)){
									$result_visitor_data = mysqli_stmt_get_result($stmt_visitor_data);
									$row_visitor_data = mysqli_fetch_array($result_visitor_data, MYSQLI_ASSOC);
										$visitor_name = clean($row_visitor_data['visitor_name']);
										$visitor_email = clean($row_visitor_data['visitor_email']);
										$host_name = clean($row_visitor_data['host_name']);
										$host_email = clean($row_visitor_data['host_email']);
										$visitor_otp = clean($row_visitor_data['visitor_otp']);
										$host_otp = clean($row_visitor_data['host_otp']);

										 $to = "$host_email";
 										$subject = 'VisiMonk OTP!';
 										$message = 'Dear '.$host_name.",". "\r\n"."\r\n".
 						        'Thank you for using VisiMonk'. "\r\n".
 						        'Please give the below OTP to: '.$visitor_name. "\r\n".
										'Visitor Email: '.$visitor_email. "\r\n".
 						        $host_otp. "\r\n"."\r\n".
 						        'Regards,'. "\r\n".
 										'Team VisiMonk'. "\r\n";
 										$headers = 'From: hostotp@visimonk.com' . "\r\n" .
 				             'Reply-To: support@visimonk.com' . "\r\n" .
 				             'X-Mailer: PHP/' . phpversion();
 										 mail($to, $subject, $message, $headers);
								}
							}
							if($row_field_search['camera'] == 1){
								header("location: use_form_2.php?form_id=$form_id&visitor_id=$visitor_id");
							}elseif($row_field_search['id_photo'] == 1){
								header("location: use_form_4.php?form_id=$form_id&visitor_id=$visitor_id");
							}else{
								$sql_update_in = "UPDATE visitor SET date_time_in=? WHERE visitor_id=? AND account_id=?";
								if($stmt_update_in = mysqli_prepare($conn, $sql_update_in)){
									mysqli_stmt_bind_param($stmt_update_in, "sss", $param_date_time_in, $param_visitor_id, $param_account_id);
									$param_date_time_in = $param_date_time_in = date("Y-m-d H:i:s");
									$param_visitor_id = $visitor_id;
									$param_account_id = $accountId;
									if(mysqli_stmt_execute($stmt_update_in)){

									}
								}
								header("location: visitor_complete.php?fd=$form_id&ll=$location_level&ld=$location_id");
							}
						}
					}
				}//host

				if($row_field_search['email_notification'] == "visitor"){
					$visitor_otp = rand(100000, 999999);
					//mail function to send OTP
					//update database
					$sql_otp = "UPDATE visitor SET visitor_otp = ?,
											visitor_otp_created = ?,
											visitor_otp_expired = ?
											WHERE visitor_id = ?";
					if($stmt_otp = mysqli_prepare($conn, $sql_otp)){
						mysqli_stmt_bind_param($stmt_otp, "ssss", $param_visitor_otp, $param_visitor_otp_created, $param_visitor_otp_expired, $param_visitor_id);
						$param_visitor_otp = $visitor_otp;
						$param_visitor_otp_created = date("Y-m-d H:i:s");
						$param_visitor_otp_expired = 0;
						$param_visitor_id = $visitor_id;
						if(mysqli_stmt_execute($stmt_otp)){
							$sql_visitor_data = "SELECT * FROM visitor WHERE visitor_id = ? AND account_id=?";
							if($stmt_visitor_data = mysqli_prepare($conn, $sql_visitor_data)){
								mysqli_stmt_bind_param($stmt_visitor_data, "ss", $param_visitor_id, $param_account_id);
								$param_visitor_id = $visitor_id;
								$param_account_id = $accountId;
								if(mysqli_stmt_execute($stmt_visitor_data)){
									$result_visitor_data = mysqli_stmt_get_result($stmt_visitor_data);
									$row_visitor_data = mysqli_fetch_array($result_visitor_data, MYSQLI_ASSOC);
										$visitor_name = clean($row_visitor_data['visitor_name']);
										$visitor_email = clean($row_visitor_data['visitor_email']);
										$visitor_otp = clean($row_visitor_data['visitor_otp']);
										$to = "$visitor_email";
										$subject = 'VisiMonk OTP!';
										$message = 'Dear '.$visitor_name.",". "\r\n"."\r\n".
						        'Thank you for using VisiMonk'. "\r\n".
						        'Please enter the below OTP to validate your visit!'. "\r\n".
						        $visitor_otp. "\r\n"."\r\n".
						        'Regards,'. "\r\n".
										'Team VisiMonk'. "\r\n";
										$headers = 'From: visitorotp@visimonk.com' . "\r\n" .
				             'Reply-To: support@visimonk.com' . "\r\n" .
				             'X-Mailer: PHP/' . phpversion();
										 mail($to, $subject, $message, $headers);
								}
							}
							if($row_field_search['camera'] == 1){
								header("location: use_form_2.php?form_id=$form_id&visitor_id=$visitor_id");
							}elseif($row_field_search['id_photo'] == 1){
								header("location: use_form_4.php?form_id=$form_id&visitor_id=$visitor_id");
							}else{
								header("location: use_form_3.php?form_id=$form_id&visitor_id=$visitor_id");
							}
						}
					}
				}//visitor
			}
		}


	}//POST

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
                <h3>Visitor Form: <?=$row_field_search['form_name'];?></h3>
              </div>
							<div class="title_right">
                <h3>Location: <?=$location_name;?></h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="use_form.php" method="POST">
												<input type="hidden" name="form_id" value="<?=$form_id;?>"/>
												<input type="hidden" name="location_level" value="<?=$location_level;?>"/>
												<input type="hidden" name="location_id" value="<?=$location_id;?>"/>

												<div>
													<?php if($row_field_search['visitor_name'] == 1):?>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="full-name">Visitor Name
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input type="text" name="visitor_name" value="<?=$visitor_name;?>" class="form-control" required=""/>
															</div>
														</div>
													<?php endif;?>
													<?php if($row_field_search['gender'] == 1):?>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">Gender
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="gender">
																<option <?=($gender == 'male')?'selected':''?> value="male">Male</option>
																<option <?=($gender == 'female')?'selected':''?> value="female">Female</option>
															</select>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="visitor_type">Visitor Type
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="visitor_type">
																<option <?=($visitor_type == 'visitor')?'selected':''?> value="visitor">Visitor</option>
																<option <?=($visitor_type == 'vendor')?'selected':''?> value="vendor">Vendor</option>
																<option <?=($visitor_type == 'employee')?'selected':''?> value="employee">Employee</option>
															</select>
															</div>
														</div>
													<?php endif;?>
													<?php if($row_field_search['email'] == 1):?>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input type="email" name="visitor_email" value="<?=$visitor_email?>" class="form-control" required=""/>
															</div>
														</div>
													<?php endif;?>
													<?php if($row_field_search['phone'] == 1):?>
														<div class="form-group" id="phone">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone-field">Phone
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input type="number" name="visitor_phone" value="<?=$visitor_phone?>" min="0" class="form-control" required=""/>
															</div>
														</div>
													<?php endif;?>
													<?php
														if($row_field_search['id'] == 1){
															echo '<div class="form-group" id="identifier">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identifier-field">ID
				                        </label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="text" name="id" class="form-control" required=""/>
																</div>
														</div>';
													}else{
														echo '<input name="id" type="hidden" value="NULL"/>';
													}
													?>

														<?php if($row_field_search['host_name'] == 1):?>
															<div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Host Name
				                        </label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="text" name="host_name" class="form-control" required="" value="<?=$host_name?>"/>
																</div>
				                      </div>
														<?php endif; ?>

														<?php
														if($row_field_search['host_email'] == 1){
															echo '<div class="form-group" id="hEmail">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Host Email
				                        </label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="email" name="host_email" class="form-control" required=""/>
																</div>
				                      </div>';
														}else{
															echo '<input name="host_email" type="hidden" value="NULL"/>';
														}

														if($row_field_search['host_phone'] == 1){
															echo '<div class="form-group" id="hPhone">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Host Phone
				                        </label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="number" name="host_phone" min="0" class="form-control" required=""/>
																</div>
				                      </div>';
														}else{
															echo '<input name="host_phone" type="hidden" value="NULL"/>';
														}

														if($row_field_search['notes'] == 1){
															echo '<div class="form-group" id="notes">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes
				                        </label>
				                        <div class="col-md-6 col-sm-6 col-xs-12">
																	<textarea name="notes" class="form-control" required=""></textarea>
				                        </div>
				                      </div>';
														}else{
															echo '<input name="notes" type="hidden" value="NULL"/>';
														}


													?>


	                      <div class="ln_solid"></div>
	                      <div class="form-group">
	                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          <a href="form_edit_view.php" class="btn btn-warning" type="button">Cancel</a>
	                          <button id="take_snapshots" type="submit" class="btn btn-success">Next</button>
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
