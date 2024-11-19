<?php
session_start();
date_default_timezone_set("Asia/Manila");

require(__DIR__ . "/conn.php");
require(__DIR__ . "/Helpers.php");

$helpers = new Helpers($conn, $_SESSION);
try {
  if (isset($_GET["action"])) {

    switch ($_GET["action"]) {
      case "logout":
        logout();
        break;
      case "login":
        login();
        break;
      case "save_profile_image":
        save_profile_image();
        break;
      case "change_password":
        change_password();
        break;
      case "make_user_admin":
        make_user_admin();
        break;
      case "add_training":
        add_training();
        break;
      case "edit_training":
        edit_training();
        break;
      case "add_eligibility":
        add_eligibility();
        break;
      case "edit_eligibility":
        edit_eligibility();
        break;
      case "add_promotion":
        add_promotion();
        break;
      case "edit_promotion":
        edit_promotion();
        break;
      case "add_pft":
        add_pft();
        break;
      case "edit_pft":
        edit_pft();
        break;
      case "add_user":
        add_user();
        break;
      case "edit_user":
        edit_user();
        break;
      case "make_admin":
        make_admin();
        break;
      case "revoke_admin":
        revoke_admin();
        break;
      case "add_iper":
        add_iper();
        break;
      case "update_iper":
        update_iper();
        break;
      case "add_appointment_data":
        add_appointment_data();
        break;
      case "update_appointment_data":
        update_appointment_data();
        break;
      case "change_status":
        change_status();
        break;
      case "delete_data":
        delete_data();
        break;
      default:
        $response["success"] = false;
        $response["message"] = "Case action not found!";

        null;
        $helpers->return_response($response);
    }
  }
} catch (Exception $e) {
  $response["success"] = false;
  $response["message"] = $e->getMessage();
  $helpers->return_response($response);
}

