<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

    $user_id = clean($userId);

    $sql_user_details = "SELECT * FROM user WHERE user_id=? AND account_id=?";
    if($stmt_user_details = mysqli_prepare($conn, $sql_user_details)){
      mysqli_stmt_bind_param($stmt_user_details, "ss", $param_user_id, $param_account_id);
      $param_user_id = $user_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_user_details)){
        $result_user_details = mysqli_stmt_get_result($stmt_user_details);
        $row_user_details = mysqli_fetch_array($result_user_details);
      }
    }

		$sql_profile_image = "SELECT profile_image_path FROM profile_image WHERE user_id=?";
		if($stmt_profile_image = mysqli_prepare($conn, $sql_profile_image)){
			mysqli_stmt_bind_param($stmt_profile_image, "s", $param_user_id);
			$param_user_id = $userId;
			if(mysqli_stmt_execute($stmt_profile_image)){
				$result_profile_image = mysqli_stmt_get_result($stmt_profile_image);
				$row_profile_image = mysqli_fetch_array($result_profile_image);
				$profile_image = $row_profile_image['profile_image_path'];
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
                <h3>Profile Page</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="profile_img">
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img class="img-responsive avatar-view" src="<?=$profile_image?>" alt="Visimonk Profile Picture" title="Visimonk Profile Picture">
                      </div>
                    </div>
                    <br/>
                    <a href="profile_pic_upload.php" class="btn btn-primary">Upload Image</a>
                    <br/>
                  </div>

                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="table-responsive">
    											<table class="table table-bordered">
                            <tbody>
                              <tr>
                                <td><b>Name</b></td>
                                <td><?=$row_user_details['user_name']?></td>
                              </tr>
                              <tr>
                                <td><b>Email</b></td>
                                <td><?=$row_user_details['email']?></td>
                              </tr>
                              <tr>
                                <td><b>Phone</b></td>
                                <td><?=$row_user_details['phone_number']?></td>
                              </tr>
                              <tr>
                                <td><b>Member Since</b></td>
                                <td><?=$row_user_details['created_at']?></td>
                              </tr>
                            </tbody>
                          </table>
                       </div>
                      <br/>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <a href="change_password.php" class="btn btn-danger"><i class="fa fa-edit m-right-xs"></i>Change Password</a>
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
