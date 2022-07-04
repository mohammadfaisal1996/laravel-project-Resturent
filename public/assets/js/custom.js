(function () {
    "use strict";


    $(".change-status input[type=\"checkbox\"]").on("click",function (){
        let val = $(this).data("val");
        let userId = $(this).data("userid");
        let status = val == 0 ? 1 : 0;
        let checkBox = $(this);
        $.ajax({
            type: "POST",
            url:"https://goldenmealpro.digisolapps.com/golden_meal_backend/public/api/users/app/change_status",
            data:{userStatus: status, userId: userId}, // serializes the form's elements.
            success: function(response)
            {
                if(response.status == 1){
                    if(status == 1)
                        checkBox.attr('checked', true);
                    else
                        checkBox.attr('checked', false);
                    checkBox.attr("data-val",status);
                }
            },
            error:function(){
                console.error("you have error");
            }
        });
    });

    $('.navigateType').on("change",function (){
        let select = $($(this).data("select"));
        select.siblings(".selects").fadeOut(500,function (){
            select.fadeIn(500);
        });
    });
    $('.delete-slider').on('click',function(){
        let branchId = $(this).data("branchid"),
        sliderId = $(this).data("imageid"),
        sliderBox = $(this).parent();

        $.ajax({
            type: "POST",
            url:"https://goldenmealpro.digisolapps.com/golden_meal_backend/public/api/branch/slider/delete",
            data:{branchId: branchId, sliderId: sliderId}, // serializes the form's elements.
            success: function(response)
            {
                if(response.status == 1){
                    sliderBox.fadeOut().remove();
                }
            },
            error:function(){
                console.error("you have error");
            }
        });
    });


    $(".form-confirm").on("click",function(event){
        event.preventDefault();
        let form = $($(this).data("form-id"));
        let title = form.data("swal-title");
        let text = form.data("swal-text");
        console.log($(this).data("formid"));

        swal({
            title: title,
            text: text,
            icon: "warning",
            buttons: [form.data("no"),form.data("yes")],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              swal(form.data("success-msg"), {
                icon: "success",
              });
              setTimeout(function(){form.submit();},1000);
            } else {
              
            }
          });
    });

})();
