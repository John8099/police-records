<?php
require("../../backend/nodes.php");
$title = "Edit Individual Performance Evaluation Report";
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
            $iperData = $helpers->select_all_individual("iper", "id=$_GET[pid]");

            $period = explode(" - ", $iperData->evaluation_period);

            $rank_position = $userData->rank_position;

            $promotionRec = $helpers->select_all_individual("promotions", "user_id=$userData->id ORDER BY id DESC LIMIT 1");
            if ($promotionRec) {
              $rank_position = $promotionRec->rank;
            }
            ?>
            <?php  ?>
            <div class="card-body">
              <div class="container">
                <form id="form-edit-iper" method="POST">
                  <input type="text" name="iper_id" value="<?= $iperData->id ?>" hidden readonly>

                  <div class="mb-3">
                    <label class="form-label">Employee ID/Number</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $userData->id_number ?>" readonly />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $helpers->get_full_name($userData->id) ?>" readonly />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Rank/Position</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $rank_position ?>" readonly />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Evaluation Period:</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label class="form-label">From</label>
                        <input class="form-control form-control-lg" type="date" name="start_date" value="<?= $period[0] ?>" required />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">To</label>
                        <input class="form-control form-control-lg" type="date" name="end_date" value="<?= $period[1] ?>" required />
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Job Responsibilities</label>

                    <div class="row">
                      <?php $responsibilities = json_decode($iperData->responsibilities, true); ?>
                      <div class="col-12">
                        <input class="form-control form-control-lg" type="text" value="<?= $responsibilities[0] ?>" name="job_responsibilities[]" required />
                      </div>
                      <div class="col-12" id="jobData">
                        <?php
                        for ($i = 1; $i < count($responsibilities); $i++):
                        ?>
                          <div class="row mt-2">
                            <div class="col-11">
                              <input class="form-control form-control-lg" type="text" value="<?= $responsibilities[$i] ?>" name="job_responsibilities[]" required />
                            </div>
                            <div class="col-1">
                              <button type="button" class="btn btn-danger" onclick='handleRemove($(this))'>
                                <span>X</span>
                              </button>
                            </div>
                          </div>
                        <?php endfor; ?>
                      </div>

                    </div>
                    <div class="row justify-content-center">
                      <div class="col-6 mt-2">
                        <div class="d-grid gap-2">
                          <button type="button" class="btn btn-success" id="btnAddResponsibilities">
                            <i data-feather="plus"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Performance Ratings:</label>
                    <?php $performance = (object)json_decode($iperData->performance_ratings, true); ?>
                    <div class="row px-lg-5">
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="meterRun" class="col-form-label">Leadership</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="<?= $performance->leadership ?>" name="leadership" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="sitUps" class="col-form-label">Job Knowledge</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="<?= $performance->job_knowledge ?>" name="job_knowledge" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="pushUps" class="col-form-label">Communication</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="<?= $performance->communication ?>" name="communication" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="swim" class="col-form-label">Teamwork</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="<?= $performance->teamwork ?>" name="teamwork" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="swim" class="col-form-label">Integrity</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="<?= $performance->integrity ?>" name="integrity" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Strengths</label>
                    <textarea class="form-control form-control-lg" rows="5" name="strength" required><?= nl2br($iperData->strengths) ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Weaknesses</label>
                    <textarea class="form-control form-control-lg" rows="5" name="weakness" required><?= nl2br($iperData->weakness) ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Areas for Improvement (specific actions)</label>
                    <input class="form-control form-control-lg" type="text" name="areas_of_improvement" value="<?= $iperData->areas_of_improvement ?>" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Recommendations for Training/Development (specific courses/training)</label>
                    <input class="form-control form-control-lg" type="text" name="recommendations" value="<?= $iperData->recommendations ?>" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Supervisor's Comments</label>
                    <textarea class="form-control form-control-lg" rows="5" name="s_comment" required><?= nl2br($iperData->supervisor_comment) ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Employee's Comments</label>
                    <textarea class="form-control form-control-lg" rows="5" name="e_comment" required><?= nl2br($iperData->employee_comment) ?></textarea>
                  </div>

                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-lg btn-primary">
                      Update
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
  $("#btnAddResponsibilities").on("click", function() {
    const html = `
    <div class="row mt-2">
      <div class="col-11">
        <input class="form-control form-control-lg" type="text" name="job_responsibilities[]" required />
      </div>
      <div class="col-1">
        <button type="button" class="btn btn-danger" onclick='handleRemove($(this))'>
          <span>X</span>
        </button>
      </div>
    </div>
    `;
    $("#jobData").append(html);
  })

  function handleRemove(el) {
    $(el.parent().parent()).remove()
  }

  $("#form-edit-iper").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=update_iper" ?>`,
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