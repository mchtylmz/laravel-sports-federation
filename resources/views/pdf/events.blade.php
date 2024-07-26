<!doctype html>
<html lang="tr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .page-break {
            page-break-after: always;
        }
        th,td {
            border: solid 1px #2b2b2b;
            padding: 2px 5px;
        }
        table {
            display: table;
            border-collapse: collapse;
            box-sizing: border-box;
            text-indent: initial;
            unicode-bidi: isolate;
            border-spacing: 2px;
            border-color: gray;
        }
        .text-center {
            text-align: center;
        }
    </style>
    <title>Hello, world!</title>
</head>
<body>

@if($federation)
    <center>
        <img src="{{ public_path($federation?->logo) }}" style="height: 150px; object-fit: contain" />
        <h2>{{ $federation->name }}</h2>
    </center>
@endif

<table class="table table-bordered" style="width: 100%;">
    <thead>
    <tr>
        <th scope="col"></th>
        <th scope="col">Kullanıcı</th>
        <th scope="col">Başlık</th>
        <th scope="col">Yer</th>
        <th scope="col">Tarih</th>
        <th scope="col">Saat</th>
        <th scope="col">Bölge</th>
        <th scope="col">Durum</th>
    </tr>
    </thead>
    <tbody>
    @foreach($events as $event)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $event['user']?->name }}</td>
            <td>{{ $event['title'] }}</td>
            <td class="text-center">{{ $event['location'] }}</td>
            <td class="text-center">
                {{ date('Y-m-d', strtotime($event['start_date'])) }}
                <br>
                {{ date('Y-m-d', strtotime($event['end_date'])) }}-
            </td>
            <td>{{ date('H:i', strtotime($event['start_time'])) }}</td>
            <td>{{ $event['is_national'] ? 'Uluslar Arası' : 'Yerel' }}</td>
            <td>{{ $event['status'] }}</td>
        </tr>
        @if($event['end_notes'])
            <tr>
                <td class="text-center"></td>
                <td colspan="7">Not: {{ $event['end_notes'] }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>

<br>
<br>
<div style="text-align: right">
    <small>{{ now()->format('Y-m-d H:i') }}</small>
</div>

</body>
</html>

