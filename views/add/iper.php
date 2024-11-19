<?php
require("../../backend/nodes.php");
$title = "Add Individual Performance Evaluation Report";
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
            ?>
            <div class="card-body">
              <div class="container">
                <form id="form-add-iper" method="POST">
                  <input type="text" name="id" value="<?= $userData->id ?>" hidden readonly>

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
                        <input class="form-control form-control-lg" type="date" name="start_date" required />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">To</label>
                        <input class="form-control form-control-lg" type="date" name="end_date" required />
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Job Responsibilities</label>

                    <div class="row">
                      <div class="col-12">
                        <input class="form-control form-control-lg" type="text" name="job_responsibilities[]" required />
                      </div>
                      <div class="col-12" id="jobData"></div>

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
                    <div class="row px-lg-5">
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="meterRun" class="col-form-label">Leadership</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="1" name="leadership" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="sitUps" class="col-form-label">Job Knowledge</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="1" name="job_knowledge" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="pushUps" class="col-form-label">Communication</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="1" name="communication" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="swim" class="col-form-label">Teamwork</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="1" name="teamwork" required>
                        </div>
                      </div>
                      <div class="col-md-12 row align-items-center">
                        <div class="col-2 mb-1">
                          <label for="swim" class="col-form-label">Integrity</label>
                        </div>
                        <div class="col-auto">
                          <input type="number" class="form-control" min="1" max="5" value="1" name="integrity" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Strengths</label>
                    <textarea class="form-control form-control-lg" rows="5" name="strength" required></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Weaknesses</label>
                    <textarea class="form-control form-control-lg" rows="5" name="weakness" required></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Areas for Improvement (specific actions)</label>
                    <input class="form-control form-control-lg" type="text" name="areas_of_improvement" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Recommendations for Training/Development (specific courses/training)</label>
                    <input class="form-control form-control-lg" type="text" name="recommendations" required />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Supervisor's Comments</label>
                    <textarea class="form-control form-control-lg" rows="5" name="s_comment" required></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Employee's Comments</label>
                    <textarea class="form-control form-control-lg" rows="5" name="e_comment" required></textarea>
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

  $("#form-add-iper").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=add_iper" ?>`,
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