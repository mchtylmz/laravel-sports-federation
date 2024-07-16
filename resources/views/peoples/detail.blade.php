@extends('layouts.app')
@section('content')
    <x-block title="{{ $title }}">

        <form class="js-validation-form" action="{{ route('people.save', $people->id ?? '') }}" method="POST" enctype="multipart/form-data">
            @csrf



            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
