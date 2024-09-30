<?php
require("../backend/nodes.php");
$title = "Promotions";
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
                    <th class="text-start">Latest Training</th>
                    <th class="text-start">Effective Date</th>
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

                      $rank = "---";
                      $effectiveDate = "---";

                      $promotion = $helpers->select_all_individual("promotions", "user_id='$user->id' ORDER BY id DESC LIMIT 1");
                      if ($promotion) {
                        $effectiveDate = date("F d, Y", strtotime($promotion->effective_date));
                        $rank = $promotion->rank;
                      }
                  ?>
                      <tr>
                        <td class="td-image text-center">
                          <?= $helpers->generate_modal_click_avatar($helpers->get_avatar_link($user->id), $modal_id, $img_id, $caption_id) ?>
                        </td>
                        <td class="text-start"><?= $helpers->get_full_name($user->id) ?></td>
                        <td class="text-start"><?= $rank ?></td>
                        <td class="text-start"><?= $effectiveDate ?></td>
                        <td class="text-start">
                          <a href="<?= SERVER_NAME . "/views/add-promotion?id=$user->id" ?>" class="btn btn-primary">
                            Add Promotion
                          </a>
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