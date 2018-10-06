<?php
require_once 'include/dbConfig.php';
checkLogin();

if(isset($_POST) && !empty($_POST)){
  $form_id = clean($_POST['form_id']);
  $visitor_id = clean($_POST['visitor_id']);
  $image_path = clean($_POST['image_path']);
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

  $sql_image_upload = "UPDATE visitor SET photo_id_path = ? WHERE visitor_id = ?";
  if($stmt_image_upload = mysqli_prepare($conn, $sql_image_upload)){
    mysqli_stmt_bind_param($stmt_image_upload, "ss", $param_image_path, $param_visitor_id);
    $param_image_path = $image_path;
    $param_visitor_id = $visitor_id;
    if(mysqli_stmt_execute($stmt_image_upload)){
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
      if($row_field_search['email_notification'] == "both"){
        header("location: use_form_3.php?form_id=$form_id&visitor_id=$visitor_id");
      }

      if($row_field_search['email_notification'] == "visitor"){
        header("location: use_form_3.php?form_id=$form_id&visitor_id=$visitor_id");
      }

      if($row_field_search['email_notification'] == "host"){
        $sql_update_in = "UPDATE visitor SET date_time_in=? WHERE visitor_id=? AND account_id=?";
    		if($stmt_update_in = mysqli_prepare($conn, $sql_update_in)){
    			mysqli_stmt_bind_param($stmt_update_in, "sss", $param_date_time_in, $param_visitor_id, $param_account_id);
    			$param_date_time_in = $param_date_time_in = date("Y-m-d H:i:s");
    			$param_visitor_id = $visitor_id;
    			$param_account_id = $accountId;
    			if(mysqli_stmt_execute($stmt_update_in)){
              header("location: visitor_complete.php?fd=$form_id&ll=$location_level&ld=$location_id");
    			}
    		}
      }

      if($row_field_search['email_notification'] == "off"){
        $sql_update_in = "UPDATE visitor SET date_time_in=? WHERE visitor_id=? AND account_id=?";
    		if($stmt_update_in = mysqli_prepare($conn, $sql_update_in)){
    			mysqli_stmt_bind_param($stmt_update_in, "sss", $param_date_time_in, $param_visitor_id, $param_account_id);
    			$param_date_time_in = $param_date_time_in = date("Y-m-d H:i:s");
    			$param_visitor_id = $visitor_id;
    			$param_account_id = $accountId;
    			if(mysqli_stmt_execute($stmt_update_in)){
              header("location: visitor_complete.php?fd=$form_id&ll=$location_level&ld=$location_id");
    			}
    		}
      }
    }
  }
}

?>
