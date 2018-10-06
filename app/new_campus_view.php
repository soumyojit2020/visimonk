<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	if(isset($_POST) && !empty($_POST)){
		$errors = array();
		$campus_name = clean($_POST['campus_name']);
		if(empty($campus_name)){
			$errors[] .= 'Please enter a campus name';
		}

		$sql_campus = "SELECT campus_description FROM campus WHERE account_id = ? AND campus_description = ?";
		if($stmt_campus = mysqli_prepare($conn, $sql_campus)){
			mysqli_stmt_bind_param($stmt_campus, "ss", $param_account_id, $param_campus_description);
			$param_account_id = $accountId;
			$param_campus_description = $campus_name;
			if(mysqli_stmt_execute($stmt_campus)){
				$result_campus = mysqli_stmt_get_result($stmt_campus);
				if(mysqli_num_rows($result_campus) == 1){
					$errors[] .= $campus_name. ' already exists';
				}
			}
		}

		if(empty($errors)){
			$sql_insert_campus = "INSERT INTO campus (campus_description, account_id) VALUES('$campus_name', '$accountId')";
			if($query1 = mysqli_query($conn, $sql_insert_campus)){
					$sql_find_campus = "SELECT * FROM campus WHERE campus_description=? AND account_id=?";
					if($stmt_find_campus = mysqli_prepare($conn, $sql_find_campus)){
						mysqli_stmt_bind_param($stmt_find_campus, "ss", $param_campus_description, $param_account_id);
						$param_campus_description = $campus_name;
						$param_account_id = $accountId;
						if(mysqli_stmt_execute($stmt_find_campus)){
							$result_find_campus = mysqli_stmt_get_result($stmt_find_campus);
							$row_find_campus = mysqli_fetch_array($result_find_campus);
							$campus_id_find = $row_find_campus['campus_id'];
							$sql_user_campus = "INSERT INTO user_campus(user_id, campus_id, account_id) VALUES($userId, $campus_id_find, '$accountId')";
							$query2 = mysqli_query($conn, $sql_user_campus);
							header("location: campus_view.php");
						}
					}
			}
		}

	}//POST
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
                <h3>Add Campus</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="new_campus_view.php" method="POST">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus-name">Campus Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="campus-name" name="campus_name" required="required" class="form-control col-md-7 col-xs-12" value="<?=(isset($_POST['campus_name']))?$campus_name:''?>"/>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" type="button" href="campus_view.php">Cancel</a>
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
