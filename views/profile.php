<?php
require("../backend/nodes.php");
$title = "Profile";
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
            <button type="button" class="btn btn-secondary float-end" onclick="window.history.back()">
              Go Back
            </button>
          </div>
          <div class="row">
            <div class="col-md-4 col-xl-3">
              <div class="card mb-3">
                <?php
                $userData = $helpers->select_all_individual("users", "id=$_GET[id]");
                $promotionRec = $helpers->select_all_individual("promotions", "user_id=$_GET[id] ORDER BY id DESC LIMIT 1");
                ?>
                <div class="card-body text-center">
                  <img src="<?= $helpers->get_avatar_link($userData->id) ?>" class="img-fluid rounded-circle mb-2" style="width: 128px; height: 128px;" />
                  <h5 class="card-title mb-0">
                    <?= $helpers->get_full_name($userData->id) ?>
                  </h5>
                  <div class="text-muted mb-2">
                    <?= $promotionRec->rank ?>
                  </div>

                  <?php if ($userData->role != "admin"):
                  ?>
                    <div>
                      <button type="button" class="btn btn-primary btn-sm" id="btnMakeAdmin" data-user-id="<?= $userData->id ?>">
                        Make Admin
                      </button>
                    </div>
                  <?php endif;
                  ?>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                  <h5 class="h6 card-title">About</h5>
                  <ul class="list-unstyled mb-0">
                    <li class="mb-1">
                      <span data-feather="home" class="feather-sm me-1"></span>
                      <?= $userData->address ?>
                    </li>
                    <li class="mb-1">
                      <span data-feather="at-sign" class="feather-sm me-1"></span>
                      <a href="mailto:<?= $userData->email ?>">
                        <?= $userData->email ?>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-8 col-xl-9">
              <ul class="nav nav-tabs nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="pills-training-tab" data-bs-toggle="tab" href="#training" role="tab" aria-controls="pills-training" aria-selected="true">
                    Trainings
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-eligibility-tab" data-bs-toggle="tab" href="#eligibility" role="tab" aria-controls="pills-eligibility" aria-selected="false">
                    Eligibility
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-promotion-tab" data-bs-toggle="tab" href="#promotion" role="tab" aria-controls="pills-promotion" aria-selected="false">
                    Promotion Records
                  </a>
                </li>
              </ul>
              <div class="card">
                <div class="card-body">
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="training" role="tabpanel" aria-labelledby="pills-training-tab">
                      <div class="w-100 d-flex justify-content-end">
                        <a href="<?= SERVER_NAME . "/views/add-training?id=$userData->id" ?>" class="btn btn-primary">
                          Add Training
                        </a>
                      </div>
                      <hr class="mx-0" />
                      <?php
                      $trainings = $helpers->select_all_with_params("trainings", "user_id='$userData->id'");
                      if ($trainings) :
                      ?>
                        <div class="row">
                          <?php foreach ($trainings as $training): ?>
                            <div class="col-md-6 mt-2 px-4">
                              <div class="text-muted mb-2">
                                <?= $training->course_title ?>
                                <a href="<?= SERVER_NAME . "/views/edit-training?id=$userData->id" ?>">
                                  <span data-feather="edit" class="me-4 float-end"></span>
                                </a>
                              </div>
                              <ul>
                                <li>Authority: <?= $training->authority ?></li>
                                <li>Start: <?= date("F d, Y", strtotime($training->start_date)) ?></li>
                                <li>End: <?= date("F d, Y", strtotime($training->end_date)) ?></li>
                              </ul>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <h6>No Training Yet</h6>
                      <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="eligibility" role="tabpanel" aria-labelledby="pills-eligibility-tab">
                      <div class="w-100 d-flex justify-content-end">
                        <a href="<?= SERVER_NAME . "/views/add-eligibility?id=$userData->id" ?>" class="btn btn-primary">
                          Add Eligibility
                        </a>
                      </div>
                      <hr class="mx-0" />
                      <?php
                      $eligibilities = $helpers->select_all_with_params("eligibility", "user_id='$userData->id'");
                      if ($eligibilities) :
                      ?>
                        <div class="row">
                          <?php foreach ($eligibilities as $eligibility): ?>
                            <div class="col-md-6 mt-2 px-4">
                              <div class="text-muted mb-2">
                                <?= $eligibility->title ?>
                                <a href="<?= SERVER_NAME . "/views/edit-eligibility?id=$eligibility->id" ?>">
                                  <span data-feather="edit" class="me-4 float-end"></span>
                                </a>
                              </div>
                              <ul>
                                <li>Rating: <?= $eligibility->rating ?></li>
                                <li>Place: <?= $eligibility->place ?></li>
                                <li>Date: <?= date("F d, Y", strtotime($eligibility->date)) ?></li>
                              </ul>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <h6>No Eligibility Records</h6>
                      <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="promotion" role="tabpanel" aria-labelledby="pills-promotion-tab">
                      <div class="w-100 d-flex justify-content-end">
                        <a href="<?= SERVER_NAME . "/views/add-promotion?id=$userData->id" ?>" class="btn btn-primary">
                          Add Promotion
                        </a>
                      </div>
                      <hr class="mx-0" />
                      <?php
                      $promotions = $helpers->select_all_with_params("promotions", "user_id='$userData->id' ORDER BY id DESC");
                      if ($promotions) :
                      ?>
                        <div class="row">
                          <?php foreach ($promotions as $promotion): ?>
                            <div class="col-md-6 mt-2 px-4">
                              <div class="text-muted mb-2">
                                <?= $promotion->rank ?>
                                <a href="<?= SERVER_NAME . "/views/edit-promotion?id=$promotion->id" ?>">
                                  <span data-feather="edit" class="me-4 float-end"></span>
                                </a>
                              </div>
                              <ul>
                                <li>Authority: <?= $promotion->authority ?></li>
                                <li>Effective Date: <?= date("F d, Y", strtotime($promotion->effective_date)) ?></li>
                              </ul>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <h6>No Promotion Records</h6>
                      <?php endif; ?>
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
</body>
<?php require("../views/components/script.php"); ?>

<script>
  let lastTab = sessionStorage.getItem('profileTab');
  if (lastTab) {
    let triggerEl = document.querySelector(`a[href="${lastTab}"]`)
    let tab = new bootstrap.Tab(triggerEl)
    tab.show()
  }

  $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
    sessionStorage.setItem('profileTab', $(this).attr('href'));
  });

  $("#btnMakeAdmin").on("click", function() {
    let fd = new FormData()
    fd.append("user_id", $(this).attr("data-user-id"))

    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=make_user_admin" ?>`,
      type: "POST",
      data: fd,
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
        }).then((d) => showBtnLoading($("#btnLogin"), false));
      },
    });
    console.log()
  })
</script>

</html>