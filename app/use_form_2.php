<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();

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
				//print_r($row_field_search);
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
                <h3>Visitor Form: Smile you on camera</h3>
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
												<div class="product-image">
                          <div id="camera" class="camera"></div><br>
                          <button id="take_snapshots" class="btn btn-success btn-sm takeSnapshots">Take Snapshot</button>
                        </div>
                        <!--form start-->
                        <form action="upload_image.php" method="POST">
                          <input type="hidden" name="form_id" value="<?=$form_id;?>"/>
                          <input type="hidden" name="visitor_id" value="<?=$visitor_id;?>"/>
                          <div id="imagelist"></div>
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

<script>
    var options = {
      shutter_ogg_url: "jpeg_camera/shutter.ogg",
      shutter_mp3_url: "jpeg_camera/shutter.mp3",
      swf_url: "jpeg_camera/jpeg_camera.swf",
    };
    var camera = new JpegCamera("#camera", options);

  $('#take_snapshots').click(function(){
    var snapshot = camera.capture();
    snapshot.show();

    snapshot.upload({api_url: "action.php"}).done(function(response) {
      $('#imagelist').prepend("<input type=\"hidden\" name=\"image_path\" value='"+response+"'/>");
			alert("Image Saved! Click on next to continue!");
      }).fail(function(response) {
        alert("Upload failed with status " + response);
      });
      })

</script>
