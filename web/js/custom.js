$(window)
  .scroll(function() {
    if ($(".doc-nav-block").length > 0) {
      var scrollDistance = $(window).scrollTop();

      // Show/hide menu on scroll

      if (scrollDistance >= 50) {
        if ($(".doc-nav-block").css("top") != "10px") {
          $(".doc-nav-block").animate({ top: "10" }, "fast"); //.css("top",'10px');
        }
      } else {
        if ($(".doc-nav-block").css("top") != "110px") {
          $(".doc-nav-block").animate({ top: "110" }, "fast"); //.css("top",'110px');
        }
      }

      // Assign active class to nav links while scolling
      $(".doc-block").each(function(i) {
        if ($(this).position().top <= scrollDistance) {
          $(".navigation a.active").removeClass("active");
          var nav_class = "link-" + $(this).attr("id");
          $(".navigation a." + nav_class).addClass("active");
        }
      });
    }
  })
  .scroll();

$(document).ready(function () {
  $('#wiki-button').click(function () {
    
    $.ajax({
      url: window.location.origin + '/site/wiki-redirect',
      success: function (response, textStatus, jqXHR) {
        window.open(response, '_blank');
      },
      error: function(request, status, error) {
        alert(request.responseText);
      }
    });
  });
  //show modal slide templates on modal edit page
  $("#create-slide-open").click(function() {
    $("#modal-action-slide-block").toggle();
  });
  //show remove image for input type="file"
  $("#modalslide-imagefile").on("change", function() {
    $("#file-input-reset").show();
  });
  $("#dynamictemplate-imagefile").on("change", function() {
    $("#file-input-reset").show();
  });
  $(".icons-box .icon-item").click(function() {
    $(this)
      .parent()
      .children()
      .removeClass("active");
    $(this).addClass("active");
    var logo_name = $(this).data("logo-name");
    $("#category-logo_name").val(logo_name);
    $(".category-icon-saved .icon-saved-block .material-icons").html(logo_name);
  });

  //add upload image feature to all textarea
  var textareas = [
    "#templateoneform-description",
    "#dynamictemplate-description",
    "#modalslide-description",
    "#templateoneform-description",
    "#modalslide-content",
    "#dynamictemplate-content",
    "#modalslide-text"
  ];

  textareas.forEach(function(element) {
    if ($(element).length) {
      ClassicEditor.create(document.querySelector(element), {
        ckfinder: {
          uploadUrl: window.location.origin + "/upload"
        },
        image: {
          toolbar: ["ImageResize"]
        }
      }).catch(error => {
        console.error(error);
      });
    }
  });

  // add style for all checkboxes
  var checkboxes = [
    "#modalslide-show",
    "#dynamictemplate-product_tour_link_show",
    "#modalslide-product_tour_link_show",
    "#dynamictemplate-next_modal_link_show",
    "#modalslide-next_modal_link_show",
    "#dynamictemplate-show_description",
    "#modalslide-show_description",
    "#dynamictemplate-show_button",
    "#modalslide-show_button",
    "#modal-show_logo",
    "#modal-feature_announ",
    "#producttour-show",
    "#modal-show",
    "#modal-auto_show",
    "#dynamictemplate-button_action_next",
    "#modalslide-button_action_next"
  ];

  // https://www.jqueryscript.net/form/Touch-Enabled-Skinnable-Toggle-Switches-with-jQuery-asSwitch.html

  checkboxes.forEach(function(element) {
    if ($(element).length) {
      $(element).asSwitch({});
    }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $(".category-color-box .category-color-item").click(function() {
    $(this)
      .parent()
      .children()
      .removeClass("active");
    $(this).addClass("active");
    var theme_name = $(this).data("theme-name");
    $("#category-theme").val(theme_name);
    $(".category-icon-saved .icon-saved-block").removeClass();
    $(".category-icon-saved div")
      .addClass("icon-saved-block")
      .addClass(theme_name);
  });

  $(".icons-box .icon-item").click(function() {
    $(this)
      .parent()
      .children()
      .removeClass("active");
    $(this).addClass("active");
    var logo_name = $(this).data("logo-name");
    $("#category-logo_name").val(logo_name);
    $(".category-icon-saved .icon-saved-block .material-icons").html(logo_name);
  });

  $("#modal-list-table").DataTable();
  $("#product-tour-list-table").DataTable();
  
  fontLoad("Material+Icons");

  /* Show/hide logic for auto show start date */
  $(".field-modal-auto_show .asSwitch").click(function() {
    showStartDateField();
  });
  var switchOn = $(".field-modal-auto_show .asSwitch").hasClass("asSwitch_on");
  if (switchOn) {
    $('.field-modal-auto_show_start_date').show();
  }

  /* Show/hide logic for product tour link */
  var switchOnProductLink = $(".field-dynamictemplate-product_tour_link_show .asSwitch").hasClass("asSwitch_on");
  if (switchOnProductLink) {
    $('.field-dynamictemplate-product_tour_link_text').show();
  }
  
  $(".field-dynamictemplate-product_tour_link_show .asSwitch").click(function() {
    showProductLinkText();
  });

  /* Show/hide logic for modal window link */
  var switchOnProductLink = $(".field-dynamictemplate-next_modal_link_show .asSwitch").hasClass("asSwitch_on");
  if (switchOnProductLink) {
    $('.field-dynamictemplate-next_modal_link_text').show();
  }
  
  $(".field-dynamictemplate-next_modal_link_show .asSwitch").click(function() {
    showModalLinkText();
  });
  
});

function showProductLinkText() {
  var switchOn = !$(".field-dynamictemplate-product_tour_link_show .asSwitch").hasClass("asSwitch_on");
  if (switchOn) {
    $('.field-dynamictemplate-product_tour_link_text').fadeIn("slow");
  } else {
    $('.field-dynamictemplate-product_tour_link_text').fadeOut("slow");
  }
}

function showModalLinkText() {
  var switchOn = !$(".field-dynamictemplate-next_modal_link_show .asSwitch").hasClass("asSwitch_on");
  if (switchOn) {
    $('.field-dynamictemplate-next_modal_link_text').fadeIn("slow");
  } else {
    $('.field-dynamictemplate-next_modal_link_text').fadeOut("slow");
  }
}

function showStartDateField() {
  var switchOn = !$(".field-modal-auto_show .asSwitch").hasClass("asSwitch_on");
  if (switchOn) {
    $('.field-modal-auto_show_start_date').fadeIn("slow");
  } else {
    $('.field-modal-auto_show_start_date').fadeOut("slow");
  }
}
/**
 * Preview modal window in create and edit page
 * @param {number} modalId - modal id
 */
function previewModal(modalId) {
  window.customHelpApi = window.location.origin;
  CustomModalObject = new CustomModal({ modalId: modalId });
  CustomModalObject.init();
  CustomModalObject.templateData.modal.theme_color = $(
    "input[name='modal-theme_color-source']"
  ).val();
  CustomModalObject.templateData.modal.secondary_theme_color = $(
    "input[name='modal-secondary_theme_color-source']"
  ).val();
  fontLoad("Material+Icons");
  CustomModalObject.showModal(true);
}

/**
 *
 * @param {array} modal_data - data for template like theme_color, show_logo etc.
 */
function previewSlide(modal_data) {
  var values = {};
  $.each($("#slide-form").serializeArray(), function(i, field) {
    $("#slide-form")
      .find("input[name='" + field.name + "']")
      .attr("value", field.value);
    var fieldName = field.name.substring(
      field.name.lastIndexOf("[") + 1,
      field.name.lastIndexOf("]")
    );

    values[fieldName] =
      fieldName == "type" && field.value.length == 0 ? 0 : field.value;
  });
  switch (true) {
    case $("#dynamictemplate-template").length > 0:
      values.template = $("#dynamictemplate-template").val();
      break;
    case $("#modalslide-template").length > 0:
      values.template = $("#modalslide-template").val();
      break;

    default:
      values.template = "templateOne";
      break;
  }

  if ($(".ck-content").length > 0) {
    values.description = $(".ck-content").html();
    values.content = $(".ck-content").html();
  }

  if (
    $("#modalslide-file").length > 0 &&
    $("#modalslide-file").val().length > 0
  ) {
    values.file = $("#base-url").val() + "/" + $("#modalslide-file").val();
  }
  if (
    $("#modalslide-imagefile").length > 0 &&
    $("#modalslide-imagefile").val().length > 0
  ) {
    values.file = $("#base-url").val() + "/" + $("#modalslide-imagefile").val();
  }
  if (
    $("#dynamictemplate-imagefile").length > 0 &&
    $("#dynamictemplate-imagefile").val().length > 0
  ) {
    values.file =
      $("#base-url").val() + "/" + $("#dynamictemplate-imagefile").val();
  }

  if (
    $("#modalslide-youtube_link").length > 0 &&
    $("#modalslide-youtube_link").val().length > 0
  ) {
    values.youtube_link = youtube_parser($("#modalslide-youtube_link").val());
  }
  if (
    $("#dynamictemplate-youtube_link").length > 0 &&
    $("#dynamictemplate-youtube_link").val().length > 0
  ) {
    values.youtube_link = youtube_parser(
      $("#dynamictemplate-youtube_link").val()
    );
  }

  if ($("#modalslide-product_tour_link_show").length > 0) {
    values.product_tour_link_show = $("#modalslide-product_tour_link_show")
      .parent()
      .hasClass("asSwitch_on");
  }

  if ($("#modalslide-show_button").length > 0) {
    values.show_button = $("#modalslide-show_button")
      .parent()
      .hasClass("asSwitch_on");
  }
  if ($("#dynamictemplate-product_tour_link_show").length > 0) {
    values.product_tour_link_show = $("#dynamictemplate-product_tour_link_show")
      .parent()
      .hasClass("asSwitch_on");
  }

  values.product_tour_link_show = strToBool(values.product_tour_link_show);
  values.show = "1";
  switch (values.type) {
    case "0":
    default:
      previewData = {
        slides: [values],
        modal: modal_data
      };
      break;

    case "1":
      previewData = {
        startSlide: values,
        slides: [],
        modal: modal_data
      };
      break;
    case "2":
      previewData = {
        endSlide: values,
        slides: [],
        modal: modal_data
      };
      break;
  }

  console.log("values", values, previewData);
  window.customHelpApi = window.location.origin;
  CustomModalObject = new CustomModal({
    modalId: 0,
    templateData: previewData
  });
  CustomModalObject.addDefaultHtml();
  CustomModalObject.showModal(true);

  previewFile();
  fontLoad("Material+Icons");
  fontLoad("Montserrat:400,700,800&display=swap");
}

/**
 * Function for preview file choosen in input type="file"
 */
function previewFile() {
  var preview;
  if ($(".owl-item.active").length > 0) {
    preview = $(".owl-item.active").find("img");
  } else {
    preview = $(".nd-content .first-slide-logo").find("img");
  }
  var file;
  if ($(".field-modalslide-imagefile").length > 0) {
    file = document.querySelector(
      ".field-modalslide-imagefile input[type=file]"
    ).files[0];
  } else if ($("#modalslide-imagefile").length > 0) {
    file = document.querySelector("#modalslide-imagefile input[type=file]")
      .files[0];
  } else if ($(".field-modalslide-imagefile input[type=file]").length > 0) {
    file = document.querySelector(
      ".field-dynamictemplate-imagefile input[type=file]"
    ).files[0];
  }

  var reader = new FileReader();

  reader.onloadend = function() {
    preview.attr("src", reader.result);
  };

  if (file) {
    reader.readAsDataURL(file);
  }
}

/**
 * Add logic for drug and drop categories on category page
 */
function sortCategory() {
  var categoryOrder = [];
  $(".sortable li")
    .children()
    .each(function(i) {
      categoryOrder.push(
        $(this)
          .parent()
          .find(".category")
          .data("categoryId")
      );
    });
  var param = $("meta[name=csrf-param]").attr("content");
  var token = $("meta[name=csrf-token]").attr("content");

  var data = {};
  data[param] = token;
  data.categories = categoryOrder;

  $.ajax({
    url: "/category/sort",
    type: "POST",
    data: data,
    success: function(response, textStatus, jqXHR) {
      console.log("Save category ordering", response);
    },
    error: function(request, status, error) {
      alert(request.responseText);
    }
  });
}


/**
 * Add logic for drug and drop tutorials on category tutorials page
 */
function sortCategoryTutorials() {
  var tutorialsOrder = [];
  $(".sortable li")
    .children('.category-tutorial')
    .each(function(i) {
      tutorialsOrder.push({
        id: $(this)
        .parent()
        .find(".category-tutorial")
          .data("tutorialId"),
        type: $(this)
        .parent()
        .find(".category-tutorial")
          .data("tutorialType")
      });
    });
  var param = $("meta[name=csrf-param]").attr("content");
  var token = $("meta[name=csrf-token]").attr("content");
console.log('tutorialsOrder :>> ', tutorialsOrder);
  var data = {};
  data[param] = token;
  data.tutorials = tutorialsOrder;

  $.ajax({
    url: "/category/sort-tutorials",
    type: "POST",
    data: data,
    success: function(response, textStatus, jqXHR) {
      console.log("Save category tutorials ordering", response);
    },
    error: function(request, status, error) {
      alert(request.responseText);
    }
  });
}
/**
 * Add logic for drug and drop slides on Modal edit page
 */
function sortSlides() {
  var slidesOrder = [];
  $(".sortable li").each(function(i) {
    slidesOrder.push(
      $(this)
        .find(".slide")
        .data("slideId")
    );
  });

  var param = $("meta[name=csrf-param]").attr("content");
  var token = $("meta[name=csrf-token]").attr("content");

  var modalId = $(".sortable").data("modalId");
  var data = {};
  data[param] = token;
  data.slides = slidesOrder;
  data.modal_id = modalId;

  $.ajax({
    url: "/modal-slide/sort",
    type: "POST",
    data: data,
    success: function(response, textStatus, jqXHR) {
      console.log("Save slides ordering", response);
    },
    error: function(request, status, error) {
      alert(request.responseText);
    }
  });
}

/**
 * Function for clear input type="file" on slide create/edit page
 */
function clearInputFile() {
  var f;
  if ($("#modalslide-imagefile").length > 0) {
    f = document.getElementById("modalslide-imagefile");
  } else if ($("#dynamictemplate-imagefile").length > 0) {
    f = document.getElementById("dynamictemplate-imagefile");
  }

  if (f.value) {
    $("#file-input-reset").hide();
    try {
      f.value = ""; //for IE11, latest Chrome/Firefox/Opera...
    } catch (err) {}
    if (f.value) {
      //for IE5 ~ IE10
      var form = document.createElement("form"),
        ref = f.nextSibling;
      form.appendChild(f);
      form.reset();
      ref.parentNode.insertBefore(f, ref);
    }
  }
}
function deleteInputFileValue() {
  $("#modalslide-file").val("");
  $(".img-thumbnail").remove();
  $("#delete-image").remove();
}
/**
 * Hook for show product tour event in preview mode
 */
function showProductTour() {
  alert("It is Preview Mode. This link works only on Checker side!");
}

/**
 * Parse youtube url and return video id for preview mode
 * @param {string} url - youtube url for parse
 */
function youtube_parser(url) {
  var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
  var match = url.match(regExp);
  return match && match[7].length == 11 ? match[7] : false;
}

/*
 * Converts a string to a bool.
 *
 * This conversion will:
 *
 *  - match 'true', 'on', or '1' as true.
 *  - ignore all white-space padding
 *  - ignore capitalization (case).
 *
 * '  tRue  ','ON', and '1   ' will all evaluate as true.
 *
 */
function strToBool(s) {
  // will match one and only one of the string 'true','1', or 'on' rerardless
  // of capitalization and regardless off surrounding white-space.
  //
  regex = /^\s*(true|1|on)\s*$/i;

  return regex.test(s);
}
