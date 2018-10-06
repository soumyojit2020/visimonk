<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$full_name = '';
	$email = '';
	$phone = '';
	$campus_id = array();
	$building_id = array();
	$floor_id = array();
	$area_id = array();
	$port_id = array();
	$role =  '';

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

  if(isset($_GET) && !empty($_GET)){
    $user_id = clean($_GET['user_id']);
    $sql_get_user = "SELECT u.user_id, u.user_name, u.email, u.phone_number, ru.role_id, r.role_description
  										FROM user u
  										LEFT JOIN role_user ru
  										ON u.user_id = ru.user_id
  										LEFT JOIN role r
  										ON ru.role_id = r.role_id
  										WHERE u.account_id = ? AND u.user_id=?";

    if($stmt_user_find = mysqli_prepare($conn, $sql_get_user)){
  		mysqli_stmt_bind_param($stmt_user_find, "ss", $param_account_id, $param_user_id);
  		$param_account_id = $accountId;
      $param_user_id = $user_id;
  		if(mysqli_stmt_execute($stmt_user_find)){
  			$result_user_find = mysqli_stmt_get_result($stmt_user_find);
        $row_user_find = mysqli_fetch_array($result_user_find, MYSQLI_ASSOC);
    		$full_name_get = clean($row_user_find['user_name']);
    		$email_get = clean($row_user_find['email']);
    		$phone_get = clean($row_user_find['phone_number']);
    		$role_id_get =  clean($row_user_find['role_id']);
        $role_description_get = clean($row_user_find['role_description']);
  		}
  	}

		$sql_campus_get = "SELECT campus_id FROM user_campus WHERE user_id=? AND account_id=?";
		if($stmt_campus_get = mysqli_prepare($conn, $sql_campus_get)){
			mysqli_stmt_bind_param($stmt_campus_get, "ss", $param_user_id, $param_account_id);
			$param_user_id = $user_id;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_campus_get)){
				$result_campus_get = mysqli_stmt_get_result($stmt_campus_get);
				while($row_campus_get = mysqli_fetch_array($result_campus_get)){
					$campuses = array($row_campus_get['campus_id']);
					foreach($campuses as $campus){
						 $campus_id[] .= $campus;
					}
				}
			}
		}

		$sql_building_get = "SELECT building_id FROM user_building WHERE user_id=? AND account_id=?";
		if($stmt_building_get = mysqli_prepare($conn, $sql_building_get)){
			mysqli_stmt_bind_param($stmt_building_get, "ss", $param_user_id, $param_account_id);
			$param_user_id = $user_id;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_building_get)){
				$result_building_get = mysqli_stmt_get_result($stmt_building_get);
				while($row_building_get = mysqli_fetch_array($result_building_get)){
					$buildings = array($row_building_get['building_id']);
					foreach($buildings as $building){
						$building_id[] .= $building;
					}
				}
			}
		}

		$sql_floor_get = "SELECT floor_id FROM user_floor WHERE user_id=? AND account_id=?";
		if($stmt_floor_get = mysqli_prepare($conn, $sql_floor_get)){
			mysqli_stmt_bind_param($stmt_floor_get, "ss", $param_user_id, $param_account_id);
			$param_user_id = $user_id;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_floor_get)){
				$result_floor_get = mysqli_stmt_get_result($stmt_floor_get);
				while($row_floor_get = mysqli_fetch_array($result_floor_get)){
					$floors = array($row_floor_get['floor_id']);
					foreach($floors as $floor){
						$floor_id[] .= $floor;
					}
				}
			}
		}

		$sql_area_get = "SELECT area_id FROM user_area WHERE user_id=? AND account_id=?";
		if($stmt_area_get = mysqli_prepare($conn, $sql_area_get)){
			mysqli_stmt_bind_param($stmt_area_get, "ss", $param_user_id, $param_account_id);
			$param_user_id = $user_id;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_area_get)){
				$result_area_get = mysqli_stmt_get_result($stmt_area_get);
				while($row_area_get = mysqli_fetch_array($result_area_get)){
					$areas = array($row_area_get['area_id']);
					foreach($areas as $area){
						$area_id[] .= $area;
					}
				}
			}
		}

		$sql_port_get = "SELECT port_id FROM user_port WHERE user_id=? AND account_id=?";
		if($stmt_port_get = mysqli_prepare($conn, $sql_port_get)){
			mysqli_stmt_bind_param($stmt_port_get, "ss", $param_user_id, $param_account_id);
			$param_user_id = $user_id;
			$param_account_id = $accountId;
			if(mysqli_stmt_execute($stmt_port_get)){
				$result_port_get = mysqli_stmt_get_result($stmt_port_get);
				while($row_port_get = mysqli_fetch_array($result_port_get)){
					$ports = array($row_port_get['port_id']);
					foreach($ports as $port){
						$port_id[] .= $port;
					}
				}
			}
		}


  }//get

	if(isset($_POST) && !empty($_POST)){
		$errors = array();
    $user_id = clean($_POST['user_id']);
		$full_name = clean($_POST['full_name']);
		$email = clean($_POST['email']);
		$phone = clean($_POST['phone']);
		if(!empty($_POST['campus'])){
			$campus_id = $_POST['campus'];
		}else{
			$campus_id = array();
		}

		if(!empty($_POST['building'])){
			$building_id = $_POST['building'];
		}else{
			$building_id = array();
		}

		if(!empty($_POST['floor'])){
			$floor_id = $_POST['floor'];
		}else{
			$floor_id = array();
		}

		if(!empty($_POST['area'])){
			$area_id = $_POST['area'];
		}else{
			$area_id = array();
		}

		if(!empty($_POST['port'])){
			$port_id = $_POST['port'];
		} else{
			$port_id = array();
		}
		$role_id_get =  clean($_POST['role']);

		if(empty($full_name || $email || $phone || $role)){
			$errors[] .= 'All fields are mandatory!';
		}

		if(empty($campus_id || $building_id || $floor_id || $area_id || $port_id )){
			$errors[] .= 'Assign atleast one location!';
		}

		$sql_duplicate_user = "SELECT email FROM user WHERE email=? AND account_id=? AND user_id !=?";
		if($stmt_duplicate_user = mysqli_prepare($conn, $sql_duplicate_user)){
			mysqli_stmt_bind_param($stmt_duplicate_user, "sss", $param_email, $param_account_id, $param_user_id);
			$param_email = $email;
			$param_account_id = $accountId;
      $param_user_id = $user_id;
			if(mysqli_stmt_execute($stmt_duplicate_user)){
				$result_duplicate_user = mysqli_stmt_get_result($stmt_duplicate_user);
				if(mysqli_num_rows($result_duplicate_user)){
					$errors[] .= $email. ' already exists!';
				}
			}
		}

		$sql_duplicate_user = "SELECT phone FROM user WHERE phone=? AND account_id=? AND user_id !=?";
		if($stmt_duplicate_user = mysqli_prepare($conn, $sql_duplicate_user)){
			mysqli_stmt_bind_param($stmt_duplicate_user, "ss", $param_phone, $param_account_id, $param_user_id);
			$param_phone = $phone;
			$param_account_id = $accountId;
      $param_user_id = $user_id;
			if(mysqli_stmt_execute($stmt_duplicate_user)){
				$result_duplicate_user = mysqli_stmt_get_result($stmt_duplicate_user);
				if(mysqli_num_rows($result_duplicate_user)){
					$errors[] .= $phone. ' already exists!';
				}
			}
		}

		if(empty($errors)){
			//prepare statement to update User Table
			//generate token code
			$sqlUser = "UPDATE user SET user_name=?, phone_number=?, email=? WHERE user_id = ? AND account_id=?";
			if($stmtUser = mysqli_prepare($conn, $sqlUser)){
			//bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmtUser, "sssss", $param_userName, $param_phoneNumber, $param_email, $param_user_id, $param_account_id);
			//set parameters
			$param_userName = $full_name;
			$param_phoneNumber = $phone;
			$param_email = $email;
      $param_user_id = $user_id;
      $param_account_id = $accountId;
			if(mysqli_stmt_execute($stmtUser)){
        $sql_role_update = "UPDATE role_user SET role_id=? WHERE user_id=?";
        if($stmt_role_update = mysqli_prepare($conn, $sql_role_update)){
          mysqli_stmt_bind_param($stmt_role_update, "ss", $param_role_id, $param_user_id);
          $param_role_id = $role_id_get;
          $param_user_id = $user_id;
          if(mysqli_stmt_execute($stmt_role_update)){

						$query_campus_delete = "DELETE FROM user_campus WHERE user_id=$user_id AND account_id='$accountId'";
						$execute_campus_delete = mysqli_query($conn, $query_campus_delete);

						$query_building_delete = "DELETE FROM user_building WHERE user_id=$user_id AND account_id='$accountId'";
						$execute_building_delete = mysqli_query($conn, $query_building_delete);

						$query_floor_delete = "DELETE FROM user_floor WHERE user_id=$user_id AND account_id='$accountId'";
						$execute_floor_delete = mysqli_query($conn, $query_floor_delete);

						$query_area_delete = "DELETE FROM user_area WHERE user_id=$user_id AND account_id='$accountId'";
						$execute_area_delete = mysqli_query($conn, $query_area_delete);

						$query_port_delete = "DELETE FROM user_port WHERE user_id=$user_id AND account_id='$accountId'";
						$execute_port_delete = mysqli_query($conn, $query_port_delete);

						if(isset($campus_id)){
							$totalCampus = sizeof($campus_id);
							for($i=0;$i<$totalCampus;$i++){
								$campus = $campus_id[$i];
								$query_campus = "INSERT INTO user_campus (user_id,campus_id,account_id) VALUES($user_id,$campus,'$accountId')";
								$execute_campus = mysqli_query($conn, $query_campus);
								$sql_pull_building = "SELECT building_id FROM building WHERE campus_id=? AND account_id=?";
								if($stmt_pull_building = mysqli_prepare($conn, $sql_pull_building)){
									mysqli_stmt_bind_param($stmt_pull_building,"ss", $param_campus_id, $param_account_id);
									$param_campus_id = $campus;
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

						if(isset($building_id)){
							$totalbuilding = sizeof($building_id);
							for($i=0;$i<$totalbuilding;$i++){
								$building = $building_id[$i];
								$query_building = "INSERT INTO user_building (user_id,building_id,account_id) VALUES($user_id,$building,'$accountId')";
								$execute_building = mysqli_query($conn, $query_building);
								$sql_pull_floor = "SELECT floor_id FROM floor WHERE building_id=? AND account_id=?";
								if($stmt_pull_floor = mysqli_prepare($conn, $sql_pull_floor)){
									mysqli_stmt_bind_param($stmt_pull_floor,"ss", $param_building_id, $param_account_id);
									$param_building_id = $building;
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

						if(isset($floor_id)){
							$totalfloor = sizeof($floor_id);
							for($i=0;$i<$totalfloor;$i++){
								$floor = $floor_id[$i];
								$query_floor = "INSERT INTO user_floor (user_id,floor_id,account_id) VALUES($user_id,$floor,'$accountId')";
								$execute_floor = mysqli_query($conn, $query_floor);
								$sql_pull_area = "SELECT area_id FROM area WHERE floor_id=? AND account_id=?";
								if($stmt_pull_area = mysqli_prepare($conn, $sql_pull_area)){
									mysqli_stmt_bind_param($stmt_pull_area,"ss", $param_floor_id, $param_account_id);
									$param_floor_id = $floor;
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

						if(isset($area_id)){
							$totalarea = sizeof($area_id);
							for($i=0;$i<$totalarea;$i++){
								$area = $area_id[$i];
								$query_area = "INSERT INTO user_area (user_id,area_id,account_id) VALUES($user_id, $area, '$accountId')";
								$execute_area = mysqli_query($conn, $query_area);
								$sql_pull_port = "SELECT port_id FROM port WHERE area_id=? AND account_id=?";
								if($stmt_pull_port = mysqli_prepare($conn, $sql_pull_port)){
									mysqli_stmt_bind_param($stmt_pull_port,"ss", $param_area_id, $param_account_id);
									$param_area_id = $area;
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

						if(isset($port_id)){
							$totalport = sizeof($port_id);
							for($i=0;$i<$totalport;$i++){
								$port = $port_id[$i];
								$query_port = "INSERT INTO user_port (user_id,port_id,account_id) VALUES($user_id,$port,'$accountId')";
								$execute_port = mysqli_query($conn, $query_port);
							}
						}//port

            header('Location: users_view.php');
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
                <h3>Edit User</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="edit_user_view.php?user_id=<?=$user_id;?>" method="POST">
                        <input type="hidden" name="user_id" value="<?=$user_id;?>"/>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full-name">Full Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="full-name" name="full_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['full_name']))?$full_name:$full_name_get;?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['email']))?$email:$email_get?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['phone']))?$phone:$phone_get?>"/>
                        </div>
                      </div>
											<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location <span class="required">*</span>
                        </label>
												<div class="col-md-3 col-sm-6 col-xs-12">
													<select class="form-control" name="campus[]" multiple="multiple">
														<option value="0">Choose Campus</option>
														<?php while($row_campus = mysqli_fetch_array($result_campus)):?>
															<option <?=(in_array($row_campus['campus_id'], $campus_id))?'selected':'';?> value="<?=$row_campus['campus_id']?>"><?=$row_campus['campus_description'];?></option>
														<?php endwhile;?>
													</select>
													<select class="form-control" name="building[]" multiple="multiple">
														<option value="0">Choose Building</option>
														<?php while($row_building = mysqli_fetch_array($result_building)):?>
															<option <?=(in_array($row_building['building_id'], $building_id))?'selected':'';?> value="<?=$row_building['building_id']?>"><?=$row_building['building_description'];?></option>
														<?php endwhile;?>
													</select>
													<select class="form-control" name="floor[]" multiple="multiple">
														<option value="0">Choose Floor</option>
														<?php while($row_floor = mysqli_fetch_array($result_floor)):?>
															<option <?=(in_array($row_floor['floor_id'], $floor_id))?'selected':'';?> value="<?=$row_floor['floor_id']?>"><?=$row_floor['floor_description'];?></option>
														<?php endwhile;?>
													</select>
												</div>
												<div class="col-md-3 col-sm-6 col-xs-12">
													<select class="form-control" name="area[]" multiple="multiple">
														<option value="0">Choose Area</option>
														<?php while($row_area = mysqli_fetch_array($result_area)):?>
															<option <?=(in_array($row_area['area_id'], $area_id))?'selected':'';?> value="<?=$row_area['area_id']?>"><?=$row_area['area_description'];?></option>
														<?php endwhile;?>
													</select>
													<select class="form-control" name="port[]" multiple="multiple">
														<option value="0">Choose Port</option>
														<?php while($row_port = mysqli_fetch_array($result_port)):?>
															<option <?=(in_array($row_port['port_id'], $port_id))?'selected':'';?> value="<?=$row_port['port_id']?>"><?=$row_port['port_description'];?></option>
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
															<option <?=($role_id_get == $row_role['role_id'])?'selected':''?> value="<?=$row_role['role_id']?>"><?=$row_role['role_description']?></option>
														<?php endwhile; ?>
													</select>
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
