<?php
require("../backend/nodes.php");
$title = "Appointment Data";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require("../views/components/head.php"); ?>
</head>

<body>
  <div class="wrapper">
    <?php require("./components/side-bar.php") ?>

    <div class="main">
      <?php require("./components/nav-bar.php") ?>

      <main class="content">
        <div class="container-fluid p-0">
          <div class="mb-3">
            <h1 class="h3 d-inline align-middle"><?= $title ?></h1>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-striped dataTable-table datatable">
                <thead>
                  <tr>
                    <th class="text-center">Avatar</th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Latest Appointment Date</th>
                    <th class="text-start">Appointment Type</th>
                    <th class="text-start">Assignment/Station</th>
                    <th class="text-start">Tenure</th>
                    <th class="text-start">Status</th>
                    <th class="text-start">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $userData = $helpers->select_all("users");
                  if ($userData):
                    foreach ($userData as $user):
                      $modal_id = "company-img-modal_$user->id";
                      $img_id = "company-image_$user->id";
                      $caption_id = "company-caption_$user->id";

                      $appointmentDate = "---";
                      $appointmentType = "---";
                      $assignment = "---";
                      $tenure = "---";
                      $status = "---";

                      $appointment = $helpers->select_all_individual("appointment", "user_id='$user->id' ORDER BY id DESC LIMIT 1");
                      if ($appointment) {
                        $appointmentDate =  date("F d, Y", strtotime($appointment->appointment_date));
                        $appointmentType = $appointment->appointment_type;
                        $assignment = $appointment->assignment_station == "Janiuay Municipal Police Station" ? $appointment->assignment_station : "Specific Unit/Section: $appointment->assignment_station";
                        $tenure = $appointment->tenure;
                        $status = $appointment->appointment_type;
                      }
                  ?>
                      <tr>
                        <td class="td-image text-center">
                          <?= $helpers->generate_modal_click_avatar($helpers->get_avatar_link($user->id), $modal_id, $img_id, $caption_id) ?>
                        </td>
                        <td class="text-start"><?= $helpers->get_full_name($user->id) ?></td>
                        <td class="text-start"><?= $appointmentDate ?></td>
                        <td class="text-start"><?= $appointmentType ?></td>
                        <td class="text-start"><?= $assignment ?></td>
                        <td class="text-start"><?= $tenure ?></td>
                        <td class="text-start"><?= $status ?></td>
                        <td class="text-start">
                          <button type="button" onclick='handleViewProfile(`<?= SERVER_NAME . "/views/profile?id=$user->id" ?>`, "#appointment")' class="btn btn-primary">
                            View Profile
                          </button>
                        </td>
                      </tr>
                      <?= $helpers->generate_modal_img($modal_id, $img_id, $caption_id) ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
<?php require("../views/components/script.php"); ?>

</html>