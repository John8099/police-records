<?php
require("../../backend/nodes.php");
$title = "Add Physical Fitness Test (PFT) Results";
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
            <?php $userData = $helpers->select_all_individual("users", "id=$_GET[id]"); ?>
            <div class="card-body">
              <div class="container">
                <form id="form-add-pft" method="POST">
                  <input type="text" name="id" value="<?= $userData->id ?>" hidden readonly>
                  <div class="mb-3">
                    <label class="form-label">Test Date</label>
                    <input class="form-control form-control-lg" type="date" name="test_date" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Overall Score/Rating</label>
                    <input class="form-control form-control-lg" type="text" name="overall" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Individual Event Scores:</label>
                    <div class="row px-lg-5">
                      <div class="col-md-12 row align-items-center">
                        <div class="col-3 mb-1">
                          <label for="meterRun" class="col-form-label">500 Meter Run</label>
                        </div>
                        <div class="col-auto">
                          <input type="text" id="meterRun" class="form-control" name="meter_run" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-3 mb-1">
                          <label for="sitUps" class="col-form-label">Sit-ups</label>
                        </div>
                        <div class="col-auto">
                          <input type="text" id="sitUps" class="form-control" name="sit_up" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-3 mb-1">
                          <label for="pushUps" class="col-form-label">Push-ups</label>
                        </div>
                        <div class="col-auto">
                          <input type="text" id="pushUps" class="form-control" name="push_up" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-3 mb-1">
                          <label for="swim" class="col-form-label">50-meter Swim (or alternative)</label>
                        </div>
                        <div class="col-auto">
                          <input type="text" id="swim" class="form-control" name="swim" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Body Mass Index (BMI)</label>
                    <input class="form-control form-control-lg" type="text" name="bmi" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Blood Pressure</label>
                    <input class="form-control form-control-lg" type="text" name="bp" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Pulse Rate</label>
                    <input class="form-control form-control-lg" type="text" name="pulse" required />
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
  $("#form-add-pft").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=add_pft" ?>`,
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
    console.log()
  })
</script>

</html>