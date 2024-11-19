<?php
require("../backend/nodes.php");
$title = "Physical Fitness Test (PFT) Results";
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
                    <th class="text-start">Latest Test Date</th>
                    <th class="text-start">Overall Score/Rating</th>
                    <th class="text-start">Individual Event Scores</th>
                    <th class="text-start">Body Mass Index (BMI)</th>
                    <th class="text-start">Blood Pressure</th>
                    <th class="text-start">Pulse Rate</th>
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

                      $test_date = "---";
                      $overall = "---";
                      $bmi = "---";
                      $bp = "---";
                      $pulse = "---";

                      $event = null;

                      $pft = $helpers->select_all_individual("pft", "user_id='$user->id' ORDER BY id DESC LIMIT 1");
                      if ($pft) {
                        $test_date = date("F d, Y", strtotime($pft->test_date));
                        $overall = $pft->score;
                        $bmi = $pft->bmi;
                        $bp = $pft->bp;
                        $pulse = $pft->pulse_rate;

                        $event = (object)json_decode($pft->event);
                      }
                  ?>
                      <tr>
                        <td class="td-image text-center">
                          <?= $helpers->generate_modal_click_avatar($helpers->get_avatar_link($user->id), $modal_id, $img_id, $caption_id) ?>
                        </td>
                        <td class="text-start"><?= $helpers->get_full_name($user->id) ?></td>
                        <td class="text-start"><?= $test_date ?></td>
                        <td class="text-start"><?= $overall ?></td>
                        <td class="text-start">
                          <?php if ($event): ?>
                            <ul>
                              <li>500 Meter Run: <?= $event->meter_run ?></li>
                              <li>Sit-ups: <?= $event->sit_up ?></li>
                              <li>Push-ups: <?= $event->push_up ?></li>
                              <li>50-meter Swim (or alternative): <?= $event->swim ?></li>
                            </ul>
                          <?php else: ?>
                            ---
                          <?php endif; ?>
                        </td>
                        <td class="text-start"><?= $bmi ?></td>
                        <td class="text-start"><?= $bp ?></td>
                        <td class="text-start"><?= $pulse ?></td>
                        <td class="text-start">
                          <button type="button" onclick='handleViewProfile(`<?= SERVER_NAME . "/views/profile?id=$user->id" ?>`, "#pft")' class="btn btn-primary">
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