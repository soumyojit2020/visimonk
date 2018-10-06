<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();
  $errors = array();
  $name = '';
  $email = '';
  $phone = '';
  $venue = '';
  $date = '';
  $hh = '';
  $mm = '';
  $type = '';

  if(isset($_POST) && !empty($_POST)){
    if(isset($_POST['column1']) && !empty($_POST['column1'])){
      $name = clean($_POST['column1'][0]);
      $email = clean($_POST['column1'][1]);
      $phone = clean($_POST['column1'][2]);
      $venue = clean($_POST['column1'][3]);
      $date = clean($_POST['column1'][4]);
      $hh = clean($_POST['column1'][5]);
      $mm = clean($_POST['column1'][6]);
      $type = clean($_POST['column1'][7]);

      if(empty($errors)){
        //insert into visitor database
        $visitor_id = md5($userId.microtime());
        $sql_visitor = "INSERT INTO visitor (visitor_id, visitor_name, visitor_email, visitor_phone, account_id) VALUES('$visitor_id','$name','$email','$phone','$accountId')";
        if($query_sql_visitor = mysqli_query($conn, $sql_visitor)){
          //send notification email
          $to = "$email";
          $subject = 'VisiMonk Scheduled Meeting Notification!';
          $message = 'Dear '.$name.",". "\r\n"."\r\n".
          'A meeting has been scheduled by- '. "\r\n".
          'Name: '.$userName. "\r\n".
          'Email: '.$userEmail. "\r\n"."\r\n".
          'Meeting Details- '. "\r\n".
          'Venue: '.$venue. "\r\n".
          'Date: '.$date. "\r\n".
          'Time: '.$hh.':'.$mm.' '.$type. "\r\n"."\r\n".
          'Regards,'. "\r\n".
          'Team VisiMonk'. "\r\n";
          $headers = 'From: schedule@visimonk.com' . "\r\n" .
           'Reply-To: support@visimonk.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
           mail($to, $subject, $message, $headers);
        }else{
          $errors[] .= 'Something went wrong! Please try again!';
        }
      }
    }//column1

    if(isset($_POST['column2']) && !empty($_POST['column2'])){
      $name = clean($_POST['column2'][0]);
      $email = clean($_POST['column2'][1]);
      $phone = clean($_POST['column2'][2]);
      $venue = clean($_POST['column2'][3]);
      $date = clean($_POST['column2'][4]);
      $hh = clean($_POST['column2'][5]);
      $mm = clean($_POST['column2'][6]);
      $type = clean($_POST['column2'][7]);

      if(empty($errors)){
        //insert into visitor database
        $visitor_id = md5($userId.microtime());
        $sql_visitor = "INSERT INTO visitor (visitor_id, visitor_name, visitor_email, visitor_phone, account_id) VALUES('$visitor_id','$name','$email','$phone', '$accountId')";
        if($query_sql_visitor = mysqli_query($conn, $sql_visitor)){
          //send notification email
          $to = "$email";
          $subject = 'VisiMonk Scheduled Meeting Notification!';
          $message = 'Dear '.$name.",". "\r\n"."\r\n".
          'A meeting has been scheduled by- '. "\r\n".
          'Name: '.$userName. "\r\n".
          'Email: '.$userEmail. "\r\n"."\r\n".
          'Meeting Details- '. "\r\n".
          'Venue: '.$venue. "\r\n".
          'Date: '.$date. "\r\n".
          'Time: '.$hh.':'.$mm.' '.$type. "\r\n"."\r\n".
          'Regards,'. "\r\n".
          'Team VisiMonk'. "\r\n";
          $headers = 'From: visimonk2018@gmail.com' . "\r\n" .
           'Reply-To: visimonk2018@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
           mail($to, $subject, $message, $headers);
        }else{
          $errors[] .= 'Something went wrong! Please try again!';
        }
      }
    }//column2

    if(isset($_POST['column3']) && !empty($_POST['column3'])){
      $name = clean($_POST['column3'][0]);
      $email = clean($_POST['column3'][1]);
      $phone = clean($_POST['column3'][2]);
      $venue = clean($_POST['column3'][3]);
      $date = clean($_POST['column3'][4]);
      $hh = clean($_POST['column3'][5]);
      $mm = clean($_POST['column3'][6]);
      $type = clean($_POST['column3'][7]);

      if(empty($errors)){
        //insert into visitor database
        $visitor_id = md5($userId.microtime());
        $sql_visitor = "INSERT INTO visitor (visitor_id, visitor_name, visitor_email, visitor_phone, account_id) VALUES('$visitor_id','$name','$email','$phone', '$accountId')";
        if($query_sql_visitor = mysqli_query($conn, $sql_visitor)){
          //send notification email
          $to = "$email";
          $subject = 'VisiMonk Scheduled Meeting Notification!';
          $message = 'Dear '.$name.",". "\r\n"."\r\n".
          'A meeting has been scheduled by- '. "\r\n".
          'Name: '.$userName. "\r\n".
          'Email: '.$userEmail. "\r\n"."\r\n".
          'Meeting Details- '. "\r\n".
          'Venue: '.$venue. "\r\n".
          'Date: '.$date. "\r\n".
          'Time: '.$hh.':'.$mm.' '.$type. "\r\n"."\r\n".
          'Regards,'. "\r\n".
          'Team VisiMonk'. "\r\n";
          $headers = 'From: visimonk2018@gmail.com' . "\r\n" .
           'Reply-To: visimonk2018@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
           mail($to, $subject, $message, $headers);
        }else{
          $errors[] .= 'Something went wrong! Please try again!';
        }
      }
    }//column3

    if(isset($_POST['column4']) && !empty($_POST['column4'])){
      $name = clean($_POST['column4'][0]);
      $email = clean($_POST['column4'][1]);
      $phone = clean($_POST['column4'][2]);
      $venue = clean($_POST['column4'][3]);
      $date = clean($_POST['column4'][4]);
      $hh = clean($_POST['column4'][5]);
      $mm = clean($_POST['column4'][6]);
      $type = clean($_POST['column4'][7]);

      if(empty($errors)){
        //insert into visitor database
        $visitor_id = md5($userId.microtime());
        $sql_visitor = "INSERT INTO visitor (visitor_id, visitor_name, visitor_email, visitor_phone, account_id) VALUES('$visitor_id','$name','$email','$phone', '$accountId')";
        if($query_sql_visitor = mysqli_query($conn, $sql_visitor)){
          //send notification email
          $to = "$email";
          $subject = 'VisiMonk Scheduled Meeting Notification!';
          $message = 'Dear '.$name.",". "\r\n"."\r\n".
          'A meeting has been scheduled by- '. "\r\n".
          'Name: '.$userName. "\r\n".
          'Email: '.$userEmail. "\r\n"."\r\n".
          'Meeting Details- '. "\r\n".
          'Venue: '.$venue. "\r\n".
          'Date: '.$date. "\r\n".
          'Time: '.$hh.':'.$mm.' '.$type. "\r\n"."\r\n".
          'Regards,'. "\r\n".
          'Team VisiMonk'. "\r\n";
          $headers = 'From: visimonk2018@gmail.com' . "\r\n" .
           'Reply-To: visimonk2018@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
           mail($to, $subject, $message, $headers);
        }else{
          $errors[] .= 'Something went wrong! Please try again!';
        }
      }
    }//column4

    if(isset($_POST['column5']) && !empty($_POST['column5'])){
      $name = clean($_POST['column5'][0]);
      $email = clean($_POST['column5'][1]);
      $phone = clean($_POST['column5'][2]);
      $venue = clean($_POST['column5'][3]);
      $date = clean($_POST['column5'][4]);
      $hh = clean($_POST['column5'][5]);
      $mm = clean($_POST['column5'][6]);
      $type = clean($_POST['column5'][7]);

      if(empty($errors)){
        //insert into visitor database
        $visitor_id = md5($userId.microtime());
        $sql_visitor = "INSERT INTO visitor (visitor_id, visitor_name, visitor_email, visitor_phone, account_id) VALUES('$visitor_id','$name','$email','$phone', '$accountId')";
        if($query_sql_visitor = mysqli_query($conn, $sql_visitor)){
          //send notification email
          $to = "$email";
          $subject = 'VisiMonk Scheduled Meeting Notification!';
          $message = 'Dear '.$name.",". "\r\n"."\r\n".
          'A meeting has been scheduled by- '. "\r\n".
          'Name: '.$userName. "\r\n".
          'Email: '.$userEmail. "\r\n"."\r\n".
          'Meeting Details- '. "\r\n".
          'Venue: '.$venue. "\r\n".
          'Date: '.$date. "\r\n".
          'Time: '.$hh.':'.$mm.' '.$type. "\r\n"."\r\n".
          'Regards,'. "\r\n".
          'Team VisiMonk'. "\r\n";
          $headers = 'From: visimonk2018@gmail.com' . "\r\n" .
           'Reply-To: visimonk2018@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
           mail($to, $subject, $message, $headers);
        }else{
          $errors[] .= 'Something went wrong! Please try again!';
        }
      }
    }//column5

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
                <h3>Schedule Meeting</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                  <div class="input-group">
                    <a href="bulk_schedule.php"><button class="btn btn-primary" type="button">Bulk Schedule</button></a>
                  </div>
                </div>
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
                      <form data-parsley-validate class="form-horizontal" action="schedule_view.php" method="POST">
                        <div class="table-responsive">
    											<table class="table table-bordered">
                            <thead>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Venue</th>
                              <th>Date</th>
                              <th>Time</th>
                            </thead>
                            <tbody>
                              <tr>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column1[]" required="required" placeholder="Visitor Name"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column1[]" required="required" placeholder="Visitor Email"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column1[]" required="required" placeholder="Visitor Phone"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column1[]" required="required" placeholder="Venue"/></td>
                                <td>
                                  <input type="text" class="form-control col-md-7 col-xs-12" name="column1[]" required="required" placeholder="DD/MM/YYYY"/>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column1[]" required="required"  class="form-control col-md-7 col-xs-12" placeholder="HH" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column1[]" required="required"  class="form-control col-md-7 col-xs-12" placeholder="MM" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text"  style="text-transform:uppercase" name="column1[]" required="required"  class="form-control col-md-7 col-xs-12" placeholder="AM/PM" value=""/>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column2[]" placeholder="Visitor Name"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column2[]" placeholder="Visitor Email"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column2[]" placeholder="Visitor Phone"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column2[]" placeholder="Venue"/></td>
                                <td>
                                  <input type="text" class="form-control col-md-7 col-xs-12" name="column2[]" placeholder="DD/MM/YYYY"/>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column2[]"  class="form-control col-md-7 col-xs-12" placeholder="HH" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column2[]"  class="form-control col-md-7 col-xs-12" placeholder="MM" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text"  style="text-transform:uppercase" name="column2[]"  class="form-control col-md-7 col-xs-12" placeholder="AM/PM" value=""/>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column3[]" placeholder="Visitor Name"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column3[]" placeholder="Visitor Email"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column3[]" placeholder="Visitor Phone"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column3[]" placeholder="Venue"/></td>
                                <td>
                                  <input type="text" class="form-control col-md-7 col-xs-12" name="column3[]" placeholder="DD/MM/YYYY"/>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column3[]"  class="form-control col-md-7 col-xs-12" placeholder="HH" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column3[]"  class="form-control col-md-7 col-xs-12" placeholder="MM" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text"  style="text-transform:uppercase" name="column3[]"  class="form-control col-md-7 col-xs-12" placeholder="AM/PM" value=""/>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column4[]" placeholder="Visitor Name"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column4[]" placeholder="Visitor Email"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column4[]" placeholder="Visitor Phone"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column4[]" placeholder="Venue"/></td>
                                <td>
                                  <input type="text" class="form-control col-md-7 col-xs-12" name="column4[]" placeholder="DD/MM/YYYY"/>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column4[]"  class="form-control col-md-7 col-xs-12" placeholder="HH" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column4[]"  class="form-control col-md-7 col-xs-12" placeholder="MM" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text"  style="text-transform:uppercase" name="column4[]"  class="form-control col-md-7 col-xs-12" placeholder="AM/PM" value=""/>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column5[]" placeholder="Visitor Name"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column5[]" placeholder="Visitor Email"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column5[]" placeholder="Visitor Phone"/></td>
                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="column5[]" placeholder="Venue"/></td>
                                <td>
                                  <input type="text" class="form-control col-md-7 col-xs-12" name="column5[]" placeholder="DD/MM/YYYY"/>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column5[]"  class="form-control col-md-7 col-xs-12" placeholder="HH" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text" name="column5[]"  class="form-control col-md-7 col-xs-12" placeholder="MM" value=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <input type="text"  style="text-transform:uppercase" name="column5[]"  class="form-control col-md-7 col-xs-12" placeholder="AM/PM" value=""/>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" type="button" href="index.php">Cancel</a>
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
