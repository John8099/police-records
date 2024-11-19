<?php
require("../backend/nodes.php");
$title = "IPER Individual Performance Evaluation Report";
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
                    <th class="text-start">Latest Evaluation Period</th>
                    <th class="text-start">Job Responsibilities</th>
                    <th class="text-start">Performance Ratings</th>
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

                      $evaluation_period = "---";
                      $responsibilities = null;
                      $performance = null;

                      $iper = $helpers->select_all_individual("iper", "user_id='$user->id' ORDER BY id DESC LIMIT 1");
                      if ($iper) {
                        $period = explode(" - ", $iper->evaluation_period);
                        $start = date("F d, Y", strtotime($period[0]));
                        $end = date("F d, Y", strtotime($period[1]));

                        $evaluation_period = "$start - $end";
                        $responsibilities = json_decode($iper->responsibilities, true);;
                        $performance = (object)json_decode($iper->performance_ratings, true);
                      }
                  ?>
                      <tr>
                        <td class="td-image text-center">
                          <?= $helpers->generate_modal_click_avatar($helpers->get_avatar_link($user->id), $modal_id, $img_id, $caption_id) ?>
                        </td>
                        <td class="text-start"><?= $helpers->get_full_name($user->id) ?></td>
                        <td class="text-start"><?= $evaluation_period ?></td>
                        <td class="text-start">
                          <?php if ($responsibilities): ?>
                            <ul>
                              <?php
                              foreach ($responsibilities as $responsibility):
                              ?>
                                <li><?= $responsibility ?></li>
                              <?php endforeach; ?>
                            </ul>
                          <?php else: ?>
                            ---
                          <?php endif; ?>
                        </td>
                        <td class="text-start">
                          <?php if ($performance): ?>
                            <ul>
                              <li>Leadership: <?= $performance->leadership ?></li>
                              <li>Job Knowledge: <?= $performance->job_knowledge ?></li>
                              <li>Communication: <?= $performance->communication ?></li>
                              <li>Teamwork: <?= $performance->teamwork ?></li>
                              <li>Integrity: <?= $performance->integrity ?></li>
                            </ul>
                          <?php else: ?>
                            ---
                          <?php endif; ?>
                        </td>
                        <td class="text-start">
                          <button type="button" onclick='handleViewProfile(`<?= SERVER_NAME . "/views/profile?id=$user->id" ?>`, "#iper")' class="btn btn-primary">
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