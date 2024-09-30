<?php
require("./backend/nodes.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="<?= SERVER_NAME . "/assets/img/icons/icon-48x48.png" ?>" />

  <title>Sign In</title>

  <link rel="stylesheet" href="<?= SERVER_NAME . "/assets/css/app.css" ?>" />

</head>

<body>
  <main class="d-flex w-100">
    <div class="container d-flex flex-column">
      <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
              <p class="lead">
                Sign in to your account to continue
              </p>
            </div>
            
            <div class="card">
              <div class="card-body">
                <div class="m-sm-3">
                  <form id="form-login" action="POST">
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input id="inputPass" class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
                    </div>
                    <div>
                      <div class="form-check align-items-center">
                        <input id="checkShowPass" type="checkbox" class="form-check-input" name="remember-me">
                        <label class="form-check-label text-small" for="customControlInline">Show Password</label>
                      </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                      <button type="submit" class="btn btn-lg btn-primary">
                        Sign in
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
<script src="<?= SERVER_NAME . "/assets/vendors/jquery/jquery.min.js" ?>"></script>
<script src="<?= SERVER_NAME . "/assets/vendors/sweetalert2/sweetalert2.all.min.js" ?>"></script>
<?php require("./views/components/script.php"); ?>

<script>
  $("#form-login").on("submit", function(e) {
    e.preventDefault()
    swal.showLoading();

    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=login" ?>`,
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      dataType: "JSON",
      success: function(data) {
        if (data.success) {
          const role = data.role;
          let path = "<?= SERVER_NAME . "/views" ?>";
          if (role === "admin") {
            path += "/dashboard"
          }

          window.location.href = path
        } else {
          alert(
            "Error",
            data.message,
            "error",
          )
        }

      },
      error: function(data) {
        swal.fire({
          title: "Oops...",
          html: "Something went wrong.",
          icon: "error",
        }).then((d) => showBtnLoading($("#btnLogin"), false));
      },
    });
  })


  $("#checkShowPass").on("change", function() {
    if ($(this).is(":checked")) {
      $("#inputPass").attr("type", "text")
    } else {
      $("#inputPass").attr("type", "password")
    }
  })
</script>

</html>