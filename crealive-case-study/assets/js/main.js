let SITE_URL = "http://localhost/mehmetozgul/crealive-case-study"

$(function () {
    $(document).on("click", "#adminLoginBtn", function() {
        $(".adminLoginLoad").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'), $("#adminLoginBtn").prop("disabled", !0);
        let data = $("form#adminLoginForm").serialize();
        $.ajax({
            url: SITE_URL + "/functions/operations.php?operation=admin-login",
            method: "post",
            data: data,
            success: function(data) {
                let e = (data = data.split(":::", 2))[0],
                    o = data[1];
                if ("error" == o) $(".adminLoginLoad").html(""), $("#adminLoginBtn").prop("disabled", !1), Swal.fire({
                    icon: "warning",
                    title: e,
                    showConfirmButton: !1,
                    toast: !0,
                    timer: 2500,
                    showCloseButton: !0,
                });
                else if ("success" == o) {
                    $(".adminLoginLoad").html(""), $("#adminLoginBtn").prop("disabled", !1), $("form#adminLoginBtn").trigger("reset"), Swal.mixin({
                        toast: !0,
                        position: "top-end",
                        showConfirmButton: !1,
                        timer: 1750,
                        timerProgressBar: !0,
                        didOpen: t => {
                            t.addEventListener("mouseenter", Swal.stopTimer), t.addEventListener("mouseleave", Swal.resumeTimer)
                        }
                    }).fire({
                        icon: "success",
                        title: e
                    })
                    setTimeout(function (){
                        window.location.href=SITE_URL + '/ccs-admin/';
                    }, 1750)
                }
            }
        })
    })
})
$(function () {
    $(document).on("click", "#ccs-logout", function() {
        let email = $(this).attr("email")
        $.ajax({
            url: SITE_URL + "/functions/operations.php?operation=admin-logout",
            method: "post",
            data: "email=" + email,
            success: function(data) {
                var e = (data = data.split(":::", 2))[0],
                    o = data[1];
                if ("error" == o) Swal.fire({
                    icon: "warning",
                    title: e,
                    showConfirmButton: !1,
                    toast: !0,
                    timer: 2500,
                    showCloseButton: !0,
                });
                else if ("success" == o) {
                    Swal.mixin({
                        toast: !0,
                        position: "top-end",
                        showConfirmButton: !1,
                        timer: 1750,
                        timerProgressBar: !0,
                        didOpen: t => {
                            t.addEventListener("mouseenter", Swal.stopTimer), t.addEventListener("mouseleave", Swal.resumeTimer)
                        }
                    }).fire({
                        icon: "success",
                        title: e
                    })
                    setTimeout(function (){
                        window.location.href=SITE_URL;
                    }, 1750)
                }
            }
        })
    })
})
$(function (){
    $(document).on('click', '#addBlogBtn', function (){
        $(".addBlogLoad").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $("#addBlogBtn").prop("disabled", true);
        let myData = $("form#addBlogForm");
        $.ajax({
            url: SITE_URL+'/ccs-admin/operations.php?operation=add-blog',
            method: "post",
            data: new FormData(myData[0]),
            contentType:false,
            processData: false,
            success:function (data){
                data=data.split(":::", 3);
                let message = data[0];
                let mistake = data[1];
                let blogID = data[2];
                if(mistake == 'error'){
                    $(".addBlogLoad").html('');
                    $("#addBlogBtn").prop("disabled", false);
                    Swal.fire({
                        icon: 'warning',
                        title: message,
                        showConfirmButton: false,
                        toast: true,
                        timer:2500,
                        showCloseButton: true
                    })
                }
                else if(mistake == 'success'){
                    $(".addBlogLoad").html('');
                    $("#addBlogBtn").prop("disabled", false);
                    $("form#addBlogForm").trigger("reset");
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1750,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: message
                    })
                    setTimeout(function (){
                        window.location.href= `${SITE_URL}/ccs-admin/edit-blog.php?blogId=${blogID}`;
                    }, 1750)
                }
            }
        })

    })
})
$(function (){
    $(document).on('click', '#editBlogBtn', function (){
        $(".editBlogLoad").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $("#editBlogBtn").prop("disabled", true);
        let myData = $("form#editBlogForm");
        $.ajax({
            url: SITE_URL+'/ccs-admin/operations.php?operation=edit-blog',
            method: "post",
            data: new FormData(myData[0]),
            contentType:false,
            processData: false,
            success:function (data){
                data=data.split(":::", 3);
                let message = data[0];
                let mistake = data[1];
                let blogID = data[2];
                if(mistake == 'error'){
                    $(".editBlogLoad").html('');
                    $("#editBlogBtn").prop("disabled", false);
                    Swal.fire({
                        icon: 'warning',
                        title: message,
                        showConfirmButton: false,
                        toast: true,
                        timer: 2500,
                        showCloseButton: true
                    })
                }
                else if(mistake == 'success'){
                    $(".editBlogLoad").html('');
                    // $("#editBlogBtn").prop("disabled", false);
                    // $("form#editBlogForm").trigger("reset");
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1750,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: message
                    })
                    setTimeout(function (){
                        window.location.href= `${SITE_URL}/ccs-admin/edit-blog.php?blogId=${blogID}`;
                    }, 1750)
                }
            }
        })

    })
})
$(function (){
    $(document).on('click', '.delete-blog', function (){
        let blogId = $(this).attr("id")
        let myData = `blogId=${blogId}`
        $(".delete-blog").prop("disabled", true);
        $.ajax({
            url: SITE_URL+'/ccs-admin/operations.php?operation=delete-blog',
            method: "post",
            data: myData,
            success:function (data){
                data=data.split(":::", 2);
                let message = data[0];
                let mistake = data[1];
                if(mistake == 'error'){
                    $(".delete-blog").prop("disabled", false);
                    Swal.fire({
                        icon: 'warning',
                        title: message,
                        showConfirmButton: false,
                        toast: true,
                        timer:22500,
                        showCloseButton: true,
                        customClass: {
                            closeButton: 'swalCancelBtnX',
                            container: 'swalContainerWidth',
                            title: 'swalTitle',
                        }
                    })
                }
                else if(mistake == 'success'){
                    $(".delete-blog").prop("disabled", false);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1750,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: message
                    })
                    $(`#${blogId}`).fadeOut(400, function () {
                        $(this).parent().parent().remove()
                    });
                }
            }
        })

    })
})
$(function () {
    $("#blog-thumb").change(function() {
        $(".thumbnail-preview").css("display","block")
        readURL(this)
    })
})
function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#thumbnailImagePreview').css('background-image', 'url('+e.target.result +')')
            $('#thumbnailImagePreview').hide()
            $('#thumbnailImagePreview').fadeIn(650)
        }
        reader.readAsDataURL(input.files[0])
    }
}