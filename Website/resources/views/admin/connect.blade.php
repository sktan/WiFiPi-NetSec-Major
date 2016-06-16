@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="panel panel-default wifi-display">
        <div class="panel-heading">Connect to: {{ $network }}</div>
        <form class="form-horizontal wifi-login-form" METHOD="POST">
            {{ csrf_field() }}
            @if(isset($success))
            <div class="alert alert-success" role="alert">
                <strong>Connecting to Network</strong> 
                Please wait a few seconds
            </div>
            @endif
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                <input style="password" type="password" class="form-control" name="password" placeholder="WiFi Password">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default pull-right btn-primary">Connect</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection