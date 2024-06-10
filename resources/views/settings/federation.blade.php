@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">

        <div class="text-end mb-3">
            <a type="button" class="btn btn-info" href="{{ route('settings.federation.show') }}">
                <i class="fa fa-fw fa-plus"></i> {{ __('settings.federation_add') }}
            </a>
        </div>

        <x-block title="{{ __('settings.federation') }}">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">{{ __('table.id') }}</th>
                        <th class="text-center" style="width: 50px;">{{ __('table.logo') }}</th>
                        <th>{{ __('table.title') }}</th>
                        <th>{{ __('table.document_number') }}</th>
                        <th class="text-center" style="width: 150px;">{{ __('table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($federations as $federation)
                        <tr>
                            <th class="text-center" scope="row">{{ $federation->id }}</th>
                            <td class="fw-semibold fs-sm">
                                @if($federation->logo)
                                    <img src="{!! asset($federation->logo) !!}" style="height: 48px; object-fit: contain" />
                                @endif
                            </td>
                            <td class="fw-semibold fs-sm">{{ $federation->name }}</td>
                            <td class="fw-semibold fs-sm">{{ $federation->document_number }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled" href="{{ route('settings.federation.show', $federation->id) }}">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-toggle="delete" data-route="{{ route('settings.federation.delete', $federation->id) }}" data-message="{{ __('settings.federation_delete', ['name' => $federation->name]) }}" data-id="{{ $federation->id }}">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>

    </div>
    <!-- END Page Content -->
@endsection
