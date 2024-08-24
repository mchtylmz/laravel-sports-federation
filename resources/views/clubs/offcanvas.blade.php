
<ul class="list-group list-group-flush">
    <li class="list-group-item">
        {{ __('clubs.form.name') }} <br> <strong>{{ $club->name }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('clubs.form.user_name') }} <br> <strong>{{ $club->user_name }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('clubs.form.user_phone') }} <br> <strong>{{ $club->user_phone ?: '-' }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('clubs.form.user_email') }} <br> <strong>{{ $club->user_email ?: '-' }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('clubs.form.location') }} <br> <strong>{{ $club->location ?: '-' }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('clubs.form.region') }} <br> <strong>{{ $club->region ?: '-' }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('clubs.form.status') }} <br>
        <strong class="status {{ $club->status->value }}">{{ __('table.' . $club->status->value) }}</strong>
    </li>
    <li class="list-group-item">
        Tombala <br>
        @if(!empty($club->tombala_file))
            <a target="_blank" class="text-dark w-100" href="{{ asset($club->tombala_file) }}">
                <strong>Belgeyi Görüntüle</strong>
            </a>
        @endif
    </li>
</ul>

<h5 class="bg-light-subtle p-3 mt-3 mb-0">{{ __('federations.title') }}</h5>
<ul class="list-group list-group-flush">
    @foreach($federations as $federation)
        <li class="list-group-item">
            <img src="{!! asset($federation->logo) !!}"
                 style="height: 64px; object-fit: contain; margin-right: 10px; border: solid 1px #eee;"
                 onerror="this.src='{{ asset('uploads/no-img.png') }}'"
                 alt="{{ $federation->name }}">
            <strong>{{ $federation->name }}</strong>
        </li>
    @endforeach
</ul>
