<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

	$errors = array();
	$logo_path = '';

	$sql_logo = "SELECT * FROM logo WHERE account_id=?";
	if($stmt_logo = mysqli_prepare($conn, $sql_logo)){
		mysqli_stmt_bind_param($stmt_logo, "s", $param_account_id);
		$param_account_id = $accountId;
		if(mysqli_stmt_execute($stmt_logo)){
			$result_logo = mysqli_stmt_get_result($stmt_logo);
			$row_logo = mysqli_fetch_array($result_logo, MYSQLI_ASSOC);
			$logo_path = $row_logo['logo_path'];
		}
	}

		if(isset($_POST) && !empty($_POST)){
			if(!empty($_FILES)){
				//var_dump($_FILES);
				$photo = $_FILES['upload_logo'];
				$name = $photo['name'];
				$nameArray = explode('.', $name);
				$fileName = $nameArray[0];
				$fileExt = $nameArray[1];
				$mime = explode('/', $photo['type']);
				$mimeType = $mime[0];
				$mimeExt = $mime[1];
				$tmpLoc = $photo['tmp_name'];
				$fileSize = $photo['size'];
				$allowed = array('png', 'jpeg', 'jpg', 'PNG', 'JPEG', 'JPG');
				if($mimeType != 'image'){
					$errors[] .= "The file must be an image";
				}
				if(!in_array($fileExt, $allowed)){
					$errors[] .= "Image must be jpg, png or jpeg";
				}
				if($fileSize > 1000000){
					$errors[] .= "Image must be below 1MB";
				}
				$uploadName = md5(microtime()).'.'.$fileExt;
				$uploadPath = 'logo_account/'.$accountId.'/'.$uploadName;
				$dbPath = 'logo_account/'.$accountId.'/'.$uploadName;
				if(empty($errors)){
					move_uploaded_file($tmpLoc, $uploadPath);
					$sql_upload_logo = "UPDATE logo SET logo_path=? WHERE account_id=?";
					if($stmt_upload_logo = mysqli_prepare($conn, $sql_upload_logo)){
						mysqli_stmt_bind_param($stmt_upload_logo, "ss", $param_logo_path, $param_account_id);
						$param_logo_path = $dbPath;
						$param_account_id = $accountId;
						if(mysqli_stmt_execute($stmt_upload_logo)){
							header('Location: index.php');
						}
					}
				}
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
                <h3>Upload Logo</h3>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" action="logo_view.php" method="POST" enctype="multipart/form-data">
												<input type="hidden" name="test" value="test"/>
											<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="upload_logo">Upload Logo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="upload_logo" name="upload_logo" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a href="index.php" class="btn btn-warning" type="button">Cancel</a>
												<?php if(in_array("logo_update", $permission)): ?><button type="submit" class="btn btn-success">Submit</button><?php endif;?>
                        </div>
                      </div>
                    </form>
                      <!--form end-->
                  </div>
                </div>
								<img style="width:400px;height:200px;" src="<?=$logo_path;?>" alt="image not found, please upload logo"/>
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
