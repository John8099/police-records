<?php
require("../backend/nodes.php");
$title = "Change Password";
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
                <form id="form-change-password" method="POST">
                  <input type="text" name="id" value="<?= $USER->id ?>" readonly hidden>
                  <div class="row mb-3">
                    <label for="oldPassword" class="col-md-4 col-lg-3 col-form-label">Old Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="old_password" type="password" class="form-control" id="oldPassword" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="new_password" type="password" class="form-control" id="newPassword" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                      Change Password
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
<?php require("../views/components/script.php"); ?>

<script>
  $("#form-change-password").on("submit", function(e) {
    e.preventDefault();
    const oldPassword = $("#oldPassword").val()
    const newPassword = $("#newPassword").val()
    const confirmPassword = $("#confirmPassword").val()

    if (oldPassword === newPassword) {
      swal.fire({
        title: "Error",
        html: "New Password should not be same as Old Password",
        icon: "error",
      })
    } else if (newPassword !== confirmPassword) {
      swal.fire({
        title: "Error",
        html: "New Password and Confirm Password not match",
        icon: "error",
      })
    } else {
      swal.showLoading()

      $.ajax({
        url: `<?= SERVER_NAME . "/backend/nodes?action=change_password" ?>`,
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
    }

  })
</script>

</html>