

$( document ).ready(function() {
  "use strict";

    // SIDE MENU ACTIVE AFTER PAGE RELOAD START
      $(document).ready(function () {
        jQuery(function ($) {
          var path = window.location.href;
        // because the 'href' property of the DOM element is the absolute path
         $(".navItem").each(function () {
          if (this.href === path) {
           $(this).addClass("active");
         }
       });
       });
      });
      // SIDE MENU ACTIVE AFTER PAGE RELOAD END


    // UPLOAD AVATAR START (PROFILE PAGE)
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#imagePreview').css('background-image', 'url('+e.target.result +')');
          $('#imagePreview').hide();
          $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").change(function() {
      readURL(this);
    });
    // UPLOAD AVATAR END (PROFILE PAGE)

    // CUSTOM SELECT START
    $(function () {
      $(".ddl-select").each(function () {
        $(this).hide();
        var $select = $(this);
        var _id = $(this).attr("id");
        var wrapper = document.createElement("div");
        wrapper.setAttribute("class", "ddl ddl_" + _id);

        var input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("class", "ddl-input");
        input.setAttribute("id", "ddl_" + _id);
        input.setAttribute("readonly", "readonly");
        input.setAttribute(
          "placeholder",
          $(this)[0].options[$(this)[0].selectedIndex].innerText
          );

        $(this).before(wrapper);
        var $ddl = $(".ddl_" + _id);
        $ddl.append(input);
        $ddl.append("<div class='ddl-options ddl-options-" + _id + "'></div>");
        var $ddl_input = $("#ddl_" + _id);
        var $ops_list = $(".ddl-options-" + _id);
        var $ops = $(this)[0].options;
        for (var i = 0; i < $ops.length; i++) {
          $ops_list.append(
            "<div data-value='" +
            $ops[i].value +
            "'>" +
            $ops[i].innerText +
            "</div>"
            );
        }
        $ddl_input.click(function () {
          $ddl.toggleClass("active");
        });
        $ddl_input.blur(function () {
          $ddl.removeClass("active");
        });
        $ops_list.find("div").click(function () {
          $select.val($(this).data("value")).trigger("change");
          $ddl_input.val($(this).text());
          $ddl.removeClass("active");
        });
      });
    });
    // CUSTOM SELECT END

    /// OTP INPUTS START
    $('.digit-group').find('input').each(function() {
      $(this).attr('maxlength', 1);
      $(this).on('keyup', function(e) {
        var parent = $($(this).parent());

        if(e.keyCode === 8 || e.keyCode === 37) {
          var prev = parent.find('input#' + $(this).data('previous'));

          if(prev.length) {
            $(prev).select();
          }
        } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
          var next = parent.find('input#' + $(this).data('next'));

          if(next.length) {
            $(next).select();
          } else {
            if(parent.data('autosubmit')) {
              parent.submit();
            }
          }
        }
      });
    });
    /// OTP INPUTS END


    // SEARCH BAR HEADER START
    $(".searchIcon").click(function(){
      $(".searchGroup").toggleClass("active");
    });
    // SEARCH BAR HEADER END

    // SIDE TOGGLE START
    $(".sideToggle").click(function(){
      $(".aside").toggleClass("active");
      $(".mainContent").toggleClass("active");
    });
    // SIDE TOGGLE END

    // CHAT TOGGLE START
    $(".memToggle").click(function(){
      $(".chatList").toggleClass("active");
    });
    // CHAT TOGGLE START

});




// document.getElementById('randomizeData').addEventListener('click', function() {
//   config.data.datasets.forEach(function(dataset) {
//     dataset.data = dataset.data.map(function() {
//       return randomScalingFactor();
//     });

//   });

//   window.myLine.update();
// });

// CHART JS END




