<?php
if (!isset($_SESSION["id"])) {
  header("location: " . SERVER_NAME . "/");
}

$USER = $helpers->get_current_user();
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="shortcut icon" href="<?= SERVER_NAME . "/assets/img/icons/icon-48x48.png" ?>" />

<title><?= $title ?></title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= SERVER_NAME . "/assets/css/bootstrap.css" ?>" />

<link rel="stylesheet" href="<?= SERVER_NAME . "/assets/vendors/fontawesome/all.min.css" ?>" />
<link rel="stylesheet" href="<?= SERVER_NAME . "/assets/css/app.css" ?>" />
<link rel="stylesheet" href="<?= SERVER_NAME . "/custom-assets/css/custom.css" ?>" />
<link rel="stylesheet" href="<?= SERVER_NAME . "/assets/vendors/toastify/toastify.css" ?>" />

<!-- Datatables -->
<link rel='stylesheet' href='<?= SERVER_NAME . "/assets/vendors/datatables/css/dataTables.bootstrap5.min.css" ?>' />
<link rel='stylesheet' href='<?= SERVER_NAME . "/assets/vendors/datatables/css/responsive.bootstrap5.min.css" ?>' />

<!-- End datatables -->
<link rel="stylesheet" href="<?= SERVER_NAME . "/assets/vendors/toastify/toastify.css" ?>">

<link rel='stylesheet' href="<?= SERVER_NAME . "/custom-assets/components/image-upload/css/bootstrap-imageupload.min.css" ?>">

<script src="<?= SERVER_NAME . "/assets/vendors/jquery/jquery.min.js" ?>"></script>

<script src="<?= SERVER_NAME . "/assets/vendors/sweetalert2/sweetalert2.all.min.js" ?>"></script>
<script src="<?= SERVER_NAME . "/assets/vendors/toastify/toastify.js" ?>"></script>

<!-- <script src="<?= SERVER_NAME . "/assets/js/bootstrap.bundle.min.js" ?>"></script> -->

<script src="<?= SERVER_NAME . "/assets/vendors/jquery-validate/jquery.validate.min.js" ?>"></script>

<script src="<?= SERVER_NAME . "/custom-assets/js/custom.js" ?>"></script>