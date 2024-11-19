<?php
require("../backend/nodes.php");
$title = "Dashboard";
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

          <div class="row">
            <div class="col-12 col-lg-12 col-xxl-9 d-flex">
              <div class="card flex-fill">
                <div class="card-header">

                  <h5 class="card-title mb-0">Users</h5>
                </div>
                <div class="card-body">
                  <table class="table table-striped dataTable-table datatable">
                    <thead>
                      <tr>
                        <th>Avatar</th>
                        <th class="text-start">ID Number</th>
                        <th>Name</th>
                        <th>Assignment/Station</th>
                        <th>Status</th>
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

                          $appointment = $helpers->select_all_individual("appointment", "user_id='$user->id' ORDER BY id DESC LIMIT 1");

                          $appointment_id = "---";
                          $assignment = "---";
                          $status = "---";

                          $badgeColor = "";

                          if ($appointment) {
                            $appointment_id = $appointment->id;
                            $assignment = $appointment->assignment_station == "Janiuay Municipal Police Station" ? $appointment->assignment_station : "Specific Unit/Section: $appointment->assignment_station";
                            $status = $appointment->status;

                            switch ($status) {
                              case "Active":
                                $badgeColor = "bg-success";
                                break;
                              case "Leave":
                                $badgeColor = "bg-info";
                                break;
                              case "Resigned":
                                $badgeColor = "bg-danger";
                                break;
                              case "Retired":
                                $badgeColor = "bg-secondary";
                                break;
                            }
                          }

                      ?>
                          <tr>
                            <td class="td-image text-center">
                              <?= $helpers->generate_modal_click_avatar($helpers->get_avatar_link($user->id), $modal_id, $img_id, $caption_id) ?>
                            </td>
                            <td class="text-start"><?= $user->id_number ?></td>
                            <td class="text-start">
                              <a href="<?= SERVER_NAME . "/views/profile?id=$user->id" ?>" class="btn-link">
                                <?= $helpers->get_full_name($user->id) ?>
                              </a>
                            </td>
                            <td><?= $assignment ?></td>
                            <td>
                              <?php if ($badgeColor): ?>
                                <span class="badge <?= $badgeColor ?>" style="font-size: 12px;">
                                  <?= $status ?>
                                </span>
                              <?php else: ?>
                                <?= $status ?>
                              <?php endif; ?>
                            </td>
                            <td class="text-center">
                              <?php if (!$appointment): ?>
                                <a href="<?= SERVER_NAME . "/views/add/appointment?id=$user->id" ?>" class="btn btn-primary">
                                  Add Appointment
                                </a>
                              <?php else: ?>
                                <button type="button" class="btn btn-warning m-1" onclick="handleUpdateStatus(`<?= $appointment_id ?>`, `<?= $status ?>`)">
                                  Update Status
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

            <div class="col-12 col-md-12 col-xxl-3 d-flex ">
              <div class="card flex-fill">
                <div class="card-header">

                  <h5 class="card-title mb-0">Calendar</h5>
                </div>
                <div class="card-body d-flex">
                  <div class="align-self-center w-100">
                    <div class="chart">
                      <div id="datetimepicker-dashboard"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <div class="modal fade" id="modalChangeStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="form-change-status" method="POST">
          <input type="text" id="appointmentID" name="appointment_id" readonly hidden>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select class="form-select mb-3" id="inputStatus" name="status" required>
                <option value="Active">Active</option>
                <option value="Leave">Leave</option>
                <option value="Resigned">Resigned</option>
                <option value="Retired">Retired</option>
              </select>
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
  function handleUpdateStatus(appointmentID, status) {
    $("#appointmentID").val(appointmentID)
    $("select[name='status']").val(status)
    $("#modalChangeStatus").modal("show")
  }

  $("#form-change-status").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=change_status" ?>`,
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

  document.addEventListener("DOMContentLoaded", function() {
    var date = new Date();
    var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
    document.getElementById("datetimepicker-dashboard").flatpickr({
      inline: true,
      prevArrow: "<span title=\"Previous month\">&laquo;</span>",
      nextArrow: "<span title=\"Next month\">&raquo;</span>",
      defaultDate: defaultDate
    });
  });
</script>

</html>