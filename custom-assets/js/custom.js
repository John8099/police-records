window.handleDelete = function (
  backendUrl,
  config = {
    title: "Are you sure you want to remove this item?",
    text: "You can't undo this action after successful deletion.",
    buttonText: "Delete",
    buttonColor: "#dc3545",
  },
  postData = {
    table: "",
    column: "",
    val: "",
  }
) {
  swal
    .fire({
      title: config.title,
      text: config.text,
      icon: "warning",
      confirmButtonText: config.buttonText,
      confirmButtonColor: config.buttonColor,
      showCancelButton: true,
      showLoaderOnConfirm: true,
      backdrop: true,
      preConfirm: async (value) => {
        const res = await $.ajax({
          url: backendUrl,
          data: postData,
          type: "POST",
          dataType: "JSON",
          success: function (resp) {
            if (!resp.success) {
              return Swal.showValidationMessage(`Error: ${resp.message}`);
            }
          },
        });

        return res;
      },
      allowOutsideClick: () => !Swal.isLoading(),
    })
    .then((d) => {
      if (d.isConfirmed) {
        swal
          .fire({
            title: !d.value.success ? "Error!" : "Success",
            html: !d.value.success
              ? d.value.message
              : "Item successfully deleted",
            icon: !d.value.success ? "error" : "success",
          })
          .then(() => (d.value.success ? window.location.reload() : undefined));
      }
    });
};

window.handleDeleteNoConfirm = function (
  backendUrl,
  postData = {
    table: "",
    column: "",
    val: "",
  }
) {
  $.post(backendUrl, postData, (data, status) => {
    const resp = JSON.parse(data);
    if (!resp.success) {
      swal.fire({
        title: "Error!",
        html: resp.message,
        icon: "error",
      });
    } else {
      window.location.reload();
    }
  }).fail(function (e) {
    swal.fire({
      title: "Error!",
      html: e.statusText,
      icon: "error",
    });
  });
};

window.handleOpenModalImg = (
  el,
  modalId,
  modalImgId,
  captionId,
  src = null
) => {
  if (!src) {
    $(`#${modalImgId}`).attr("src", el[0].src);
    $(`#${captionId}`).html(el[0].alt);
  } else {
    const chunkedSrc = src.split("/");
    const fileName = chunkedSrc[chunkedSrc.length - 1];

    $(`#${modalImgId}`).attr("src", src);
    $(`#${captionId}`).html(fileName);
  }

  $("html").css({
    overflow: "hidden",
  });
  $(`#${modalId}`).show();
};

window.handleCloseModalImg = (modalId, modalImgId, captionId) => {
  $(`#${modalId}`).fadeOut("slow", function () {
    $(`#${modalImgId}`).attr("src", "");
    $(`#${captionId}`).html("");
    $("html").css({
      overflow: "visible",
    });
  });
};

window.handleChangeImage = (e, imageId, backendUrl, action, user_id) => {
  swal.showLoading();
  let formData = new FormData();
  formData.append("id", user_id);

  if (action == "upload") {
    formData.append("file", $(e).get(0).files[0]);
    formData.append("set_image_null", false);
    formData.append("action", action);
  } else if ("remove") {
    formData.append("set_image_null", true);
    formData.append("action", action);
  }

  $.ajax({
    url: `${backendUrl}?action=save_profile_image`,
    type: "POST",
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      const resp = $.parseJSON(data);
      if (resp.success) {
        $(`#${imageId}`).attr("src", resp.image_url);
        swal.close();
      }
    },
    error: function (data) {
      swal.fire({
        title: "Oops...",
        html: "Something went wrong.",
        icon: "error",
      });
    },
  });
};

window.handleResetImgUpload = (
  e,
  imageId,
  imgUpload,
  inputSetImageNull,
  defaultImgUrl
) => {
  swal.showLoading();
  $(`#${imgUpload}`).val("");
  $(`#${imageId}`).attr("src", defaultImgUrl);
  $(`#${inputSetImageNull}`).val("yes");

  $(`#${imgUpload}`).parent().addClass("inline-block").removeClass("d-none");
  $(e).addClass("d-none").removeClass("inline-block");
  swal.close();
};

$("[required]")
  .parent()
  .each(function () {
    const asterisk = ` <span class="text-danger">*</span>`;
    $(this).closest(".form-group").find("label").append(asterisk);
  });

window.showBtnLoading = (buttonEl, enableLoading = true) => {
  const loadingEl = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>`;

  if (enableLoading) {
    buttonEl.addClass("disabled");
    buttonEl.prepend(loadingEl);
    $(buttonEl.children()[1]).addClass("d-none");
  } else {
    buttonEl.removeClass("disabled");
    $(buttonEl.children()[1]).addClass("d-none");
    $(buttonEl.children()[0]).remove();
  }
};

window.alert = (title, message, icon, callBack) => {
  swal
    .fire({
      title: title,
      html: message,
      icon: icon,
    })
    .then(() => (callBack ? callBack() : undefined));
};

window.showPlacement = (el) => {
  el.html(`<div class="loading">
              <p class="card-text placeholder-glow">
                <span class="placeholder col-7 placeholder-xs"></span>
                <span class="placeholder col-4 placeholder-xs"></span>
                <span class="placeholder col-4 placeholder-xs"></span>
                <span class="placeholder col-2 placeholder-xs"></span>
              </p>
            </div>`);
};

window.showToast = (message, color = "danger") => {
  let colorHex = "";

  switch (color) {
    case "danger":
      colorHex = "#C60C30";
      break;
    case "primary":
      colorHex = "#02aff3";
      break;
    case "success":
      colorHex = "#198754";
      break;
    default:
      colorHex = "#C60C30";
      break;
  }

  Toastify({
    text: message,
    duration: 3000,
    close: true,
    gravity: "top",
    position: "center",
    backgroundColor: colorHex,
  }).showToast();
};
