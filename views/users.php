<?php
require("../backend/nodes.php");
$title = "Users";
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
            <div class="card-header d-flex justify-content-end">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                <i class="bi bi-person-fill-add"></i>
                Add User
              </button>
            </div>
            <div class="card-body">
              <table id="profile-table" class="table table-striped dataTable-table">
                <thead>
                  <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Is Admin</th>
                    <th>Date Created</th>
                    <th>Action</th>
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
                  ?>
                      <tr>
                        <td class="td-image text-center">
                          <?= $helpers->generate_modal_click_avatar($helpers->get_avatar_link($user->id), $modal_id, $img_id, $caption_id) ?>
                        </td>
                        <td><?= $helpers->get_full_name($user->id) ?></td>
                        <td><?= $user->address ?></td>
                        <td><?= $user->email ?></td>
                        <td>
                          <?php
                          if ($user->role == "admin") :
                          ?>
                            <span class="badge bg-success">Yes</span>
                          <?php else: ?>
                            <span class="badge bg-danger">No</span>
                          <?php endif; ?>
                        </td>
                        <td><?= date("F d, Y", strtotime($user->date_created)) ?></td>
                        <td>
                          <a href="<?= SERVER_NAME . "/views/profile?id=$user->id" ?>" class="btn btn-primary">
                            View Profile
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

<script>
  new DataTable("#profile-table", {
    responsive: true,
    ordering: false
  });
</script>

</html>