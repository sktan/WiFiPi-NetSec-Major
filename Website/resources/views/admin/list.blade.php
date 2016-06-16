@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="panel panel-default wifi-display">
        <div class="panel-heading">Wifi Network</div>
        <table class="table" id="wifi-list"> 
        <thead> 
            <tr> 
            <th>Network SSID</th> 
            <th>Action</th> 
            </tr> 
        </thead> 
        <tbody> 
            @foreach ($networks as $network)
            <tr>
                <td>{{ $network }}</td> 
                <td><a href="/admin/{{ base64_encode($network) }}" class="btn btn-primary btn-xs" id="Tafe Network">Connect</a></td> 
            </tr> 
            @endforeach
        </tbody> 
        </table>
    </div>
    </div>
</div>
@endsection