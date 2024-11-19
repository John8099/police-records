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
                $rank_position = $userData->rank_position;

                $promotionRec = $helpers->select_all_individual("promotions", "user_id=$_GET[id] ORDER BY id DESC LIMIT 1");
                if ($promotionRec) {
                  $rank_position = $promotionRec->rank;
                }
                ?>
                <div class="card-body text-center">
                  <a href="<?= SERVER_NAME . "/views/edit/user?id=$userData->id" ?>">
                    <span data-feather="edit" class="float-end"></span>
                  </a>
                  <img src="<?= $helpers->get_avatar_link($userData->id) ?>" class="img-fluid rounded-circle mb-2" style="width: 128px; height: 128px;" />
                  <h5 class="card-title mb-0">
                    <?= $helpers->get_full_name($userData->id) ?>
                  </h5>
                  <div class="text-muted mb-2">
                    <?= $rank_position ?>
                  </div>

                  <?php if ($userData->role != "admin"): ?>
                    <div>
                      <button type="button" class="btn btn-primary btn-sm" id="btnMakeAdmin" data-user-id="<?= $userData->id ?>">
                        Make Admin
                      </button>
                    </div>
                  <?php endif; ?>
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
                  <a class="nav-link active" id="pills-appointment-tab" data-bs-toggle="tab" href="#appointment" role="tab" aria-controls="pills-appointment" aria-selected="true">
                    Appointment Data
                  </a>
                </li>

                <li class="nav-item" role="presentation">
                  <a class="nav-link " id="pills-pft-tab" data-bs-toggle="tab" href="#pft" role="tab" aria-controls="pills-pft" aria-selected="true">
                    PFT
                  </a>
                </li>

                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-iper-tab" data-bs-toggle="tab" href="#iper" role="tab" aria-controls="pills-iper" aria-selected="true">
                    IPER
                  </a>
                </li>

                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-training-tab" data-bs-toggle="tab" href="#training" role="tab" aria-controls="pills-training" aria-selected="true">
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

                    <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="pills-appointment-tab">
                      <div class="w-100 d-flex justify-content-end">
                        <a href="<?= SERVER_NAME . "/views/add/appointment?id=$userData->id" ?>" class="btn btn-primary">
                          Add Appointment
                        </a>
                      </div>
                      <hr class="mx-0" />
                      <?php
                      $appointmentData = $helpers->select_all_with_params("appointment", "user_id='$userData->id'");
                      if ($appointmentData) :
                      ?>
                        <div class="row">
                          <?php foreach ($appointmentData as $appointment): ?>
                            <div class="card col-md-6 mt-2 px-4 py-2">
                              <div class="text-muted mb-2">
                                <?= date("F d, Y", strtotime($appointment->appointment_date)) ?>
                                <a href="javascript:void(0);" onclick="handleRemove(`appointment`, `id`, `<?= $appointment->id ?>`)">
                                  <span data-feather="trash-2" class="mx-2 text-danger float-end"></span>
                                </a>
                                <a href="<?= SERVER_NAME . "/views/edit/appointment?id=$userData->id&aid=$appointment->id" ?>">
                                  <span data-feather="edit" class="mx-2 float-end"></span>
                                </a>
                              </div>
                              <ul>
                                <li>Appointment Type: <?= $appointment->appointment_type ?></li>
                                <li>Assignment/Station: <?= $appointment->assignment_station ?></li>
                                <li>Tenure: <?= $appointment->tenure ?></li>
                                <li>Status: <?= $appointment->status ?></li>
                                <li>Salary Grade/Step: <?= $appointment->salary ?></li>
                                <li>Government Service Insurance System (GSIS) Number: <?= $appointment->gsis ?></li>
                                <li>PhilHealth Number: <?= $appointment->phil_health ?></li>
                                <li>Pag-IBIG Number: <?= $appointment->pag_ibig ?></li>
                              </ul>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <h6>No Appointment Data Yet</h6>
                      <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="pft" role="tabpanel" aria-labelledby="pills-pft-tab">
                      <div class="w-100 d-flex justify-content-end">
                        <a href="<?= SERVER_NAME . "/views/add/pft?id=$userData->id" ?>" class="btn btn-primary">
                          Add PFT
                        </a>
                      </div>
                      <hr class="mx-0" />
                      <?php
                      $PFTs = $helpers->select_all_with_params("pft", "user_id='$userData->id'");
                      if ($PFTs) :
                      ?>
                        <div class="row">
                          <?php foreach ($PFTs as $pft): ?>
                            <div class="card col-md-6 mt-2 px-4 py-2">
                              <div class="text-muted mb-2">
                                <?= date("F d, Y", strtotime($pft->test_date)) ?>
                                <a href="javascript:void(0);" onclick="handleRemove(`pft`, `id`, `<?= $pft->id ?>`)">
                                  <span data-feather="trash-2" class="mx-2 text-danger float-end"></span>
                                </a>
                                <a href="<?= SERVER_NAME . "/views/edit/pft?id=$pft->id" ?>">
                                  <span data-feather="edit" class="mx-2 float-end"></span>
                                </a>
                              </div>
                              <ul>
                                <li>Overall Score/Rating: <?= $pft->score ?></li>
                                <li>
                                  Individual Event Scores:
                                  <ul>
                                    <?php $event = (object)json_decode($pft->event, true); ?>
                                    <li>500 Meter Run: <?= $event->meter_run ?></li>
                                    <li>Sit-ups: <?= $event->sit_up ?></li>
                                    <li>Push-ups: <?= $event->push_up ?></li>
                                    <li>50-meter Swim (or alternative): <?= $event->swim ?></li>
                                  </ul>
                                </li>
                                <li>Body Mass Index (BMI): <?= $pft->bmi ?></li>
                                <li>Blood Pressure: <?= $pft->bp ?></li>
                                <li>Pulse Rate: <?= $pft->pulse_rate ?></li>
                              </ul>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <h6>No PFT Yet</h6>
                      <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="iper" role="tabpanel" aria-labelledby="pills-iper-tab">
                      <div class="w-100 d-flex justify-content-end">
                        <a href="<?= SERVER_NAME . "/views/add/iper?id=$userData->id" ?>" class="btn btn-primary">
                          Add IPER
                        </a>
                      </div>
                      <hr class="mx-0" />
                      <?php
                      $IPERs = $helpers->select_all_with_params("iper", "user_id='$userData->id'");
                      if ($IPERs) :
                      ?>
                        <div class="row">
                          <?php
                          foreach ($IPERs as $iper):
                            $period = explode(" - ", $iper->evaluation_period);
                            $start = date("F d, Y", strtotime($period[0]));
                            $end = date("F d, Y", strtotime($period[1]));
                          ?>
                            <div class="card col-md-6 mt-2 px-4 py-2">
                              <div class="text-muted mb-2">
                                <?= "$start - $end" ?>
                                <a href="javascript:void(0);" onclick="handleRemove(`iper`, `id`, `<?= $iper->id ?>`)">
                                  <span data-feather="trash-2" class="mx-2 text-danger float-end"></span>
                                </a>
                                <a href="<?= SERVER_NAME . "/views/edit/iper?id=$userData->id&pid=$iper->id" ?>">
                                  <span data-feather="edit" class="mx-2 float-end"></span>
                                </a>
                              </div>
                              <ul>
                                <li>
                                  Job Responsibilities:
                                  <ul>
                                    <?php
                                    $responsibilities = (object)json_decode($iper->responsibilities, true);
                                    foreach ($responsibilities as $responsibility):
                                    ?>
                                      <li><?= $responsibility ?></li>
                                    <?php endforeach; ?>
                                  </ul>
                                </li>
                                <li>
                                  Performance Ratings:
                                  <ul>
                                    <?php $performance = (object)json_decode($iper->performance_ratings, true); ?>
                                    <li>Leadership: <?= $performance->leadership ?></li>
                                    <li>Job Knowledge: <?= $performance->job_knowledge ?></li>
                                    <li>Communication: <?= $performance->communication ?></li>
                                    <li>Teamwork: <?= $performance->teamwork ?></li>
                                    <li>Integrity: <?= $performance->integrity ?></li>
                                  </ul>
                                </li>
                                <li>Strengths: <?= nl2br($iper->strengths) ?></li>
                                <li>Weaknesses: <?= nl2br($iper->weakness) ?></li>
                                <li>Areas for Improvement: <?= $iper->areas_of_improvement ?></li>
                                <li>Recommendations for Training/Development: <?= $iper->recommendations ?></li>
                                <li>Supervisor's Comments: <?= nl2br($iper->supervisor_comment) ?></li>
                                <li>Employee's Comments: <?= nl2br($iper->employee_comment) ?></li>
                              </ul>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <h6>No IPER Yet</h6>
                      <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="training" role="tabpanel" aria-labelledby="pills-training-tab">
                      <div class="w-100 d-flex justify-content-end">
                        <a href="<?= SERVER_NAME . "/views/add/training?id=$userData->id" ?>" class="btn btn-primary">
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
                            <div class="card col-md-6 mt-2 px-4 py-2">
                              <div class="text-muted mb-2">
                                <?= $training->course_title ?>
                                <a href="javascript:void(0);" onclick="handleRemove(`trainings`, `id`, `<?= $training->id ?>`)">
                                  <span data-feather="trash-2" class="mx-2 text-danger float-end"></span>
                                </a>
                                <a href="<?= SERVER_NAME . "/views/edit/training?id=$training->id" ?>">
                                  <span data-feather="edit" class="mx-2 float-end"></span>
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
                        <a href="<?= SERVER_NAME . "/views/add/eligibility?id=$userData->id" ?>" class="btn btn-primary">
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
                            <div class="card col-md-6 mt-2 px-4 py-2">
                              <div class="text-muted mb-2">
                                <?= $eligibility->title ?>
                                <a href="javascript:void(0);" onclick="handleRemove(`eligibility`, `id`, `<?= $eligibility->id ?>`)">
                                  <span data-feather="trash-2" class="mx-2 text-danger float-end"></span>
                                </a>
                                <a href="<?= SERVER_NAME . "/views/edit/eligibility?id=$eligibility->id" ?>">
                                  <span data-feather="edit" class="mx-2 float-end"></span>
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
                        <a href="<?= SERVER_NAME . "/views/add/promotion?id=$userData->id" ?>" class="btn btn-primary">
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
                            <div class="card col-md-6 mt-2 px-4 py-2">
                              <div class="text-muted mb-2">
                                <?= $promotion->rank ?>
                                <a href="javascript:void(0);" onclick="handleRemove(`promotions`, `id`, `<?= $promotion->id ?>`)">
                                  <span data-feather="trash-2" class="mx-2 text-danger float-end"></span>
                                </a>
                                <a href="<?= SERVER_NAME . "/views/edit/promotion?id=$promotion->id" ?>">
                                  <span data-feather="edit" class="mx-2 float-end"></span>
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
  function handleRemove(table, column, id) {
    const config = {
      title: "Are you sure you want to remove this item?",
      text: "You can't undo this action after successful deletion.",
      buttonText: "Delete",
      buttonColor: "#dc3545",
    };
    const postData = {
      table: table,
      column: column,
      val: id,
    }

    handleDelete(
      "<?= SERVER_NAME . "/backend/nodes?action=delete_data" ?>",
      config,
      postData
    )
  }

  let lastTab = sessionStorage.getItem('profileTab');
  if (lastTab) {
    let triggerEl = document.querySelector(`a[href="${lastTab}"]`)
    let tab = new bootstrap.Tab(triggerEl)
    tab.show()
  }

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