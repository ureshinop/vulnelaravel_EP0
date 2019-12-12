@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">BBS</div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('bbs.store') }}" method="POST">
                            @csrf
                            <textarea class="form-control" rows="3" name="msg"></textarea>
                            <button class="btn btn-success" type="submit">送信</button>
                        </form>
                    </div>
                </div>
            </div>
            <br> {{ $data->links() }} @foreach ($data as $raw)
            <div class="alert alert-primary" role="alert">
                {{$raw->name}} / {{$raw->created_at}}
                <p>{!! $raw->msg !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection