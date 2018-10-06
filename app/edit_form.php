<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();
	$campus_id = array();
	$building_id = array();
	$floor_id = array();
	$area_id = array();
	$port_id = array();
	$visitor_email= 1;
	$visitor_phone = 1;
	$id = 1;
	$id_photo = 1;
	$date = 1;
	$time = 1;
	$host_name = 1;
	$host_email = 1;
	$host_phone = 1;
	$notes = 1;
	$camera = 1;

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
    $form_id = clean($_GET['form_id']);
    $sql_get_form = "SELECT * FROM form_structure WHERE form_id=? AND account_id=?";
    if($stmt_get_form = mysqli_prepare($conn, $sql_get_form)){
      mysqli_stmt_bind_param($stmt_get_form, "ss", $param_form_id, $param_account_id);
      $param_form_id = $form_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_get_form)){
        $result_get_form = mysqli_stmt_get_result($stmt_get_form);
        $row_get_form = mysqli_fetch_array($result_get_form, MYSQLI_ASSOC);
        $form_name = clean($row_get_form['form_name']);
    		$visitor_email = clean($row_get_form['email']);
    		$visitor_phone = clean($row_get_form['phone']);
    		$id = clean($row_get_form['id']);
				$id_photo = clean($row_get_form['id_photo']);
    		$date = clean($row_get_form['date']);
    		$time = clean($row_get_form['time']);
    		$host_name = clean($row_get_form['host_name']);
    		$host_email = clean($row_get_form['host_email']);
    		$host_phone = clean($row_get_form['host_phone']);
    		$notes = clean($row_get_form['notes']);
    		$camera = clean($row_get_form['camera']);
    		$email_notification = clean($row_get_form['email_notification']);
    		$sms_notification = clean($row_get_form['sms_notification']);
      }
    }

		$sql_campus_get = "SELECT campus_id FROM form_campus WHERE form_id=? AND account_id=?";
		if($stmt_campus_get = mysqli_prepare($conn, $sql_campus_get)){
			mysqli_stmt_bind_param($stmt_campus_get, "ss", $param_form_id, $param_account_id);
			$param_form_id = $form_id;
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

		$sql_building_get = "SELECT building_id FROM form_building WHERE form_id=? AND account_id=?";
		if($stmt_building_get = mysqli_prepare($conn, $sql_building_get)){
			mysqli_stmt_bind_param($stmt_building_get, "ss", $param_form_id, $param_account_id);
			$param_form_id = $form_id;
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

		$sql_floor_get = "SELECT floor_id FROM form_floor WHERE form_id=? AND account_id=?";
		if($stmt_floor_get = mysqli_prepare($conn, $sql_floor_get)){
			mysqli_stmt_bind_param($stmt_floor_get, "ss", $param_form_id, $param_account_id);
			$param_form_id = $form_id;
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

		$sql_area_get = "SELECT area_id FROM form_area WHERE form_id=? AND account_id=?";
		if($stmt_area_get = mysqli_prepare($conn, $sql_area_get)){
			mysqli_stmt_bind_param($stmt_area_get, "ss", $param_form_id, $param_account_id);
			$param_form_id = $form_id;
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

		$sql_port_get = "SELECT port_id FROM form_port WHERE form_id=? AND account_id=?";
		if($stmt_port_get = mysqli_prepare($conn, $sql_port_get)){
			mysqli_stmt_bind_param($stmt_port_get, "ss", $param_form_id, $param_account_id);
			$param_form_id = $form_id;
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
    $form_id = clean($_POST['form_id']);
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
		$form_name = clean($_POST['form_name']);
		$visitor_email = clean($_POST['email']);
		$visitor_phone = clean($_POST['phone']);
		$id = clean($_POST['id']);
		$id_photo = clean($_POST['id_photo']);
		$date = clean($_POST['date']);
		$time = clean($_POST['time']);
		$host_name = clean($_POST['host_name']);
		$host_email = clean($_POST['host_email']);
		$host_phone = clean($_POST['host_phone']);
		$notes = clean($_POST['notes']);
		$camera = clean($_POST['camera']);
		$email_notification = clean($_POST['email_notification']);
		$sms_notification = clean($_POST['sms_notification']);

		if(empty($form_name)){
			$errors[] .= 'Form Name cannot be blank';
		}

		if(empty($visitor_email || $visitor_phone || $id || $id_photo || $date || $time || $host_name || $host_email || $host_phone
				|| $notes || $camera || $email_notification || $sms_notification)){
					$errors[] .= 'All form fields need to be set to a value!';
		}

		if(empty($campus_id || $building_id || $floor_id || $area_id || $port_id )){
			$errors[] .= 'Assign atleast one location!';
		}

		$sql_form_search = "SELECT form_name FROM form_structure WHERE form_name=? AND account_id=? AND form_id!=?";
		if($stmt_form_search = mysqli_prepare($conn, $sql_form_search)){
			mysqli_stmt_bind_param($stmt_form_search, "sss", $param_form_name, $param_account_id, $param_form_id);
			$param_form_name = $form_name;
			$param_account_id = $accountId;
      $param_form_id = $form_id;
			if(mysqli_stmt_execute($stmt_form_search)){
				$result_form_search = mysqli_stmt_get_result($stmt_form_search);
				if(mysqli_num_rows($result_form_search) == 1){
					$errors[] .= $form_name. ' already exists!';
				}
			}
		}

		if($email_notification == "both" && ($visitor_email != 1 || $host_email != 1)){
			$errors[] .= 'Email notification set to "Both". Email and Host email must be on!';
		}

		if($email_notification == "visitor" && $visitor_email != 1){
			$errors[] .= 'Email notification set to "Visitor". Email must be on!';
		}

		if($email_notification == "host" && $host_email != 1){
			$errors[] .= 'Email notification set to "Host". Host email must be on!';
		}

		if($sms_notification == "both" && ($visitor_phone != 1 || $host_phone != 1)){
			$errors[] .= 'SMS notification set to "Both". Phone and Host phone must be on!';
		}

		if($sms_notification == "visitor" && $visitor_phone != 1){
			$errors[] .= 'SMS notification set to "Visitor". Phone must be on!';
		}

		if($sms_notification == "host" && $host_phone != 1){
			$errors[] .= 'SMS notification set to "Host". Host phone must be on!';
		}

		if(empty($errors)){
			$sql_form_update = "UPDATE form_structure SET
                          form_name = '$form_name',
                          visitor_name = 1,
													gender = 1,
													visitor_type = 1,
                          email = $visitor_email,
                          phone = $visitor_phone,
                          id = $id,
													id_photo = $id_photo,
                          `date` = $date,
                          `time` = $time,
                          host_name = $host_name,
                          host_email = $host_email,
                          host_phone = $host_phone,
                          notes = $notes,
                          camera = $camera,
                          email_notification = '$email_notification',
                          sms_notification = '$sms_notification',
                          account_id = '$accountId'
                          WHERE form_id = $form_id";
			$query1 = mysqli_query($conn, $sql_form_update);
			$query_campus_delete = "DELETE FROM form_campus WHERE form_id=$form_id AND account_id='$accountId'";
			$execute_campus_delete = mysqli_query($conn, $query_campus_delete);

			$query_building_delete = "DELETE FROM form_building WHERE form_id=$form_id AND account_id='$accountId'";
			$execute_building_delete = mysqli_query($conn, $query_building_delete);

			$query_floor_delete = "DELETE FROM form_floor WHERE form_id=$form_id AND account_id='$accountId'";
			$execute_floor_delete = mysqli_query($conn, $query_floor_delete);

			$query_area_delete = "DELETE FROM form_area WHERE form_id=$form_id AND account_id='$accountId'";
			$execute_area_delete = mysqli_query($conn, $query_area_delete);

			$query_port_delete = "DELETE FROM form_port WHERE form_id=$form_id AND account_id='$accountId'";
			$execute_port_delete = mysqli_query($conn, $query_port_delete);

			if(isset($campus_id)){
				$totalCampus = sizeof($campus_id);
				for($i=0;$i<$totalCampus;$i++){
					$campus = $campus_id[$i];
					$query_campus = "INSERT INTO form_campus (form_id,campus_id,account_id) VALUES($form_id,$campus,'$accountId')";
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
								$query_building = "INSERT INTO form_building (form_id,building_id,account_id) VALUES($form_id, $building_id, '$accountId')";
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
											$query_floor = "INSERT INTO form_floor (form_id,floor_id,account_id) VALUES($form_id, $floor_id, '$accountId')";
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
														$query_area = "INSERT INTO form_area (form_id,area_id,account_id) VALUES($form_id, $area_id, '$accountId')";
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
																	$query_port = "INSERT INTO form_port (form_id,port_id,account_id) VALUES($form_id, $port_id, '$accountId')";
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
					$query_building = "INSERT INTO form_building (form_id,building_id,account_id) VALUES(formr_id,$building,'$accountId')";
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
								$query_floor = "INSERT INTO form_floor (form_id,floor_id,account_id) VALUES($form_id, $floor_id, '$accountId')";
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
											$query_area = "INSERT INTO form_area (form_id,area_id,account_id) VALUES($form_id, $area_id, '$accountId')";
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
														$query_port = "INSERT INTO form_port (form_id,port_id,account_id) VALUES($form_id, $port_id, '$accountId')";
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
					$query_floor = "INSERT INTO form_floor (form_id,floor_id,account_id) VALUES($form_id,$floor,'$accountId')";
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
								$query_area = "INSERT INTO form_area (form_id,area_id,account_id) VALUES($form_id, $area_id, '$accountId')";
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
											$query_port = "INSERT INTO form_port (form_id,port_id,account_id) VALUES($form_id, $port_id, '$accountId')";
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
					$query_area = "INSERT INTO form_area (form_id,area_id,account_id) VALUES($form_id, $area, '$accountId')";
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
								$query_port = "INSERT INTO form_port (form_id,port_id,account_id) VALUES($form_id, $port_id, '$accountId')";
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
					$query_port = "INSERT INTO form_port (form_id,port_id,account_id) VALUES($form_id,$port,'$accountId')";
					$execute_port = mysqli_query($conn, $query_port);
				}
			}//port
		header('location: form_edit_view.php');
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
                <h3>Edit Form</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="edit_form.php" method="POST">
                        <input type="hidden" name="form_id" value="<?=$form_id;?>"/>
												<div>
													<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="form-name">Form Name <span class="required">*</span>
		                        </label>
														<div class="col-md-6 col-sm-6 col-xs-12">
		          								<input type="text" name="form_name" class="form-control col-md-7 col-xs-12" value="<?=$form_name;?>"/>
		                        </div>
		                      </div>
		                      <div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full-name">Visitor Name <span class="required">*</span>
		                        </label>
		                      </div>
													<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full-name">Gender <span class="required">*</span>
		                        </label>
		                      </div>
													<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full-name">Visitor Type <span class="required">*</span>
		                        </label>
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
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
		          								<select class="form-control" name="email">
																<option <?=($visitor_email == 1)?'selected':'';?> value="1">On</option>
																<option <?=($visitor_email == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group" id="phone">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone-field">Phone
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="phone">
																<option <?=($visitor_phone == 1)?'selected':'';?> value="1">On</option>
																<option <?=($visitor_phone == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
													</div>
													<div class="form-group" id="identifier">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identifier-field">ID Text
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="id">
																<option <?=($id == 1)?'selected':'';?> value="1">On</option>
																<option <?=($id == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
												</div>
												<div class="form-group" id="identifier">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="identifier-field">ID Photo
													</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<select class="form-control" name="id_photo">
															<option <?=($id_photo == 1)?'selected':'';?> value="1">On</option>
															<option <?=($id_photo == 0)?'selected':'';?> value="0">Off</option>
														</select>
													</div>
											</div>
													<div class="form-group" id="date">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="date">
																<option <?=($date == 1)?'selected':'';?> value="1">On</option>
																<option <?=($date == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group" id="time">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="time">Time
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="time">
																<option <?=($time == 1)?'selected':'';?> value="1">On</option>
																<option <?=($time == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group" id="form">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Host Name
		                        </label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="host_name">
																<option <?=($host_name == 1)?'selected':'';?> value="1">On</option>
																<option  <?=($host_name == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group" id="hEmail">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Host Email
		                        </label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="host_email">
																<option <?=($host_email == 1)?'selected':'';?> value="1">On</option>
																<option <?=($host_email == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group" id="hPhone">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Host Phone
		                        </label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="host_phone">
																<option <?=($host_phone == 1)?'selected':'';?> value="1">On</option>
																<option <?=($host_phone == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group" id="notes">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notes">Notes
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="notes">
																<option <?=($notes == 1)?'selected':'';?> value="1">On</option>
																<option <?=($notes == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Camera
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="camera">
																<option <?=($camera == 1)?'selected':'';?> value="1">On</option>
																<option <?=($camera == 0)?'selected':'';?> value="0">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Notification
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="email_notification">
																<option <?=($email_notification == 'host')?'selected':'';?> value="host">Host</option>
																<option <?=($email_notification == 'visitor')?'selected':'';?> value="visitor">Visitor</option>
																<option <?=($email_notification == 'both')?'selected':'';?> value="both">Both</option>
																<option <?=($email_notification == 'off')?'selected':'';?> value="off">Off</option>
															</select>
		                        </div>
		                      </div>
													<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SMS Notification
		                        </label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
															<select class="form-control" name="sms_notification">
																<option <?=($sms_notification == 'host')?'selected':'';?> value="host">Host</option>
																<option <?=($sms_notification == 'visitor')?'selected':'';?> value="visitor">Visitor</option>
																<option <?=($sms_notification == 'both')?'selected':'';?> value="both">Both</option>
																<option <?=($sms_notification == 'off')?'selected':'';?> value="off">Off</option>
															</select>
		                        </div>
		                      </div>
	                      <div class="ln_solid"></div>
	                      <div class="form-group">
	                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          <a href="form_edit_view.php" class="btn btn-warning" type="button">Cancel</a>
	                          <button type="submit" class="btn btn-success">Submit</button>
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
