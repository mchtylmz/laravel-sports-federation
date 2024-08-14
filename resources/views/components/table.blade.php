@props([
    'route',
    'columns',
    'size' => 15,
    'search' => true,
    'pagination' => 'server',
    'refresh' => true,
    'id' => 'bootstrap-table-' . time(),
    'exportPdf' => false,
    'exportExcel' => false,
])

<div class="bootstrap-table">
    <div class="text-center px-2 mt-2 mb-3" data-toggle="bootstrap-table-loading" data-table="{{ $id }}">
        <i class="fa fa-fw fa-spinner fa-pulse fa-2x" style="--fa-animation-duration: 0.4s;" ></i>
    </div>
    <div class="table-responsive pb-3 d-none">
        <div id="{{ $id }}-toolbar">
            @if($exportPdf || $exportExcel)
                <div class="dropdown mx-2">
                    <a class="btn btn-secondary dropdown-toggle table-export" href="#" role="button" id="exportLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Dışa Aktar
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @if($exportPdf)
                            <li>
                                <a target="_blank" class="dropdown-item py-2 table-export-pdf" href="{{ $exportPdf }}">
                                    <i class="fa fa-file-pdf fa-fw mx-2"></i> PDF
                                </a>
                            </li>
                        @endif
                        @if($exportExcel)
                            <li>
                                <a target="_blank" class="dropdown-item py-2 table-export-excel" href="{{ $exportExcel }}">
                                    <i class="fa fa-file-excel fa-fw mx-2"></i> Excel
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
        <table
            id="{{ $id }}"
            data-toggle="table"
            data-side-pagination="{{ $pagination }}"
            data-pagination="true"
            data-pagination-info="false"
            data-page-list="All"
            data-show-refresh="{{ $refresh }}"
            data-page-size="{{ $size }}"
            data-search="{{ $search }}"
            data-url="{{ $route }}"
            data-mobile-responsive="true"
            data-show-search-button="true"
            data-buttons-align="left"
            data-query-params="queryParams"
            data-toolbar="#{{ $id }}-toolbar"
            {{ $attributes }}>
            <thead>
            <tr>
                {{ $columns }}
            </tr>
            </thead>
        </table>
    </div>
</div>

@push('css')
    <link href="{{ asset('assets/js/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/bootstrap-table/dist/bootstrap-table.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-table/dist/locale/bootstrap-table-tr-TR.min.js') }}"></script>
    <script>
        function setHtml(value, row) {
            eval('var html = row.' + this.field + '_html;');
            return html;
        }
        function setText(value, row) {
            eval('var text = row.' + this.field + '_text;');
            return text;
        }
        function setNotes(value, row) {
            return '<button type="button" class="btn btn-sm btn-alt-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-toggle="view" data-route="'+row.route_note+'"><i class="fa fa-fw fa-note-sticky ms-1 pl-0"></i> '+ row.notes_count+'</button>';
        }
        function setImage(value, row) {
            eval('var image = row.' + this.field + '_image;');
            return '<img alt="' + image + '" src="' + image + '" style="height: 48px; object-fit: contain;" onerror="this.src=\'{{ asset('uploads/no-img.png') }}\'"/>';
        }
        function setActions(value, row) {
            return row.actions;
        }

        function queryParams(params) {
            let filterForm = $('form.js-filter-table');
            if (filterForm.length) {
                filterForm.serializeArray().forEach(function (row, index) {
                    params[row.name] = row.value;
                })
            }
            let eventForm = $('form.js-filter-event');
            if (eventForm.length) {
                eventForm.serializeArray().forEach(function (row, index) {
                    params[row.name] = row.value;
                })
            }

            exportAttribute(params);

            return params;
        }
        function setLoading() {
            $('[data-toggle="bootstrap-table-loading"]').addClass('d-none');
            $(this).closest('.table-responsive').removeClass('d-none');
        }

        function exportAttribute(params) {
            let exportExcel = $('a.table-export-excel'),
                exportPdf = $('.table-export-pdf'),
                exportParams = jQuery.param(params);

            exportParams = exportParams.toString().replaceAll('undefined', '');

            if (exportExcel.length) {
                let exportExcelHref = exportExcel.attr('href').split('?')[0];
                exportExcel.attr('href', exportExcelHref + '?' + exportParams);
            }

            if (exportPdf.length) {
                let exportPdfHref = exportPdf.attr('href').split('?')[0];
                exportPdf.attr('href', exportPdfHref + '?' + exportParams);
            }
        }

        let bsTable = $('table');
        bsTable.on('load-success.bs.table', setLoading);
        bsTable.on('all.bs.table', setLoading);

        $(document).on('click', '.table-export-pdf', function (e) {
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-pulse fa-fw mx-2"></i> PDF');

            setTimeout(() => {
                $(this).prop('disabled', false);
                $(this).html('<i class="fa fa-file-pdf fa-fw mx-2"></i> PDF');
            }, 2000)
        });

        $(document).on('click', '.table-export-excel', function (e) {
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-pulse fa-fw mx-2"></i> Excel');

            setTimeout(() => {
                $(this).prop('disabled', false);
                $(this).html('<i class="fa fa-file-excel fa-fw mx-2"></i> Excel');
            }, 2000)
        });
    </script>
@endpush
