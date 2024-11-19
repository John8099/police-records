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
              <a href="<?= SERVER_NAME . "/views/add/user" ?>" class="btn btn-primary">
                <i class="bi bi-person-fill-add"></i>
                Add User
              </a>
            </div>
            <div class="card-body">
              <table id="profile-table" class="table table-striped dataTable-table">
                <thead>
                  <tr>
                    <th>Avatar</th>
                    <th class="text-start">ID Number</th>
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
                        <td class="text-start"><?= $user->id_number ?></td>
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
                        <td class="text-center">
                          <a href="<?= SERVER_NAME . "/views/edit/user?id=$user->id" ?>" class="btn btn-warning m-1">
                            Edit
                          </a>
                          <button type="button" onclick='handleViewProfile(`<?= SERVER_NAME . "/views/profile?id=$user->id" ?>`, "#appointment")' class="btn btn-primary">
                            View Profile
                          </button>
                         
                          <?php if ($user->role != "admin"): ?>
                            <button type="button" class="btn btn-secondary m-1" onclick="handleAddPasswordModal(`<?= $user->id ?>`)">
                              Make Admin
                            </button>
                          <?php endif; ?>

                          <?php if ($user->role == "admin" && $user->id != $USER->id): ?>
                            <button type="button" class="btn btn-danger m-1" onclick="handleRemoveAsAdmin(`<?= $user->id ?>`)">
                              Revoke Admin
                            </button>
                          <?php endif; ?>
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

  <div class="modal fade" id="modalAddPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="form-add-password" method="POST">
          <input type="text" id="userID" name="user_id" readonly hidden>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input class="form-control form-control-lg" type="password" name="password" required />
            </div>

            <div class="mb-3">
              <input class="form-check-input" type="checkbox" id="showPassword" />
              <label class="form-label" for="showPassword">Show Password</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

<?php require("../views/components/script.php"); ?>

<script>
  function handleRemoveAsAdmin(id) {
    let fd = new FormData();
    fd.append("user_id", id);

    swal.fire({
        text: "Are you sure you want to revoke user as admin?",
        icon: "warning",
        confirmButtonText: "Yes",
        confirmButtonColor: "#dc3545",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        backdrop: true,
        preConfirm: async (value) => {
          const res = await $.ajax({
            url: `<?= SERVER_NAME . "/backend/nodes?action=revoke_admin" ?>`,
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "JSON",
            success: function(resp) {
              if (!resp.success) {
                return Swal.showValidationMessage(`Error: ${resp.message}`);
              }
            },
          });

          return res;
        },
        allowOutsideClick: () => !Swal.isLoading(),
      })
      .then((d) => {
        if (d.isConfirmed) {
          swal.fire({
              title: !d.value.success ? "Error!" : "Success",
              html: d.value.message,
              icon: !d.value.success ? "error" : "success",
            })
            .then(() => (d.value.success ? window.location.reload() : undefined));
        }
      });
  }

  $("#form-add-password").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=make_admin" ?>`,
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      dataType: "JSON",
      success: function(data) {
        swal.fire({
          title: data.success ? "Success" : "Error",
          html: data.message,
          icon: data.success ? "success" : "error",
        }).then(() => data.success ? window.location.reload() : undefined)
      },
      error: function(data) {
        swal.fire({
          title: "Oops...",
          html: "Something went wrong.",
          icon: "error",
        })
      },
    });
  })

  function handleAddPasswordModal(id) {
    $("#userID").val(id)
    $("#modalAddPassword").modal("show")
  }

  $("#showPassword").on("click", function() {
    if ($(this).is(":checked")) {
      $("input[name='password']").prop("type", "text")
    } else {
      $("input[name='password']").prop("type", "password")
    }
  })

  new DataTable("#profile-table", {
    responsive: true,
    ordering: false
  });
</script>

</html>