<ul class="list-group list-group-flush">
    <li class="list-group-item">
        {{ __('users.form.username') }}
        <br> <strong>{{ $user->username }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('users.form.name') }}
        <br>
        <strong>{{ $user->name }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('users.form.phone') }}
        <br> <strong>{{ $user->phone ?: '-' }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('users.form.email') }}
        <br> <strong>{{ $user->email ?: '-' }}</strong>
    </li>
    @if($user->role == 'manager')
        <li class="list-group-item">
            {{ __('users.form.identity_number') }}
            <br> <strong>{{ $user->getMeta('identity_number') ?: '-' }}</strong>
        </li>
        <li class="list-group-item">
            {{ __('users.form.places') }}
            <br>
            @if($places = json_decode($user->getMeta('places'), true))
                @foreach($places as $place)
                    <strong>{{ $place }}</strong> <br>
                @endforeach
            @else
                -
            @endif
        </li>
    @endif
    @if($user->role == 'admin')
        <li class="list-group-item">
            {{ __('table.federation') }}
            <br>
            <div class="d-flex align-items-center gap-2">
                @if($user->federation()?->logo)
                    <img src="{!! asset($user->federation()?->logo) !!}" style="height: 36px; object-fit: contain; margin-right: 10px">
                @endif
                <strong>{{ $user->federation()?->name ?: '-' }}</strong>
            </div>
        </li>
    @endif
    <li class="list-group-item">
        {{ __('users.form.event_color') }}
        <br>
        <div style="width: 24px; height: 24px; background-color: {{ $user->event_color ?: '#000' }}"></div>
    </li>
    <li class="list-group-item">
        {{ __('table.last_login') }}
        <br> <strong>{{ $user->last_login?->format('Y-m-d H:i') ?: '-' }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('table.status') }} <br>
        <strong class="status {{ $user->status->value }}">{{ __('table.' . $user->status->value) }}</strong>
    </li>
</ul>
