<?php
require("../../backend/nodes.php");
$title = "Add User";
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
                <form id="form-add-user" method="POST" enctype="multipart/form-data">
                  <div class="mb-3 form-group">
                    <div class='card-body'>
                      <div class='d-flex align-items-start align-items-sm-center gap-4'>
                        <img src='<?= SERVER_NAME . "/custom-assets/images/default.png" ?>' alt='user-avatar' class='d-block rounded' height='100' width='100' style='object-fit: cover' id='uploadedAvatar' />
                        <div class='button-wrapper'>

                          <label for='img_upload' class='btn btn-primary me-2 mb-4' tabindex='0'>
                            <span class='d-none d-sm-block'>Upload new photo</span>
                            <i class='bi bi-upload d-sm-none'></i>

                            <input type='file' id='img_upload' class='account-file-input' accept='image/png, image/jpeg' name='img_upload' hidden />
                          </label>

                          <button type='button' class='btn btn-outline-danger mb-4 d-none' id="btnRemove">
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
                    <input class="form-control form-control-lg" type="text" name="id_number" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Rank/Position</label>
                    <input class="form-control form-control-lg" type="text" name="rank" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input class="form-control form-control-lg" type="text" name="fname" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Middle Name</label>
                    <input class="form-control form-control-lg" type="text" name="mname" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input class="form-control form-control-lg" type="text" name="lname" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input class="form-control form-control-lg" type="text" name="address" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control form-control-lg" type="email" name="email" required />
                  </div>

                  <div class="mb-3">
                    <input class="form-check-input" type="checkbox" name="isAdmin" value="yes" />
                    <label class="form-label">Is Admin</label>
                  </div>

                  <div id="divPassword" class="d-none">
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input class="form-control form-control-lg" type="password" name="password" />
                    </div>

                    <div class="mb-3">
                      <input class="form-check-input" type="checkbox" id="showPassword" />
                      <label class="form-label" for="showPassword">Show Password</label>
                    </div>
                  </div>

                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-lg btn-primary">
                      Add
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
  $("input[name='isAdmin']").on("click", function() {
    if ($(this).is(":checked")) {
      $("#divPassword").removeClass("d-none")
      $("input[name='password']").prop("required", true)
    } else {
      $("#divPassword").addClass("d-none")
      $("input[type='password']").val("")
      $("input[name='password']").prop("required", false)
    }
  })

  $("#showPassword").on("click", function() {
    if ($(this).is(":checked")) {
      $("input[name='password']").prop("type", "text")
    } else {
      $("input[name='password']").prop("type", "password")
    }
  })

  $("#img_upload").change(function() {
    readURL(this);
    $("#btnRemove").removeClass("d-none")
  });

  $("#btnRemove").on("click", function() {
    $(this).addClass("d-none")
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

  $("#form-add-user").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=add_user" ?>`,
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
        }).then(() => data.success ? window.history.back() : undefined)
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
</script>

</html>