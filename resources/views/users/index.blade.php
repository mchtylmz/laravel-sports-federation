@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">

        <div class="text-end mb-3">
            <a type="button" class="btn btn-info" href="{{ route('user.show', $userType) }}">
                <i class="fa fa-fw fa-plus"></i> {{ __('users.add_'.$userType) }}
            </a>
        </div>

        <x-block title="{{ $title }}">
            <x-table route="{{ route('user.json', $userType) }}">
                <x-slot name="columns">
                    <th data-field="id" data-width="5">
                        {{ __('table.id') }}
                    </th>
                    @if($userType == 'admin')
                        <th data-field="federation_name" data-sortable="true" data-width="10" data-align="left">
                            {{ __('table.federation') }}
                        </th>
                    @endif
                    @if($userType == 'manager')
                    <th data-field="identity_number" data-sortable="true" data-width="15" data-align="left">
                        {{ __('table.identity_number') }}
                    </th>
                    @endif
                    <th data-field="username" data-sortable="true" data-width="15" data-align="left">
                        {{ __('table.username') }}
                    </th>
                    <th data-field="name" data-sortable="true" data-width="15" data-align="left">
                        {{ __('table.name') }}
                    </th>
                    <th data-field="email" data-sortable="true" data-width="5" data-align="left">
                        {{ __('table.email') }}
                    </th>
                    <th data-field="last_login" data-sortable="true" data-width="5" data-align="left">
                        {{ __('table.last_login') }}
                    </th>
                    <th data-field="id" data-formatter="setActions">
                        {{ __('table.actions') }}
                    </th>
                </x-slot>
            </x-table>
        </x-block>
    </div>
    <!-- END Page Content -->
@endsection
