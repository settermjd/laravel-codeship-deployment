@extends('layouts.master')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
<div class="well">
    {!! Form::open(
    [
        'route' => 'manage-route',
        'class' => 'form-inline'
    ]
    ) !!}

<div class="form-group">
{!! Form::label('url', 'URL to shorten') !!}
{!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>
{!! Form::token() !!}
{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
</div>
        </div>
    </div>
@endsection