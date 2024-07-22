@props([
    'route',
    'columns',
    'size' => 15,
    'search' => true,
    'pagination' => 'server',
    'refresh' => true,
    'id' => 'bootstrap-table'
])

<div class="bootstrap-table">
    <div class="text-center px-2 mt-2 mb-3" data-toggle="bootstrap-table-loading" data-table="{{ $id }}">
        <i class="fa fa-fw fa-spinner fa-pulse fa-2x" style="--fa-animation-duration: 0.4s;" ></i>
    </div>
    <div class="table-responsive pb-3 d-none">
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

            return params;
        }
        function setLoading() {
            $('[data-toggle="bootstrap-table-loading"]').addClass('d-none');
            $(this).closest('.table-responsive').removeClass('d-none');
        }

        let bsTable = $('table');
        bsTable.on('load-success.bs.table', setLoading);
        bsTable.on('all.bs.table', setLoading);
    </script>
@endpush
