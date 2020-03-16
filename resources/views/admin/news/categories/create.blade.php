@extends('layouts.admin')

@section('content')
<h1>Create News Category</h1>

<!-- if there are creation errors, they will show here -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{ Form::open(array('action' => ['Admin\NewsCategoriesController@store'], 'method' => 'POST')) }}
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active"><a class="nav-link active" href="#khmer" data-toggle="tab">Khmer</a></li>
                            <li class="nav-item"><a class="nav-link" href="#english" data-toggle="tab">English</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="khmer">
                                <div class="form-group">
                                    {{ Form::label('name_kh',  __('common.category.name')) }}<span style="color: red">*</span>
                                    {{ Form::text('name_kh', request('name_kh', null), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('description_kh',  __('common.category.description')) }}
                                    {{ Form::textarea('description_kh', request('description_kh', null), array('class' => 'form-control')) }}
                                </div>
                            </div>
                            <div class="tab-pane" id="english">
                                <div class="form-group">
                                    {{ Form::label('name_en', __('common.category.name')) }}<span style="color: red">*</span>
                                    {{ Form::text('name_en', request('name_en', null), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('description_en', __('common.category.description')) }}
                                    {{ Form::textarea('description_en', request('description_en', null), array('class' => 'form-control')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{ Form::submit(__('common.button.save'), array('class' => 'btn btn-primary')) }}
    <a class="btn btn-default" href="{{route('news_categories.index')}}"> {{__('common.button.cancel')}}</a>
{{ Form::close() }}

@endsection
