<style>
    .offcanvas {
        --bs-offcanvas-width: 1208px;
    }
    .logs td {
        white-space: normal;
        word-break: break-all;
        background-color: transparent;
        max-width: 320px !important;
    }

</style>
<ul class="list-group list-group-flush">
    <li class="list-group-item">
        Kullanıcı
        <br> <strong>{{ $log->user?->name }} ({{ $log->user?->username }})</strong>
    </li>
    <li class="list-group-item">
        Log Sınıfı
        <br> <strong>{{ trans('log.table.' . ($log->table_name ?: 'empty')) }}</strong>
    </li>
    <li class="list-group-item">
        Log İşlem
        <br> <strong>{{ $log->log_type ?: '-' }}</strong>
    </li>
    <li class="list-group-item">
        Log Tarih
        <br> <strong>{{ $log->log_date?->format('Y-m-d H:i') }} - {{ $log->dateHumanize }}</strong>
    </li>
    <li class="list-group-item">
        Log IP Adresi
        <br> <strong>{{ $log->ip }}</strong>
    </li>
</ul>

<div class="row mt-3 logs">
    <div class="col-lg-{{ $data ? 6 : 12 }}">
        <p class="px-3 py-2 mb-0 bg-warning-light">Log (Eski)</p>
        <table class="table w-100">
            <tbody class="w-100">
            @foreach($log->json_data as $key => $value)
                <tr @class(['bg-info-light' => array_key_exists($key, $diff)])>
                    <td class="py-1">{{ $key }}: </td>
                    <td class="py-1">{{ $value }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div @class(['col-lg-6' => $data, 'd-none' => !$data])>
        <p class="px-3 py-2 mb-0 bg-success-light">Log (Yeni)</p>
        <table class="table w-100">
            <tbody class="w-100">
            @foreach($data as $key => $value)
                <tr @class(['bg-info-light' => array_key_exists($key, $diff)])>
                    <td class="py-1">{{ $key }}: </td>
                    <td class="py-1">{{ $value }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
