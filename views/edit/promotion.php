<?php
require("../../backend/nodes.php");
$title = "Add Training";
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
            <?php $promotion = $helpers->select_all_individual("promotions", "id=$_GET[id]"); ?>
            <div class="card-body">
              <div class="container">
                <form id="form-edit-promotion" method="POST">
                  <input type="text" name="id" value="<?= $promotion->id ?>" hidden readonly>
                  <div class="mb-3">
                    <label class="form-label">Rank/Position</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $promotion->rank ?>" name="rank" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Authority</label>
                    <input class="form-control form-control-lg" type="text" value="<?= $promotion->authority ?>" name="authority" required />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Effective Date</label>
                    <input class="form-control form-control-lg" type="date" value="<?= $promotion->effective_date ?>" name="effective_date" required />
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
  $("#form-edit-promotion").on("submit", function(e) {
    e.preventDefault();
    swal.showLoading()
    $.ajax({
      url: `<?= SERVER_NAME . "/backend/nodes?action=edit_promotion" ?>`,
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