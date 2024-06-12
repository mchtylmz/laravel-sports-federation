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
        function setImage(value, row) {
            eval('var image = row.' + this.field + '_image;');
            return '<img src="' + image + '" style="height: 48px; object-fit: contain;" />';
        }
        function setActions(value, row) {
            return row.actions;
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
