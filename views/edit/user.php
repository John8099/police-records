<?php
require("../../backend/nodes.php");
$title = "Edit User";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require("../../views/components/head.php"); ?>
</head>

<body>
  <div class="wrapper">
    <?php require("../components/side-bar.php") ?>

    <div class="main">
      <?php require("../components/nav-bar.php") ?>

      <main class="content">
        <div class="container p-0">
          <div class="mb-3">
            <h1 class="h3 d-inline align-middle"><?= $title ?></h1>
            <button type="button" class="btn btn-secondary float-end" onclick="window.history.back()">
              Go Back
            </button>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="container">
                <?php
                $userData = $helpers->get_user_by_id($_GET["id"]);
                $promotionRec = $helpers->select_all_individual("promotions", "user_id=$_GET[id] ORDER BY id DESC LIMIT 1");
                ?>
                <form id="form-edit-user" method="POST" enctype="multipart/form-data">
                  <input type="text" name="id" value="<?= $userData->id ?>" hidden readonly>
                  <input type="text" name="removeImage" hidden readonly>

                  <div class="mb-3 form-group">
                    <div class='card-body'>
                      <div class='d-flex align-items-start align-items-sm-center gap-4'>
                        <img src='<?= $helpers->get_avatar_link($userData->id) ?>' alt='user-avatar' class='d-block rounded' height='100' width='100' style='object-fit: cover' id='uploadedAvatar' />
                        <div class='button-wrapper'>

                          <label for='img_upload' class='btn btn-primary me-2 mb-4' tabindex='0'>
                            <span class='d-none d-sm-block'>Upload new photo</span>
                            <i class='bi bi-upload d-sm-none'></i>

                            <input type='file' id='img_upload' class='account-file-input' accept='image/png, image/jpeg' name='img_upload' hidden />
                          </label>

                          <button type='button' class='btn btn-outline-danger mb-4 <?= $userData->avatar ? "" : "d-none" ?> ' id="btnRemove">
                            <i class='bi bi-trash d-sm-none'></i>
                            <span class='d-none d-sm-block'>Remove</span>
                          </button>

                          <p class='text-muted mb-0'>Allowed JPG or PNG</p>
                        </div>
                      </div>
                    </div>
                    <hr class='my-0' />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">ID Number</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $userData->id_number ?>" name="id_number" required />
                  </div>

                  <?php if (!$promotionRec): ?>
                    <div class="mb-3">
                      <label class="form-label">Rank/Position</label>
                      <input class="form-control form-control-lg" type="text" value="<?= $userData->rank_position ?>" name="rank" required />
                    </div>
                  <?php endif; ?>

                  <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $userData->first_name ?>" name="fname" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Middle Name</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $userData->middle_name ?>" name="mname" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $userData->last_name ?>" name="lname" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $userData->address ?>" name="address" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control form-control-lg" type="email" value="<?= $userData->email ?>" name="email" required />
                  </div>

                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-lg btn-primary">
                      Save Changes
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
<?php require("../../views/components/script.php"); ?>
<script>
  $("#form-edit-user").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=edit_user" ?>`,
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

  $("#img_upload").change(function() {
    readURL(this);
    $("#btnRemove").removeClass("d-none")
    $("input[name='removeImage']").val("FALSE")
  });

  $("#btnRemove").on("click", function() {
    $(this).addClass("d-none")
    $("input[name='removeImage']").val("TRUE")
    $("#img_upload").val("")
    $('#uploadedAvatar').attr('src', "<?= SERVER_NAME . "/custom-assets/images/default.png" ?>");
  })

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#uploadedAvatar').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

</html>