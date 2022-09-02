@extends('layouts.app')
@section('breadcrumb')
<li class="breadcrumb-item">
    klass_subject_teachers
</li>
@endsection
@section('header')
<h3><i class="fa fa-list"></i> klass_subject_teachers </h3>
@endsection
@section('tools')
<a class="btn btn-secondary" href="{{route('klass_subject_teachers.create')}}">
    <span class="fa fa-plus"></span>
</a>
@endsection

@section('content')
<div class="row">
    @foreach($records as $record)
    <div class="col-sm-6">
        @include('cards.klass_subject_teacher')
    </div>
    @endforeach
</div>
{!! $records->render() !!}
@endSection