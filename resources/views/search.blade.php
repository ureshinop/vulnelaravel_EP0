@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザー検索</div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('search.post') }}"
                              method="GET">
                            <input class="form-control"
                                   type="text"
                                   name="userid"
                                   value="{{@$userid}}">
                            <button class="form-control btn btn-success"
                                    type="submit">検索</button>
                        </form>
                    </div>
                    <div>検索ワード:
                        @if((int)env('S_LEVEL') === 2) {{ @$userid }} @else {!! @$userid !!} @endif</div>
                </div>

            </div>
            <ul class="list-group">
                @if((int)env('S_LEVEL') === 0)
                @if(isset($users))
                @foreach (@$users as $row)
                <li class="list-group-item"> @php echo $row['userid']." / ".$row['name']; @endphp</li>
                @endforeach
                @endif

                @elseif((int)env('S_LEVEL') === 1)
                {{-- LV1 --}}
                @if(isset($users))
                @foreach (@$users as $row)
                <li class="
                                   list-group-item"> @php echo $row->userid." / ".$row->name; @endphp</li>
                @endforeach
                @endif

                @else
                @if(isset($users))
                {{-- LV2 --}}
                @foreach (@$users as $row)
                <li class="list-group-item">{{ $row->userid." / ".$row->name }}</li>
                @endforeach
                @endif
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection