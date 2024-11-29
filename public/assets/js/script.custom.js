/**
 * Custom scripts
 * 
 * @author Xanders Samoth
 * @see https://www.xsam-tech.com
 */
/* Some variables */
var currentHost = $('[name="cnpr-url"]').attr('content');
var currentUser = $('[name="cnpr-visitor"]').attr('content');
var currentLanguage = $('html').attr('lang');
var headers = { 'Authorization': 'Bearer ' + $('[name="cnpr-ref"]').attr('content'), 'Accept': 'application/json', 'X-localization': navigator.language };
var modalUser = $('#cropModalUser');
var retrievedAvatar = document.getElementById('retrieved_image');
var retrievedImageOtherUser = document.getElementById('retrieved_image_other_user');
var currentImageOtherUser = document.querySelector('#otherUserImageWrapper img');
var cropper;

$(document).ready(function () {
    /* Perfect scrollbar */
    const ps = new PerfectScrollbar('.menu-sidebar2__content', {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20
    });

    /* Bootstrap Tooltip */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });


    /* jQuery DataTable */
    $('#dataList, .dataList').DataTable({
        language: { url: currentHost + '/assets/addons/custom/dataTables/Plugins/i18n/' + $('html').attr('lang') + '.json' },
        paging: 'matchMedia' in window ? (window.matchMedia('(min-width: 500px)').matches ? true : false) : false,
        ordering: false,
        info: 'matchMedia' in window ? (window.matchMedia('(min-width: 500px)').matches ? true : false) : false
    });

    /* jQuery scroll4ever */
    $('#scope').scroll4ever({
        trigger: '.next-page-link',
        container: '#items',
        selector: '.item',
        distance: 100,
        debug: true,
        start: function () { $('.next-page-link').html('<div class="loader"><div class="loaderBar"></div></div>'); },
        complete: function () { }
    });

    /* Custom Boostrap stylesheet */
    $('input, select, textarea, .navbar, .card, .btn').addClass('shadow-0');
    $('.btn').css({ textTransform: 'inherit', paddingBottom: '0.5rem' });

    /* Click to back to top */
    let btnBackTop = document.getElementById('btnBackTop');

    /* When the user scrolls down 20px from the top of the document, show the button */
    window.onscroll = function() { scrollFunction() };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            btnBackTop.classList.remove('d-none');

        } else {
            btnBackTop.classList.add('d-none');
        }
    }

    /* When the user clicks on the button, scroll to the top of the document */
    function backToTop() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }

    /* Auto-resize textarea */
    autosize($('textarea'));

    /* jQuery UI date picker */
    $('#register_birthdate, #register_otherdate').datepicker({
        dateFormat: currentLanguage.startsWith('fr') ? 'dd/mm/yy' : 'mm/dd/yy',
        onSelect: function () {
            $(this).focus();
        }
    });

    /* Card hover effect */
    $('.card .stretched-link').each(function () {
        $(this).hover(function () {
            $(this).addClass('changed');

        }, function () {
            $(this).removeClass('changed');
        });
    });

    /* Upload cropped user image */
    $('#avatar').on('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            retrievedAvatar.src = url;
            var modal = new bootstrap.Modal(document.getElementById('cropModalUser'), { keyboard: false });

            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $(modalUser).on('shown.bs.modal', function () {
        cropper = new Cropper(retrievedAvatar, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '#cropModalUser .preview',
            done: function (data) { console.log(data); },
            error: function (data) { console.log(data); }
        });

    }).on('hidden.bs.modal', function () {
        cropper.destroy();

        cropper = null;
    });

    $('#cropModalUser #crop_avatar').click(function () {
        // Ajax loading image to tell user to wait
        $('.user-image').attr('src', currentHost + '/assets/img/ajax-loading.gif');

        var canvas = cropper.getCroppedCanvas({
            width: 700,
            height: 700
        });

        canvas.toBlob(function (blob) {
            URL.createObjectURL(blob);

            var reader = new FileReader();

            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64_data = reader.result;
                var userId = document.getElementById('user_id').value;
                var mUrl = currentHost + '/api/user/update_avatar_picture/' + parseInt(currentUser.split('-')[1]);
                var datas = JSON.stringify({ 'id': parseInt(currentUser.split('-')[1]), 'user_id': userId, 'image_64': base64_data, 'account_owner_id': userId });

                $.ajax({
                    headers: headers,
                    type: 'PUT',
                    contentType: 'application/json',
                    url: mUrl,
                    dataType: 'json',
                    data: datas,
                    success: function (res) {
                        $('.user-image').attr('src', res);
                        window.location.reload();
                    },
                    error: function (xhr, error, status_description) {
                        console.log(xhr.responseJSON);
                        console.log(xhr.status);
                        console.log(error);
                        console.log(status_description);
                    }
                });
            };
        });
    });

    /* Display cropped image */
    $('#image_other_user').on('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            retrievedImageOtherUser.src = url;
            var modal = new bootstrap.Modal(document.getElementById('cropModalOtherUser'), { keyboard: false });

            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $('#cropModalOtherUser').on('shown.bs.modal', function () {
        cropper = new Cropper(retrievedImageOtherUser, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '#cropModalOtherUser .preview',
            done: function (data) { console.log(data); },
            error: function (data) { console.log(data); }
        });

    }).on('hidden.bs.modal', function () {
        cropper.destroy();

        cropper = null;
    });

    $('#cropModalOtherUser #crop_other_user').on('click', function () {
        var canvas = cropper.getCroppedCanvas({
            width: 700,
            height: 700
        });

        canvas.toBlob(function (blob) {
            URL.createObjectURL(blob);
            var reader = new FileReader();

            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64_data = reader.result;

                $(currentImageOtherUser).attr('src', base64_data);
                $('#data_other_user').attr('value', base64_data);
                $('#otherUserImageWrapper p').removeClass('d-none');
            };
        });
    });
});

/* Set all notifications/messages status as read */
function markAllRead(entity, id) {
    var datas = entity == 'notification' ? JSON.stringify({ 'user_id': parseInt(id) }) : JSON.stringify({ 'message_id': parseInt(id) });

    $.ajax({
        headers: headers,
        type: 'PUT',
        contentType: 'application/json',
        url: currentHost + '/api/' + entity + '/mark_all_read/' + parseInt(id),
        dataType: 'json',
        data: datas,
        success: function () {
            window.location.reload();
        },
        error: function (xhr, error, status_description) {
            console.log(xhr.responseJSON);
            console.log(xhr.status);
            console.log(error);
            console.log(status_description);
        }
    });
}

/* Set notification/message status as read */
function switchRead(entity, element) {
    var element_id = element.id;
    var id = element_id.split('-')[1];

    $.ajax({
        headers: headers,
        type: 'PUT',
        contentType: 'application/json',
        url: currentHost + '/api/' + entity + '/switch_status/' + parseInt(id),
        dataType: 'json',
        data: JSON.stringify({ 'id': parseInt(id) }),
        success: function () {
            window.location.reload();
        },
        error: function (xhr, error, status_description) {
            console.log(xhr.responseJSON);
            console.log(xhr.status);
            console.log(error);
            console.log(status_description);
        }
    });
}