function change_status()
{
  global $helpers, $_POST, $conn;

  $appointment_id = $_POST["appointment_id"];
  $status = $_POST["status"];

  $upData = array(
    "status" => $status,
  );

  $update = $helpers->update("appointment", $upData, "id", $appointment_id);

  if ($update) {
    $response["success"] = true;
    $response["message"] = "Status successfully change";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function update_appointment_data()
{
  global $helpers, $_POST, $conn;

  $appointment_id = $_POST["appointment_id"];
  $appointment_date = $_POST["appointment_date"];
  $appointment_type = $_POST["appointment_type"];
  $assignment_station = $_POST["assignment_station"];
  $other = $_POST["other"];
  $tenure = $_POST["tenure"];
  $status = $_POST["status"];
  $salary = $_POST["salary"];
  $gsis = $_POST["gsis"];
  $phil_health = $_POST["phil_health"];
  $pag_ibig = $_POST["pag_ibig"];

  $updateData = array(
    "appointment_type" => $appointment_type,
    "assignment_station" => $assignment_station == "Specific Unit/Section" ? $other : $assignment_station,
    "tenure" => $tenure,
    "status" => $status,
    "salary" => $salary,
    "gsis" => $gsis,
    "phil_health" => $phil_health,
    "pag_ibig" => $pag_ibig,
    "appointment_date" => $appointment_date,
  );

  $up = $helpers->update("appointment", $updateData, "id", $appointment_id);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "Appointment Data successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_appointment_data()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $appointment_date = $_POST["appointment_date"];
  $appointment_type = $_POST["appointment_type"];
  $assignment_station = $_POST["assignment_station"];
  $other = $_POST["other"];
  $tenure = $_POST["tenure"];
  $status = $_POST["status"];
  $salary = $_POST["salary"];
  $gsis = $_POST["gsis"];
  $phil_health = $_POST["phil_health"];
  $pag_ibig = $_POST["pag_ibig"];

  $inData = array(
    "user_id" => $id,
    "appointment_type" => $appointment_type,
    "assignment_station" => $assignment_station == "Specific Unit/Section" ? $other : $assignment_station,
    "tenure" => $tenure,
    "status" => $status,
    "salary" => $salary,
    "gsis" => $gsis,
    "phil_health" => $phil_health,
    "pag_ibig" => $pag_ibig,
    "appointment_date" => $appointment_date,
  );

  $in = $helpers->insert("appointment", $inData);

  if ($in) {
    $response["success"] = true;
    $response["message"] = "Appointment Data successfully added";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function update_iper()
{
  global $helpers, $_POST, $conn;

  $iper_id = $_POST["iper_id"];
  $start_date = $_POST["start_date"];
  $end_date = $_POST["end_date"];
  $job_responsibilities = $_POST["job_responsibilities"];
  $strength = $_POST["strength"];
  $weakness = $_POST["weakness"];
  $areas_of_improvement = $_POST["areas_of_improvement"];
  $recommendations = $_POST["recommendations"];
  $s_comment = $_POST["s_comment"];
  $e_comment = $_POST["e_comment"];

  $performance_ratings = array(
    "leadership" => $_POST["leadership"],
    "job_knowledge" => $_POST["job_knowledge"],
    "communication" => $_POST["communication"],
    "teamwork" => $_POST["teamwork"],
    "integrity" => $_POST["integrity"],
  );

  $upData = array(
    "evaluation_period" => ("$start_date - $end_date"),
    "responsibilities" => json_encode($job_responsibilities),
    "performance_ratings" => json_encode($performance_ratings),
    "strengths" => nl2br($strength),
    "weakness" => nl2br($weakness),
    "areas_of_improvement" => $areas_of_improvement,
    "recommendations" => $recommendations,
    "supervisor_comment" => nl2br($s_comment),
    "employee_comment" => nl2br($e_comment),
  );

  $up = $helpers->update("iper", $upData, "id", $iper_id);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "IPER successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_iper()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $start_date = $_POST["start_date"];
  $end_date = $_POST["end_date"];
  $job_responsibilities = $_POST["job_responsibilities"];
  $strength = $_POST["strength"];
  $weakness = $_POST["weakness"];
  $areas_of_improvement = $_POST["areas_of_improvement"];
  $recommendations = $_POST["recommendations"];
  $s_comment = $_POST["s_comment"];
  $e_comment = $_POST["e_comment"];

  $performance_ratings = array(
    "leadership" => $_POST["leadership"],
    "job_knowledge" => $_POST["job_knowledge"],
    "communication" => $_POST["communication"],
    "teamwork" => $_POST["teamwork"],
    "integrity" => $_POST["integrity"],
  );

  $inData = array(
    "user_id" => $id,
    "evaluation_period" => ("$start_date - $end_date"),
    "responsibilities" => json_encode($job_responsibilities),
    "performance_ratings" => json_encode($performance_ratings),
    "strengths" => nl2br($strength),
    "weakness" => nl2br($weakness),
    "areas_of_improvement" => $areas_of_improvement,
    "recommendations" => $recommendations,
    "supervisor_comment" => nl2br($s_comment),
    "employee_comment" => nl2br($e_comment),
  );

  $in = $helpers->insert("iper", $inData);

  if ($in) {
    $response["success"] = true;
    $response["message"] = "IPER successfully added";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function revoke_admin()
{
  global $helpers, $_POST, $conn;

  $user_id = $_POST["user_id"];

  $upData = array(
    "role" => "user",
    "password" => "set_null"
  );

  $update = $helpers->update("users", $upData, "id", $user_id);

  if ($update) {
    $response["success"] = true;
    $response["message"] = "User successfully revoke as admin";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function make_admin()
{
  global $helpers, $_POST, $conn;

  $user_id = $_POST["user_id"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $upData = array(
    "role" => "admin",
    "password" => $password
  );

  $update = $helpers->update("users", $upData, "id", $user_id);

  if ($update) {
    $response["success"] = true;
    $response["message"] = "User successfully convert to admin";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function edit_user()
{
  global $helpers, $_POST, $_FILES, $conn;

  $id = $_POST["id"];
  $removeImage = $_POST["removeImage"];

  $img_upload = $_FILES["img_upload"];

  $id_number = $_POST["id_number"];
  $fname = $_POST["fname"];
  $mname = $_POST["mname"];
  $lname = $_POST["lname"];
  $rank = isset($_POST["rank"]) ? $_POST["rank"] : null;
  $address = $_POST["address"];
  $email = $_POST["email"];

  $path = "../uploads/avatars";

  $emailData = $helpers->get_user_by_email($email, $id);
  $userData = $helpers->get_user_by_id($id);

  if ($emailData) {
    $response["success"] = false;
    $response["message"] = "Email Already exist";
  } else {
    $upData = array(
      "id_number" => $id_number,
      "rank_position" => $rank,
      "first_name" => $fname,
      "middle_name" => $mname,
      "last_name" => $lname,
      "address" => $address,
      "email" => $email,
      "avatar" => $removeImage == "TRUE" ? "set_null" : ""
    );

    if ($removeImage == "FALSE") {
      if (intval($img_upload["error"]) == 0) {

        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }
        $fileName = uniqid() . '_' . $img_upload["name"];

        if (move_uploaded_file($img_upload['tmp_name'], "$path/$fileName")) {
          $upData["avatar"] = $fileName;
        }

        if ($userData->avatar) {
          if (file_exists("$path/$userData->avatar")) {
            unlink("$path/$userData->avatar");
          }
        }
      }
    }

    $up = $helpers->update("users", $upData, "id", $id);

    if ($up) {
      $response["success"] = true;
      $response["message"] = "User successfully updated";

      if ($upData["avatar"] == "set_null") {
        if (file_exists("$path/$userData->avatar")) {
          unlink("$path/$userData->avatar");
        }
      }
    } else {
      $response["success"] = false;
      $response["message"] = $conn->error;
    }
  }

  $helpers->return_response($response);
}

function add_user()
{
  global $helpers, $_POST, $_FILES, $conn;

  $img_upload = $_FILES["img_upload"];

  $id_number = $_POST["id_number"];
  $fname = $_POST["fname"];
  $mname = $_POST["mname"];
  $lname = $_POST["lname"];
  $rank = $_POST["rank"];
  $address = $_POST["address"];
  $email = $_POST["email"];
  $isAdmin = isset($_POST["isAdmin"]) ? $_POST["isAdmin"] : null;
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $path = "../uploads/avatars";

  $emailData = $helpers->get_user_by_email($email);

  if ($emailData) {
    $response["success"] = false;
    $response["message"] = "Email Already exist";
  } else {
    $inData = array(
      "id_number" => $id_number,
      "rank_position" => $rank,
      "first_name" => $fname,
      "middle_name" => $mname,
      "last_name" => $lname,
      "address" => $address,
      "email" => $email,
      "password" => $isAdmin ? $password : null,
      "role" => $isAdmin ? "admin" : "user",
      "avatar" => null
    );

    if (intval($img_upload["error"]) == 0) {

      if (!is_dir($path)) {
        mkdir($path, 0777, true);
      }
      $fileName = uniqid() . '_' . $img_upload["name"];

      if (move_uploaded_file($img_upload['tmp_name'], "$path/$fileName")) {
        $inData["avatar"] = $fileName;
      }
    }

    $in = $helpers->insert("users", $inData);

    if ($in) {
      $response["success"] = true;
      $response["message"] = "User successfully added";
    } else {
      $response["success"] = false;
      $response["message"] = $conn->error;

      if ($inData["avatar"]) {
        unlink("$path/$inData[avatar]");
      }
    }
  }

  $helpers->return_response($response);
}

function edit_pft()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $test_date = $_POST["test_date"];
  $overall = $_POST["overall"];
  $bmi = $_POST["bmi"];
  $bp = $_POST["bp"];
  $pulse = $_POST["pulse"];

  $event = array(
    "meter_run" => $_POST["meter_run"],
    "sit_up" => $_POST["sit_up"],
    "push_up" => $_POST["push_up"],
    "swim" => $_POST["swim"],
  );

  $upData = array(
    "score" => $overall,
    "event" => json_encode($event),
    "bmi" => $bmi,
    "bp" => $bp,
    "pulse_rate" => $pulse,
    "test_date" => $test_date,
  );

  $com = $helpers->update("pft", $upData, "id", $id);

  if ($com) {
    $response["success"] = true;
    $response["message"] = "PFT successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_pft()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $test_date = $_POST["test_date"];
  $overall = $_POST["overall"];
  $bmi = $_POST["bmi"];
  $bp = $_POST["bp"];
  $pulse = $_POST["pulse"];

  $event = array(
    "meter_run" => $_POST["meter_run"],
    "sit_up" => $_POST["sit_up"],
    "push_up" => $_POST["push_up"],
    "swim" => $_POST["swim"],
  );

  $inData = array(
    "user_id" => $id,
    "score" => $overall,
    "event" => json_encode($event),
    "bmi" => $bmi,
    "bp" => $bp,
    "pulse_rate" => $pulse,
    "test_date" => $test_date,
  );

  $com = $helpers->insert("pft", $inData);

  if ($com) {
    $response["success"] = true;
    $response["message"] = "PFT successfully added";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function edit_promotion()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $rank = $_POST["rank"];
  $authority = $_POST["authority"];
  $effective_date = $_POST["effective_date"];

  $upData = array(
    "rank" => $rank,
    "authority" => $authority,
    "effective_date" => $effective_date,
  );

  $up = $helpers->update("promotions", $upData, "id", $id);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "User promotion successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_promotion()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $rank = $_POST["rank"];
  $authority = $_POST["authority"];
  $effective_date = $_POST["effective_date"];

  $inData = array(
    "user_id" => $id,
    "rank" => $rank,
    "authority" => $authority,
    "effective_date" => $effective_date,
  );

  $up = $helpers->insert("promotions", $inData);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "User successfully promoted";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function edit_eligibility()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $title = $_POST["title"];
  $rating = $_POST["rating"];
  $place = $_POST["place"];
  $date = $_POST["date"];

  $upData = array(
    "title" => $title,
    "rating" => $rating,
    "place" => $place,
    "date" => $date,
  );

  $up = $helpers->update("eligibility", $upData, "id", $id);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "Eligibility successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_eligibility()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $title = $_POST["title"];
  $rating = $_POST["rating"];
  $place = $_POST["place"];
  $date = $_POST["date"];

  $inData = array(
    "user_id" => $id,
    "title" => $title,
    "rating" => $rating,
    "place" => $place,
    "date" => $date,
  );

  $up = $helpers->insert("eligibility", $inData);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "Eligibility successfully added";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function edit_training()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $course = $_POST["course"];
  $authority = $_POST["authority"];
  $start_date = $_POST["start_date"];
  $end_date = $_POST["end_date"];

  $upData = array(
    "course_title" => $course,
    "authority" => $authority,
    "start_date" => $start_date,
    "end_date" => $end_date,
  );

  $up = $helpers->update("trainings", $upData, "id", $id);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "Training successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_training()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $course = $_POST["course"];
  $authority = $_POST["authority"];
  $start_date = $_POST["start_date"];
  $end_date = $_POST["end_date"];

  $inData = array(
    "user_id" => $id,
    "course_title" => $course,
    "authority" => $authority,
    "start_date" => $start_date,
    "end_date" => $end_date,
  );

  $up = $helpers->insert("trainings", $inData);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "Training successfully added";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function make_user_admin()
{
  global $helpers, $_POST, $conn;

  $upData = array(
    "role" => "admin"
  );

  $up = $helpers->update("users", $upData, "id", $_POST["user_id"]);

  if ($up) {
    $response["success"] = true;
    $response["message"] = "User set as Admin";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function change_password()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];

  $user = $helpers->get_user_by_id($id);

  if ($user) {
    $updateData = array();

    if (password_verify($_POST["old_password"], $user->password)) {
      $updateData = array(
        "password" => password_hash($_POST["new_password"], PASSWORD_DEFAULT),
      );
    }

    if (count($updateData) > 0) {
      $update = $helpers->update("users", $updateData, "id", $_POST["id"]);

      if ($update) {
        $response["success"] = true;
        $response["message"] = "Password successfully updated!";
      } else {
        $response["success"] = false;
        $response["message"] = ("Error updating password: " . $conn->error);
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Old password not match!";
    }
  } else {
    $response["success"] = false;
    $response["message"] = "User not found!";
  }

  $helpers->return_response($response);
}

function save_profile_image()
{
  global $helpers, $_FILES, $_POST, $_SESSION;

  $role = $_SESSION["role"];
  $action = $_POST["action"];
  $set_image_null = boolval($_POST["set_image_null"]);
  $id = $_POST["id"];

  $image_url = "";

  $userData = $helpers->select_all_individual($role == "customer" ? "customers" : "users", "id = '$id'");

  if ($action == "upload") {
    $file = $helpers->upload_single_file($_FILES["file"], "../uploads/avatars");

    if ($file->success) {
      $file_name = $file->file_name;

      $image_url = SERVER_NAME . "/uploads/avatars/$file_name";

      $uploadData = array(
        "avatar" => $file_name
      );
    } else {
      $response["success"] = false;
      $response["message"] = "Error uploading image";
    }
  } else if ($action == "remove") {
    $image_url = SERVER_NAME . "/custom-assets/images/default.png";

    $uploadData = array(
      "avatar" => $set_image_null ? "set_null" : null,
    );
  } else {
    $image_url = SERVER_NAME . "/custom-assets/images/default.png";

    $response["success"] = false;
    $response["message"] = "Error updating image";
  }

  $update = $helpers->update($role == "customer" ? "customers" : "users", $uploadData, "id", $id);

  if ($update) {
    $response["success"] = true;
    $response["image_url"] = $image_url;

    if ($userData->avatar) {
      unlink("../uploads/avatars/$userData->avatar");
    }
  } else {
    $response["success"] = false;
    $response["message"] = "Error updating image";
  }

  $helpers->return_response($response);
}

function logout()
{
  global $helpers;
  $path = SERVER_NAME . "/";
  $helpers->user_logout($path);
}

function login()
{
  global $_POST, $helpers;

  $email = $_POST["email"];
  $password = $_POST["password"];

  $user = $helpers->get_user_by_email($email);

  if ($user) {
    if (password_verify($password, $user->password)) {
      $_SESSION["id"] = $user->id;

      $response["success"] = true;
      $response["role"] = $user->role;
    } else {
      $response["success"] = false;
      $response["message"] = "Password not match.";
    }
  } else {
    $response["success"] = false;
    $response["message"] = "User not found.";
  }

  $helpers->return_response($response);
}

function delete_data()
{
  global $helpers, $_POST, $conn;

  $table = $_POST["table"];
  $column = $_POST["column"];
  $id = $_POST["val"];

  $delete = $helpers->delete($table, $column, $id);

  if ($delete) {
    $response["success"] = true;
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}
