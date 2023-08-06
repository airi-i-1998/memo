@extends('layouts.app')

@section('content')
<div class="left-menu">
    <a href="{{ route('memo.index')}}" class="btn btn-memo"><i class="fas fa-pen fa-lg"></i></a><br>
    <a href="{{ route('richmemo.index')}}" class="btn btn-richmemo"><i class="far fa-clipboard fa-lg"></i></a>
</div>
<div class="h-100 bg-white w-70 te-1">
        <div class="row h-100 m-0 p-0">
            <div class="col-3 h-100 m-0">
                <div class="left-memo-menu d-flex justify-content-between pt-2">
                </div>
                <div class="h3 pl-3 pt-3">
                    メモなし
                </div>
            </div>
        </div>
</div>
