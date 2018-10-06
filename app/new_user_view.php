<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$full_name = '';
	$email = '';
	$phone = '';
	$campus = array();
	$building = array();
	$floor = array();
	$area = array();
	$port = array();
	$role =  '';
	$password = '';
	$confirm_password = '';

	$sql_role = "SELECT * FROM role WHERE account_id=? AND active=1";
	if($stmt_role = mysqli_prepare($conn, $sql_role)){
		mysqli_stmt_bind_param($stmt_role, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_role)){
			$result_role = mysqli_stmt_get_result($stmt_role);
		}
	}

	$sql_campus = "SELECT uc.campus_id,c.campus_description
									FROM user_campus uc
									LEFT JOIN campus c
									ON uc.campus_id = c.campus_id
									WHERE uc.account_id=? AND uc.user_id=$userId AND c.active=1";
	if($stmt_campus = mysqli_prepare($conn, $sql_campus)){
		mysqli_stmt_bind_param($stmt_campus, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_campus)){
			$result_campus = mysqli_stmt_get_result($stmt_campus);
		}
	}

	$sql_building = "SELECT uc.building_id,c.building_description
									FROM user_building uc
									LEFT JOIN building c
									ON uc.building_id = c.building_id
									WHERE uc.account_id=? AND uc.user_id=$userId AND c.active=1";
	if($stmt_building = mysqli_prepare($conn, $sql_building)){
		mysqli_stmt_bind_param($stmt_building, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_building)){
			$result_building = mysqli_stmt_get_result($stmt_building);
		}
	}

	$sql_floor = "SELECT uc.floor_id,c.floor_description
									FROM user_floor uc
									LEFT JOIN floor c
									ON uc.floor_id = c.floor_id
									WHERE uc.account_id=? AND uc.user_id=$userId AND c.active=1";
	if($stmt_floor = mysqli_prepare($conn, $sql_floor)){
		mysqli_stmt_bind_param($stmt_floor, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_floor)){
			$result_floor = mysqli_stmt_get_result($stmt_floor);
		}
	}

	$sql_area = "SELECT uc.area_id,c.area_description
									FROM user_area uc
									LEFT JOIN area c
									ON uc.area_id = c.area_id
									WHERE uc.account_id=? AND uc.user_id=$userId AND c.active=1";
	if($stmt_area = mysqli_prepare($conn, $sql_area)){
		mysqli_stmt_bind_param($stmt_area, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_area)){
			$result_area = mysqli_stmt_get_result($stmt_area);
		}
	}

	$sql_port = "SELECT uc.port_id,c.port_description
									FROM user_port uc
									LEFT JOIN port c
									ON uc.port_id = c.port_id
									WHERE uc.account_id=? AND uc.user_id=$userId AND c.active=1";
	if($stmt_port = mysqli_prepare($conn, $sql_port)){
		mysqli_stmt_bind_param($stmt_port, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_port)){
			$result_port = mysqli_stmt_get_result($stmt_port);
		}
	}

	if(isset($_POST) && !empty($_POST)){
		$errors = array();
		$full_name = clean($_POST['full_name']);
		$email = clean($_POST['email']);
		$phone = clean($_POST['phone']);
		if(!empty($_POST['campus'])){
			$campus = $_POST['campus'];
		}else{
			$campus = array();
		}

		if(!empty($_POST['building'])){
			$building = $_POST['building'];
		}else{
			$building = array();
		}

		if(!empty($_POST['floor'])){
			$floor = $_POST['floor'];
		}else{
			$floor = array();
		}

		if(!empty($_POST['area'])){
			$area = $_POST['area'];
		}else{
			$area = array();
		}

		if(!empty($_POST['port'])){
			$port = $_POST['port'];
		} else{
			$port = array();
		}

		$role =  clean($_POST['role']);
		$password = clean($_POST['password']);
		$confirm_password = clean($_POST['confirm_password']);

		if(empty($full_name || $email || $phone || $role || $password || $confirm_password)){
			$errors[] .= 'All fields are mandatory!';
		}

		if(empty($campus || $building || $floor || $area || $port )){
			$errors[] .= 'Assign atleast one location!';
		}

		$sql_duplicate_user = "SELECT email FROM user WHERE email=? AND account_id=?";
		if($stmt_duplicate_user = mysqli_prepare($conn, $sql_duplicate_user)){
			mysqli_stmt_bind_param($stmt_duplicate_user, "ss", $param_email, $param_account_id);
			$param_email = $email;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_duplicate_user)){
				$result_duplicate_user = mysqli_stmt_get_result($stmt_duplicate_user);
				if(mysqli_num_rows($result_duplicate_user)){
					$errors[] .= $email. ' already exists!';
				}
			}
		}

		$sql_duplicate_user = "SELECT phone FROM user WHERE phone=? AND account_id=?";
		if($stmt_duplicate_user = mysqli_prepare($conn, $sql_duplicate_user)){
			mysqli_stmt_bind_param($stmt_duplicate_user, "ss", $param_phone, $param_account_id);
			$param_phone = $phone;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_duplicate_user)){
				$result_duplicate_user = mysqli_stmt_get_result($stmt_duplicate_user);
				if(mysqli_num_rows($result_duplicate_user)){
					$errors[] .= $phone. ' already exists!';
				}
			}
		}

		if($password != $confirm_password){
			$errors[] .= 'Passwords do not match!';
		}

		if(empty($errors)){
			//prepare statement to insert into User Table
			//generate token code
			$tokenCode = md5(uniqid(rand()));
			$userStatus = 'confirmed';
			$sqlUser = "INSERT INTO user(account_id, user_name, phone_number, email, password, user_status, token_code)
			VALUES(?, ?, ?, ?, ?, ?, ?)";
			if($stmtUser = mysqli_prepare($conn, $sqlUser)){
			//bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmtUser, "sssssss", $param_accountId, $param_userName, $param_phoneNumber, $param_email, $param_password, $param_userStatus, $param_tokenCode);
			//set parameters
			$param_accountId = $accountId;
			$param_userName = $full_name;
			$param_phoneNumber = $phone;
			$param_email = $email;
			$param_password = password_hash($password, PASSWORD_DEFAULT);
			$param_userStatus = $userStatus;
			$param_tokenCode = $tokenCode;

			if(mysqli_stmt_execute($stmtUser)){
				$sql_user_id = "SELECT user_id FROM user WHERE email=? AND account_id=?";
				if($stmt_user_id = mysqli_prepare($conn, $sql_user_id)){
					mysqli_stmt_bind_param($stmt_user_id, "ss", $param_email, $param_accountId);
					$param_email = $email;
					$param_accountId = $accountId;
					if(mysqli_stmt_execute($stmt_user_id)){
						$result_user_id = mysqli_stmt_get_result($stmt_user_id);
						$row_user_id = mysqli_fetch_array($result_user_id, MYSQLI_ASSOC);
						$user_id = $row_user_id['user_id'];

						if(isset($campus)){
							$totalCampus = sizeof($campus);
							for($i=0;$i<$totalCampus;$i++){
								$campus_id = $campus[$i];
								$query_campus = "INSERT INTO user_campus (user_id,campus_id,account_id) VALUES($user_id,$campus_id,'$accountId')";
								$execute_campus = mysqli_query($conn, $query_campus);
								$sql_pull_building = "SELECT building_id FROM building WHERE campus_id=? AND account_id=?";
								if($stmt_pull_building = mysqli_prepare($conn, $sql_pull_building)){
									mysqli_stmt_bind_param($stmt_pull_building,"ss", $param_campus_id, $param_account_id);
									$param_campus_id = $campus_id;
									$param_account_id = $accountId;
									if(mysqli_stmt_execute($stmt_pull_building)){
										$result_pull_building = mysqli_stmt_get_result($stmt_pull_building);
										$row_pull_building = mysqli_fetch_array($result_pull_building, MYSQLI_ASSOC);
										$buildings = array($row_pull_building['building_id']);
										foreach($buildings as $building){
											$building_id = $building;
											$query_building = "INSERT INTO user_building (user_id,building_id,account_id) VALUES($user_id, $building_id, '$accountId')";
											$execute_building = mysqli_query($conn, $query_building);
											$sql_pull_floor = "SELECT floor_id FROM floor WHERE building_id=? AND account_id=?";
											if($stmt_pull_floor = mysqli_prepare($conn, $sql_pull_floor)){
												mysqli_stmt_bind_param($stmt_pull_floor,"ss", $param_building_id, $param_account_id);
												$param_building_id = $building_id;
												$param_account_id = $accountId;
												if(mysqli_stmt_execute($stmt_pull_floor)){
													$result_pull_floor = mysqli_stmt_get_result($stmt_pull_floor);
													$row_pull_floor = mysqli_fetch_array($result_pull_floor, MYSQLI_ASSOC);
													$floors = array($row_pull_floor['floor_id']);
													foreach($floors as $floor){
														$floor_id = $floor;
														$query_floor = "INSERT INTO user_floor (user_id,floor_id,account_id) VALUES($user_id, $floor_id, '$accountId')";
														$execute_floor = mysqli_query($conn, $query_floor);
														$sql_pull_area = "SELECT area_id FROM area WHERE floor_id=? AND account_id=?";
														if($stmt_pull_area = mysqli_prepare($conn, $sql_pull_area)){
															mysqli_stmt_bind_param($stmt_pull_area,"ss", $param_floor_id, $param_account_id);
															$param_floor_id = $floor_id;
															$param_account_id = $accountId;
															if(mysqli_stmt_execute($stmt_pull_area)){
																$result_pull_area = mysqli_stmt_get_result($stmt_pull_area);
																$row_pull_area = mysqli_fetch_array($result_pull_area, MYSQLI_ASSOC);
																$areas = array($row_pull_area['area_id']);
																foreach($areas as $area){
																	$area_id = $area;
																	$query_area = "INSERT INTO user_area (user_id,area_id,account_id) VALUES($user_id, $area_id, '$accountId')";
																	$execute_area = mysqli_query($conn, $query_area);
																	$sql_pull_port = "SELECT port_id FROM port WHERE area_id=? AND account_id=?";
																	if($stmt_pull_port = mysqli_prepare($conn, $sql_pull_port)){
																		mysqli_stmt_bind_param($stmt_pull_port,"ss", $param_area_id, $param_account_id);
																		$param_area_id = $area_id;
																		$param_account_id = $accountId;
																		if(mysqli_stmt_execute($stmt_pull_port)){
																			$result_pull_port = mysqli_stmt_get_result($stmt_pull_port);
																			$row_pull_port = mysqli_fetch_array($result_pull_port, MYSQLI_ASSOC);
																			$ports = array($row_pull_port['port_id']);
																			foreach($ports as $port){
																				$port_id = $port;
																				$query_port = "INSERT INTO user_port (user_id,port_id,account_id) VALUES($user_id, $port_id, '$accountId')";
																				$execute_port = mysqli_query($conn, $query_port);
																			}
																		}
																	}//port
																}
															}
														}//area
													}
												}
											}//floor
										}
									}
								}//building
							}
						}//campus

						if(isset($building)){
							$totalbuilding = sizeof($building);
							for($i=0;$i<$totalbuilding;$i++){
								$building_id = $building[$i];
								$query_building = "INSERT INTO user_building (user_id,building_id,account_id) VALUES($user_id,$building_id,'$accountId')";
								$execute_building = mysqli_query($conn, $query_building);
								$sql_pull_floor = "SELECT floor_id FROM floor WHERE building_id=? AND account_id=?";
								if($stmt_pull_floor = mysqli_prepare($conn, $sql_pull_floor)){
									mysqli_stmt_bind_param($stmt_pull_floor,"ss", $param_building_id, $param_account_id);
									$param_building_id = $building_id;
									$param_account_id = $accountId;
									if(mysqli_stmt_execute($stmt_pull_floor)){
										$result_pull_floor = mysqli_stmt_get_result($stmt_pull_floor);
										$row_pull_floor = mysqli_fetch_array($result_pull_floor, MYSQLI_ASSOC);
										$floors = array($row_pull_floor['floor_id']);
										foreach($floors as $floor){
											$floor_id = $floor;
											$query_floor = "INSERT INTO user_floor (user_id,floor_id,account_id) VALUES($user_id, $floor_id, '$accountId')";
											$execute_floor = mysqli_query($conn, $query_floor);
											$sql_pull_area = "SELECT area_id FROM area WHERE floor_id=? AND account_id=?";
											if($stmt_pull_area = mysqli_prepare($conn, $sql_pull_area)){
												mysqli_stmt_bind_param($stmt_pull_area,"ss", $param_floor_id, $param_account_id);
												$param_floor_id = $floor_id;
												$param_account_id = $accountId;
												if(mysqli_stmt_execute($stmt_pull_area)){
													$result_pull_area = mysqli_stmt_get_result($stmt_pull_area);
													$row_pull_area = mysqli_fetch_array($result_pull_area, MYSQLI_ASSOC);
													$areas = array($row_pull_area['area_id']);
													foreach($areas as $area){
														$area_id = $area;
														$query_area = "INSERT INTO user_area (user_id,area_id,account_id) VALUES($user_id, $area_id, '$accountId')";
														$execute_area = mysqli_query($conn, $query_area);
														$sql_pull_port = "SELECT port_id FROM port WHERE area_id=? AND account_id=?";
														if($stmt_pull_port = mysqli_prepare($conn, $sql_pull_port)){
															mysqli_stmt_bind_param($stmt_pull_port,"ss", $param_area_id, $param_account_id);
															$param_area_id = $area_id;
															$param_account_id = $accountId;
															if(mysqli_stmt_execute($stmt_pull_port)){
																$result_pull_port = mysqli_stmt_get_result($stmt_pull_port);
																$row_pull_port = mysqli_fetch_array($result_pull_port, MYSQLI_ASSOC);
																$ports = array($row_pull_port['port_id']);
																foreach($ports as $port){
																	$port_id = $port;
																	$query_port = "INSERT INTO user_port (user_id,port_id,account_id) VALUES($user_id, $port_id, '$accountId')";
																	$execute_port = mysqli_query($conn, $query_port);
																}
															}
														}//port
													}
												}
											}//area
										}
									}
								}//floor
							}
						}//building

						if(isset($floor)){
							$totalfloor = sizeof($floor);
							for($i=0;$i<$totalfloor;$i++){
								$floor_id = $floor[$i];
								$query_floor = "INSERT INTO user_floor (user_id,floor_id,account_id) VALUES($user_id,$floor_id,'$accountId')";
								$execute_floor = mysqli_query($conn, $query_floor);
								$sql_pull_area = "SELECT area_id FROM area WHERE floor_id=? AND account_id=?";
								if($stmt_pull_area = mysqli_prepare($conn, $sql_pull_area)){
									mysqli_stmt_bind_param($stmt_pull_area,"ss", $param_floor_id, $param_account_id);
									$param_floor_id = $floor_id;
									$param_account_id = $accountId;
									if(mysqli_stmt_execute($stmt_pull_area)){
										$result_pull_area = mysqli_stmt_get_result($stmt_pull_area);
										$row_pull_area = mysqli_fetch_array($result_pull_area, MYSQLI_ASSOC);
										$areas = array($row_pull_area['area_id']);
										foreach($areas as $area){
											$area_id = $area;
											$query_area = "INSERT INTO user_area (user_id,area_id,account_id) VALUES($user_id, $area_id, '$accountId')";
											$execute_area = mysqli_query($conn, $query_area);
											$sql_pull_port = "SELECT port_id FROM port WHERE area_id=? AND account_id=?";
											if($stmt_pull_port = mysqli_prepare($conn, $sql_pull_port)){
												mysqli_stmt_bind_param($stmt_pull_port,"ss", $param_area_id, $param_account_id);
												$param_area_id = $area_id;
												$param_account_id = $accountId;
												if(mysqli_stmt_execute($stmt_pull_port)){
													$result_pull_port = mysqli_stmt_get_result($stmt_pull_port);
													$row_pull_port = mysqli_fetch_array($result_pull_port, MYSQLI_ASSOC);
													$ports = array($row_pull_port['port_id']);
													foreach($ports as $port){
														$port_id = $port;
														$query_port = "INSERT INTO user_port (user_id,port_id,account_id) VALUES($user_id, $port_id, '$accountId')";
														$execute_port = mysqli_query($conn, $query_port);
													}
												}
											}//port
										}
									}
								}//area
							}
						}//floor

						if(isset($area)){
							$totalarea = sizeof($area);
							for($i=0;$i<$totalarea;$i++){
								$area_id = $area[$i];
								$query_area = "INSERT INTO user_area (user_id,area_id,account_id) VALUES($user_id, $area_id, '$accountId')";
								$execute_area = mysqli_query($conn, $query_area);
								$sql_pull_port = "SELECT port_id FROM port WHERE area_id=? AND account_id=?";
								if($stmt_pull_port = mysqli_prepare($conn, $sql_pull_port)){
									mysqli_stmt_bind_param($stmt_pull_port,"ss", $param_area_id, $param_account_id);
									$param_area_id = $area_id;
									$param_account_id = $accountId;
									if(mysqli_stmt_execute($stmt_pull_port)){
										$result_pull_port = mysqli_stmt_get_result($stmt_pull_port);
										$row_pull_port = mysqli_fetch_array($result_pull_port, MYSQLI_ASSOC);
										$ports = array($row_pull_port['port_id']);
										foreach($ports as $port){
											$port_id = $port;
											$query_port = "INSERT INTO user_port (user_id,port_id,account_id) VALUES($user_id, $port_id, '$accountId')";
											$execute_port = mysqli_query($conn, $query_port);
										}
									}
								}//port
							}
						}//area

						if(isset($port)){
							$totalport = sizeof($port);
							for($i=0;$i<$totalport;$i++){
								$port_id = $port[$i];
								$query_port = "INSERT INTO user_port (user_id,port_id,account_id) VALUES($user_id,$port_id,'$accountId')";
								$execute_port = mysqli_query($conn, $query_port);
							}
						}//port


							$sql_update_profile = "INSERT INTO profile_image (user_id) VALUES($user_id)";
							$query_update_profile = mysqli_query($conn, $sql_update_profile);

						$sql_role_insert = "INSERT INTO role_user (user_id, role_id) VALUES (?,?)";
						if($stmt_role_insert = mysqli_prepare($conn, $sql_role_insert)){
							mysqli_stmt_bind_param($stmt_role_insert, "ss", $param_user_id, $param_role_id);
							$param_user_id = $user_id;
							$param_role_id = $role;
							if(mysqli_stmt_execute($stmt_role_insert)){
								//send user creation mail
								$sql_user_data = "SELECT * FROM user WHERE user_id=? AND account_id=?";
								if($stmt_user_data = mysqli_prepare($conn, $sql_user_data)){
									mysqli_stmt_bind_param($stmt_user_data, "ss", $param_user_id, $param_account_id);
									$param_user_id = $user_id;
									$param_account_id = $accountId;
									if(mysqli_stmt_execute($stmt_user_data)){
										$result_user_data = mysqli_stmt_get_result($stmt_user_data);
										$row_user_data = mysqli_fetch_array($result_user_data);
										$mail_user_name = $row_user_data['user_name'];
										$mail_user_email = $row_user_data['email'];
										$mail_user_password = $password;
										$to = "$mail_user_email";
										$subject = 'VisiMonk New User!';
										$message = 'Dear '.$mail_user_name.",". "\r\n"."\r\n".
						        'You have been added as new user to VisiMonk'. "\r\n".
										'Your Login Id: '.$mail_user_email. "\r\n".
						        'Temporary Password: '.$mail_user_password. "\r\n"."\r\n".
										'Use the below link to login and change your temporary password!'. "\r\n".
						        'visimonk.com'. "\r\n"."\r\n".
						        'Regards,'. "\r\n".
										'Team VisiMonk'. "\r\n";
										$headers = 'From: registration@visimonk.com' . "\r\n" .
				             'Reply-To: support@visimonk.com' . "\r\n" .
				             'X-Mailer: PHP/' . phpversion();
										 mail($to, $subject, $message, $headers);
									}
								}
								//send user creation mail
							//redirect to login page
							header("location: users_view.php");
							}
						}
					}
				}
			} else{
				$errors[] .= 'Something went wrong. Please try again';
				}
			}
		}
	}//post
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
                <h3>Add User</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="new_user_view.php" method="POST">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full-name">Full Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="full-name" name="full_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['full_name']))?$full_name:''?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['email']))?$email:''?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['phone']))?$phone:''?>"/>
                        </div>
                      </div>
											<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location <span class="required">*</span>
                        </label>
												<div class="col-md-3 col-sm-6 col-xs-12">
													<select class="form-control" name="campus[]" multiple="multiple">
														<option value="0">Choose Campus</option>
														<?php while($row_campus = mysqli_fetch_array($result_campus)):?>
															<option <?=(in_array($row_campus['campus_id'], $campus))?'selected':'';?> value="<?=$row_campus['campus_id']?>"><?=$row_campus['campus_description'];?></option>
														<?php endwhile;?>
													</select>
													<select class="form-control" name="building[]" multiple="multiple">
														<option value="0">Choose Building</option>
														<?php while($row_building = mysqli_fetch_array($result_building)):?>
															<option <?=(in_array($row_building['building_id'], $building))?'selected':'';?> value="<?=$row_building['building_id']?>"><?=$row_building['building_description'];?></option>
														<?php endwhile;?>
													</select>
													<select class="form-control" name="floor[]" multiple="multiple">
														<option value="0">Choose Floor</option>
														<?php while($row_floor = mysqli_fetch_array($result_floor)):?>
															<option <?=(in_array($row_floor['floor_id'], $floor))?'selected':'';?> value="<?=$row_floor['floor_id']?>"><?=$row_floor['floor_description'];?></option>
														<?php endwhile;?>
													</select>
												</div>
												<div class="col-md-3 col-sm-6 col-xs-12">
													<select class="form-control" name="area[]" multiple="multiple">
														<option value="0">Choose Area</option>
														<?php while($row_area = mysqli_fetch_array($result_area)):?>
															<option <?=(in_array($row_area['area_id'], $area))?'selected':'';?> value="<?=$row_area['area_id']?>"><?=$row_area['area_description'];?></option>
														<?php endwhile;?>
													</select>
													<select class="form-control" name="port[]" multiple="multiple">
														<option value="0">Choose Port</option>
														<?php while($row_port = mysqli_fetch_array($result_port)):?>
															<option <?=(in_array($row_port['port_id'], $port))?'selected':'';?> value="<?=$row_port['port_id']?>"><?=$row_port['port_description'];?></option>
														<?php endwhile;?>
													</select>
												</div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Role <span class="required">*</span>
                        </label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select class="form-control" name="role">
														<?php while($row_role = mysqli_fetch_array($result_role, MYSQLI_ASSOC)): ?>
															<option <?=($role == $row_role['role_id'])?'selected':'';?> value="<?=$row_role['role_id'];?>"><?=$row_role['role_description'];?></option>
														<?php endwhile; ?>
													</select>
												</div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['password']))?$password:''?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm-password">Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="confirm-password" name="confirm_password" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['confirm']))?$confirm_password:''?>"/>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a  href="users_view.php" class="btn btn-warning" type="button">Cancel</a>
                          <button type="submit" class="btn btn-success">Submit</button>
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
