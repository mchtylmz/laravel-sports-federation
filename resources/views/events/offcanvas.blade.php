@php
    $start_date = sprintf('%s %s', $event->start_date?->format('Y-m-d'), $event->start_time);
    $end_date = sprintf('%s %s', $event->end_date?->format('Y-m-d'), $event->end_time);
@endphp
<ul class="list-group list-group-flush">
    <li class="list-group-item">
        {{ __('events.form.user_name') }}
        <br> <strong>{{ $event->user?->name }} ({{ $event->user?->username }})</strong>
    </li>
    <li class="list-group-item">
        {{ __('events.form.title') }}
        <br>
        <strong>{{ $event->title }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('events.form.content') }}
        <br> <strong>{{ $event->content }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('events.form.location') }}
        <br> <strong>{{ $event->location }}</strong>
    </li>
    <li class="list-group-item">
        Uluslar Arası
        <br> <strong>{{ $event->is_national ? __('table.national')  : __('table.local') }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('events.form.start_date') }}
        <br> <strong>{{ Carbon\Carbon::parse($start_date)->translatedFormat('d F Y l, H:i') }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('events.form.end_date') }}
        <br> <strong>{{ Carbon\Carbon::parse($end_date)->translatedFormat('d F Y l, H:i') }}</strong>
    </li>
    <li class="list-group-item">
        Durum
        <br> <strong>{{ $event->status }}</strong>
    </li>
    @if($event->groups()->count())
        <li class="list-group-item">
        Etkinlik Kafilesi <br>
        @foreach($event->groups as $group)
                <strong>({{ $group->people?->type->title() }}) {{ $group->people?->fullname }}</strong> <br>
            @endforeach
        </li>
    @else
        <li class="list-group-item">
            Etkinlik Kafilesi
            <br> <strong>Hayır, Yok</strong>
        </li>
    @endif
    <li class="list-group-item">
        {{ __('events.form.end_notes') }}
        <br> <strong>{{ $event->end_notes }}</strong>
    </li>
</ul>
