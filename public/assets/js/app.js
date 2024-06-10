!function () {
    "use strict";

    class e {
        static initValidation() {

            One.helpers("jq-validation");
            $('form.js-validation-form').each(function () {
                $(this).validate({
                    submitHandler: function (form, e) {
                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        let dataType = $(form).data('type');
                        if (!dataType) {
                            dataType = 'json';
                        }

                        $.ajax({
                            type: $(form).attr('method'),
                            url: $(form).attr('action'),
                            data: new FormData(form),
                            dataType: dataType,
                            processData: false,
                            contentType: false,
                            cache: false,
                            enctype: 'multipart/form-data',
                            beforeSend: function () {
                                $(form).find('[type=submit]').loading('show');
                            },
                            success: function (response) {
                                alert.fire({
                                    text: response.message,
                                    icon: 'success'
                                });

                                setTimeout(() => {
                                    if (response.refresh) {
                                        location.reload();
                                    }
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                }, 1500);
                            },
                            error: function (response) {
                                alert.fire({
                                    text: response.responseJSON.message,
                                    icon: 'error'
                                });
                            }
                        }).always(function () {
                            $(form).find('[type=submit]').loading('hide');
                        });
                    }
                });
            });
        }

        static initHelper() {
            // toggle password
            jQuery(document).on('click', '[data-toggle="password"]', function (e) {
                e.preventDefault();

                let btn = $(this);
                let prevInput = $(this).prev('input');

                if(prevInput.attr('type') === 'password') {
                    prevInput.attr('type', 'text');
                    btn.html('<i class="fa fa-eye-slash mx-2"></i>');
                } else {
                    prevInput.attr('type', 'password');
                    btn.html('<i class="fa fa-eye mx-2"></i>');
                }
            });

            jQuery(document).on('click', '[data-toggle="delete"]', function (e) {
                e.preventDefault();

                let btn = $(this),
                    route = btn.data('route'),
                    message = btn.data('message'),
                    id = btn.data('id');

                window.alert.fire({
                    text: message,
                    icon: "question",
                    showCancelButton: true,
                    showConfirmButton: true,
                    timer: 15000,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: route,
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            cache: false,
                            enctype: 'multipart/form-data',
                            beforeSend: function () {
                                btn.loading('show');
                            },
                            success: function (response) {
                                alert.fire({
                                    text: response.message,
                                    icon: 'success'
                                });

                                setTimeout(() => {
                                    if (response.refresh) {
                                        location.reload();
                                    }
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                }, 1500);
                            },
                            error: function (response) {
                                alert.fire({
                                    text: response.responseJSON.message,
                                    icon: 'error'
                                });
                            }
                        }).always(function () {
                            btn.loading('hide');
                        });
                    }
                });
            });

            $.fn.loading = function (status) {
                if (status === 'show') {
                    $(this).append('<i class="fa fa-spinner fa-pulse mx-2" style="--fa-animation-duration: .75s;"></i>');
                    $(this).attr('disabled', true);
                }
                if (status === 'hide') {
                    $(this).find('i.fa-spinner').remove();
                    $(this).attr('disabled', false);
                }
            }

            window.alert = Swal.mixin({
                target: "#page-container",
                showConfirmButton: false,
                showDenyButton: false,
                showCancelButton: false,
                showCloseButton: true,
                confirmButtonText: window.lang['ok'],
                cancelButtonText: window.lang['cancel'],
                timer: 5000,
                timerProgressBar: true
            });

            $('.dropify').dropify({
                messages: {
                    'default': 'Bir dosyayı buraya sürükleyip bırakın veya tıklayın',
                    'replace': 'Değiştirmek için sürükleyip bırakın veya tıklayın',
                    'remove':  'Kaldır',
                    'error':   'Hata! Yanlış bir şey oldu.'
                },
                error: {
                    'fileSize': 'Dosya boyutu çok büyük ({{ value }} maks).',
                    'minWidth': 'Resim genişliği çok küçük ({{ value }}}px min).',
                    'maxWidth': 'Resim genişliği çok büyük ({{ value }}}px max).',
                    'minHeight': 'Resim yüksekliği çok küçük ({{ value }}}px min).',
                    'maxHeight': 'Resim yüksekliği çok büyük ({{ value }}px max).',
                    'imageFormat': 'Resim formatına izin verilmiyor (yalnızca {{ value }})',
                    'fileExtension': 'Dosyaya izin verilmiyor (yalnızca {{ value }}).'
                },
            });
        }

        static init() {
            this.initHelper();
            this.initValidation();
        }
    }

    One.onLoad((() => e.init()))
}();
