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
                                if (response.message) {
                                    alert.fire({
                                        text: response.message,
                                        icon: 'success'
                                    });
                                }

                                setTimeout(() => {
                                    if (response.refresh) {
                                        let bsTable = $('[data-toggle="table"]');
                                        if (bsTable.length) {
                                            bsTable.bootstrapTable('refresh');
                                        } else {
                                            location.reload();
                                        }
                                    }
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                }, 500);
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

            jQuery(document).on('submit', 'form.js-filter-table', function (e) {
                e.preventDefault();
                $('[data-toggle="table"]').bootstrapTable('refresh');
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
                            enctype: 'multipart/form-data',
                            beforeSend: function () {
                                btn.loading('show');
                            },
                            success: function (response) {
                                alert.fire({
                                    text: response.message,
                                    icon: 'success'
                                });

                                if (response.refresh) {
                                    let bsTable = $('[data-toggle="table"]');
                                    if (bsTable.length) {
                                        bsTable.bootstrapTable('refresh');
                                    }
                                }

                                if (response.offcanvas) {
                                    btn.closest('.element-source').remove();
                                }

                                setTimeout(() => {
                                    if (response.refresh) {
                                        let bsTable = $('[data-toggle="table"]');
                                        if (!bsTable.length) {
                                            location.reload();
                                        }
                                    }
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                }, 750);
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

            jQuery(document).on('click', '[data-toggle="view"]', function (event) {
                event.preventDefault();

                let btn = $(this), route = btn.data('route');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: route,
                    data: {},
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
                    beforeSend: function () {
                        btn.loading('show');
                    },
                    success: function (response) {
                        $('.offcanvas-title').html(response.title);
                        $('.offcanvas-body').html(response.body);


                        function formOffcanvas(vForm) {
                            vForm.validate({
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
                                            if (response.message) {
                                                alert.fire({
                                                    text: response.message,
                                                    icon: 'success'
                                                });
                                            }

                                            if (response.title !== undefined) {
                                                $('.offcanvas-title').html(response.title);
                                            }
                                            if (response.body !== undefined) {
                                                $('.offcanvas-body').html(response.body);
                                            }

                                            let formNote = $('form.note-form');
                                            if (formNote.length) {
                                                formOffcanvas(formNote);
                                            }

                                            let formEventStatus = $('form.event-status-form');
                                            if (formEventStatus.length) {
                                                formOffcanvas(formEventStatus);
                                            }

                                            setTimeout(() => {
                                                let bsTable = $('[data-toggle="table"]');
                                                if (bsTable.length) {
                                                    bsTable.bootstrapTable('refresh');
                                                }
                                            }, 500);
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
                        }

                        let formNote = $('form.note-form');
                        if (formNote.length) {
                            formOffcanvas(formNote);
                        }

                        let formEventStatus = $('form.event-status-form');
                        if (formEventStatus.length) {
                            formOffcanvas(formEventStatus);
                        }

                    },
                    error: function (response) {
                        alert.fire({
                            text: response.responseJSON.message,
                            icon: 'error'
                        });

                        setTimeout(() => {
                            $('#offcanvasRight').offcanvas('hide');
                        }, 500);
                    }
                }).always(function () {
                    btn.loading('hide');
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

            $('.daterangepicker').daterangepicker({
                autoUpdateInput: false,
                alwaysShowCalendars: true,
                showWeekNumbers: true,
                showDropdowns: true,
                showCustomRangeLabel: true,
                applyClass: "btn btn-xs btn-info",
                cancelClass: "btn btn-xs btn-secondary",
                ranges: {
                    'Bugün': [moment(), moment()],
                    'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Son 7 gün': [moment().subtract(6, 'days'), moment()],
                    'Son 30 gün': [moment().subtract(29, 'days'), moment()],
                    'Bu ay': [moment().startOf('month'), moment().endOf('month')],
                    'Geçen ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "fromLabel": "Dan",
                    "toLabel": "a",
                    "customRangeLabel": "Seç",
                    "daysOfWeek": [
                        "Pt",
                        "Sl",
                        "Çr",
                        "Pr",
                        "Cm",
                        "Ct",
                        "Pz"
                    ],
                    "monthNames": [
                        "Ocak",
                        "Şubat",
                        "Mart",
                        "Nisan",
                        "Mayıs",
                        "Haziran",
                        "Temmuz",
                        "Ağustos",
                        "Eylül",
                        "Ekim",
                        "Kasım",
                        "Aralık"
                    ],
                    "firstDay": 1
                }
            });
            $('.daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('.dropify').dropify({
                messages: {
                    'default': 'Bir fotoğraf seçin',
                    'replace': 'Değiştirmek için tıklayın',
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
                }
            });
        }

        static init() {
            One.helpersOnLoad(['js-flatpickr', 'jq-masked-inputs']);
            this.initHelper();
            this.initValidation();
        }
    }

    One.onLoad((() => e.init()))
}();
