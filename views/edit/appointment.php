<?php
require("../../backend/nodes.php");
$title = "Edit Appointment Data";
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
            <?php
            $userData = $helpers->select_all_individual("users", "id=$_GET[id]");
            $rank_position = $userData->rank_position;

            $promotionRec = $helpers->select_all_individual("promotions", "user_id=$userData->id ORDER BY id DESC LIMIT 1");
            if ($promotionRec) {
              $rank_position = $promotionRec->rank;
            }

            $appointmentData = $helpers->select_all_individual("appointment", "id=$_GET[aid]");

            ?>
            <div class="card-body">
              <div class="container">
                <form id="form-edit-appointment-data" method="POST">
                  <input type="text" name="appointment_id" value="<?= $appointmentData->id ?>" hidden readonly>
                  <div class="mb-3">
                    <label class="form-label">Appointment Date</label>
                    <input class="form-control form-control-lg" type="date" name="appointment_date" value="<?= $appointmentData->appointment_date ?>" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Appointment Type</label>
                    <select class="form-select mb-3" name="appointment_type" required>
                      <?php
                      $appointmentTypes = array(
                        "Original",
                        "Promotion",
                        "Transfer",
                        "Reassignment"
                      );
                      foreach ($appointmentTypes as $appointmentType) :
                      ?>
                        <option value="<?= $appointmentType ?>" <?= $helpers->is_selected($appointmentType, $appointmentData->appointment_type) ?>>
                          <?= $appointmentType ?>
                        </option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Rank/Position</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $rank_position ?>" readonly />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Assignment/Station</label>
                    <select class="form-select mb-3" name="assignment_station" required>
                      <?php
                      $assignments = array(
                        "Janiuay Municipal Police Station",
                        "Specific Unit/Section",
                      );
                      $assign = $appointmentData->assignment_station;
                      $is_specific = false;

                      if (!in_array($appointmentData->assignment_station, $assignments)) {
                        $assign = "Specific Unit/Section";
                        $is_specific = true;
                      }

                      foreach ($assignments as $assignment) :
                      ?>
                        <option value="<?= $assignment ?>" <?= $helpers->is_selected($assignment, $assign) ?>>
                          <?= $assignment ?>
                        </option>
                      <?php endforeach ?>
                    </select>
                    <input class="form-control form-control-lg <?= $is_specific ? "" : "d-none" ?>" name="other" <?= $is_specific ? "value='$appointmentData->assignment_station'" : "" ?> type="text" />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Tenure (length of service, years/months)</label>
                    <input class="form-control form-control-lg" type="text" name="tenure" value="<?= $appointmentData->tenure ?>" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select class="form-select mb-3" name="status" required>
                      <?php
                      $statuses = array(
                        "Active",
                        "Leave",
                        "Resigned",
                        "Retired"
                      );
                      foreach ($statuses as $status) :
                      ?>
                        <option value="<?= $status ?>" <?= $helpers->is_selected($status, $appointmentData->status) ?>>
                          <?= $status ?>
                        </option>
                      <?php endforeach ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Salary Grade/Step</label>
                    <input class="form-control form-control-lg" type="text" name="salary" value="<?= $appointmentData->salary ?>" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Government Service Insurance System (GSIS) Number</label>
                    <input class="form-control form-control-lg" type="text" name="gsis" value="<?= $appointmentData->gsis ?>" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">PhilHealth Number</label>
                    <input class="form-control form-control-lg" type="text" name="phil_health" value="<?= $appointmentData->phil_health ?>" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Pag-IBIG Number</label>
                    <input class="form-control form-control-lg" type="text" name="pag_ibig" value="<?= $appointmentData->pag_ibig ?>" required />
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
  $("select[name='assignment_station']").on("change", function() {
    if ($(this).val() === "Specific Unit/Section") {
      $("input[name='other']").removeClass("d-none")
      $("input[name='other']").prop("required", true)
    } else {
      $("input[name='other']").addClass("d-none")
      $("input[name='other']").prop("required", false)
    }
  })
  $("#form-edit-appointment-data").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=update_appointment_data" ?>`,
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