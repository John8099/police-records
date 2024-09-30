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
  $role = $_POST["role"];

  $user = $helpers->get_user_by_id($id);

  if ($user) {
    $updateData = array();

    if (password_verify($_POST["new_password"], $user->password)) {
      $updateData = array(
        "password" => $_POST["new_password"],
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
      $response["message"] = "Current password not match!";
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
