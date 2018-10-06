<?php
  require_once 'include/dbConfig.php';
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

      <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="fa fa-cogs"></span>
              </button>

                    <!-- Collection of nav links and other content for toggling -->

                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                          <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <img src="<?=$profile_image?>" alt=""><?=$userName;?>
                              <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                              <li><a href="profile_view.php"> Profile</a></li>
                              <li><a href="#">Help</a></li>
                              <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                          </li>
                          <li><a class="user-profile" href="form_edit_view.php">
                            <img src="images/visitor_in.png" alt="">IN
                          </a></li>
                          <li><a class="user-profile" href="exit_visitor.php">
                            <img src="images/visitor_out.png" alt="">OUT
                          </a></li>
                          <li><a class="user-profile" href="schedule_view.php">
                            <img src="images/schedule.png" alt="">SCHEDULE
                          </a></li>
                        </ul>
                    </div>
            </div>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <script>

        </script>
