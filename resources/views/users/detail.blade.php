@extends('layouts.app')
@section('content')
    <x-block title="{{ $title }}">

        <form class="js-validation-form repeater" action="{{ route('user.save', [$userType, $user?->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($userType == 'superadmin')
                <div class="mb-3">
                    <label class="form-label" for="permit">Yetki</label>
                    <select class="selectpicker form-control" id="permit" name="permit" data-placeholder="Yetki Seçiniz...." data-size="5" data-live-search="true" required>
                        @foreach(permitCases() as $permit)
                            <option value="{{ $permit->value }}" @selected($user?->id == $permit->value)>{{ $permit->title() }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="permit" value="no">
            @endif

            <div class="mb-3">
                <label class="form-label" for="username">{{ __('users.form.username') }}</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="{{ __('users.form.username') }}.." value="{{ $user->username ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">{{ __('users.form.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('users.form.name') }}.." value="{{ $user->name ?? '' }}" required>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="phone">{{ __('users.form.phone') }}</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="{{ __('users.form.phone') }}.." value="{{ $user->phone ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="email">{{ __('users.form.email') }}</label>
                        <input type="tel" class="form-control" id="email" name="email" placeholder="{{ __('users.form.email') }}.." value="{{ $user->email ?? '' }}">
                    </div>
                </div>
            </div>

            @if(in_array($userType, ['admin', 'manager']))
                <hr>
                @if($userType == 'manager')
                    <div class="mb-3">
                        <label class="form-label" for="identity_number">{{ __('users.form.identity_number') }}</label>
                        <input type="text" class="form-control" id="identity_number" name="identity_number" placeholder="{{ __('users.form.identity_number') }}.." value="{{ $user->getMeta('identity_number') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-flex align-items-center" for="places">
                            <button type="button" class="btn btn-sm btn-alt-success px-2 me-3" data-repeater-create>
                                <i class="fa fa-plus mx-1 fa-faw"></i> {{ __('users.form.place_add') }}
                            </button>
                            <span>{{ __('users.form.places') }}</span>
                        </label>

                        <div class="mt-2" data-repeater-list="places">
                            @if($places = json_decode($user->getMeta('places'), true))
                                @foreach($places as $place)
                                    <div data-repeater-item>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="places"
                                                   placeholder="{{ __('users.form.place') }}.."
                                                   autocomplete="off"
                                                   name="place"
                                                   required
                                                   value="{{ $place }}">
                                            <button type="button" class="btn btn-danger" data-repeater-delete>
                                                <i class="fa fa-trash-alt mx-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div data-repeater-item>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="places"
                                               placeholder="{{ __('users.form.place') }}.."
                                               autocomplete="off"
                                               name="place"
                                               required>
                                        <button type="button" class="btn btn-danger" data-repeater-delete>
                                            <i class="fa fa-trash-alt mx-2"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                @endif

                @if($userType == 'admin')
                    <div class="mb-3">
                        <label class="form-label" for="federation_id">{{ __('table.federation') }}</label>
                        <select class="selectpicker form-control" id="federation_id" name="federation_id" data-placeholder="{{ __('table.federation') }}...." data-size="5" data-live-search="true" required>
                            @foreach(federations() as $federation)
                                <option value="{{ $federation->id }}" @selected($federation->id == $user->getMeta('federation_id'))>{{ $federation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <hr>
            @endif

            <div class="mb-3">
                <label class="form-label" for="password">{{ __('users.form.password') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="password" placeholder="*******" name="password" autocomplete="off" minlength="6" @required(!$user?->id)>
                    <button type="button" class="btn btn-dark" data-toggle="password">
                        <i class="fa fa-eye-slash mx-2"></i>
                    </button>
                </div>
                @if($user?->id)
                    <small>{{ __('users.form.password_info') }}</small>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label" for="event_color">{{ __('users.form.event_color') }}</label>
                <input type="color" class="form-control" id="event_color" name="event_color" placeholder="{{ __('users.form.event_color') }}.." value="{{ $user->getMeta('event_color') }}">
            </div>

            <div class="mb-3">
                <label class="form-label" for="status">{{ __('table.status') }}</label>
                <div class="space-x-2">
                    @php $status = $user->status?->value ?? 'active'; @endphp
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="radio" value="active" id="active" name="status" @checked($status == 'active')>
                        <label class="form-check-label" for="active">{{ __('table.active') }}</label>
                    </div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="radio" value="passive" id="passive" name="status" @checked($status == 'passive')>
                        <label class="form-check-label" for="passive">{{ __('table.passive') }}</label>
                    </div>
                </div>
            </div>

            <div class="mb-4 text-center">
                <input type="hidden" name="role" value="{{ $user->role ?? $userType }}">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
@push('js')
    <script src="{{ asset('assets/js/plugins/jquery.repeater/jquery.repeater.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.repeater').repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                },
            })
        });
    </script>
@endpush
