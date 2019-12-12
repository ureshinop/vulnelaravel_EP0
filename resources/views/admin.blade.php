@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin</div>
                <div class="card-body">
                    <div class="form-group content-center">
                        <a href="{{ route('admin.delete') }}"><button type="button" class="btn btn-outline-danger">投稿の全削除</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection