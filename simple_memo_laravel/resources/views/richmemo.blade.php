


@extends('layouts.app')
@section('content')
<div class="left-menu">
        <a href="{{ route('memo.index')}}" class="btn btn-memo"><i class="fas fa-pen fa-lg"></i></a><br>
        <a href="{{ route('richmemo.index')}}" class="btn btn-richmemo"><i class="far fa-clipboard fa-lg"></i></a>
</div>
    <div class="h-100 bg-white w-70">
        <div class="row h-100 m-0 p-0">
            <div class="col-3 h-100 m-0 ">
                <div class="left-memo-menu d-flex justify-content-between pt-2">
                    <div class="pl-3 pt-2">
                        {{ $name }}さん、こんにちは。
                    </div>
                    <div class="pr-1">
                        <a href="{{ route('richmemo.add')}}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                        <a href="{{ route('memo.logout') }}" class="btn btn-dark"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
            <div class="left-memo-title h3 pl-3 pt-3">
                メモリスト
            </div>
            <div class="left-memo-list list-group-flush p-0">
            @if ($richmemos->count() === 0)
                <div class="pl-3 pt-3 h5 text-info text-center">
                    <i class="far fa-surprise"></i>メモがありません。
                </div>
            @endif
             @foreach ($richmemos as $richmemo)
             <a href="{{ route('richmemo.select', ['id' => $richmemo->id]) }}" class="list-group-item list-group-item-action  @if ($select_memo) {{ $select_memo->id == $richmemo->id ? 'active' : '' }} @endif ">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $richmemo->title }} </h5>
                        <small>{{ date('Y/m/d H:i', strtotime($richmemo->updated_at)) }}</small>
                    </div>
                    <p class="mb-1">
                        @if (mb_strlen($richmemo->content) <= 100)
                            {{ $richmemo->content }}
                        @else
                            {{ mb_substr($richmemo->content, 0, 100) . "..." }}
                        @endif
                    </p>
                </a>
                @endforeach
            </div>
        </div>
        <div class="col-9 h-100">
        @if ($select_memo)
        <form class="w-100 h-100" method="post">
            @csrf
            <input type="hidden" name="edit_id" value="{{ $select_memo->id }}" />
            <div id="memo-menu">
                <button type="submit" class="btn btn-dark" formaction="{{ route('richmemo.update') }}"><i class="fas fa-cut"></i></button>
                <button type="submit" class="btn btn-dark" formaction="{{ route('richmemo.update') }}"><i class="fas fa-regular fa-folder"></i></button>
                <button type="submit" class="btn btn-danger" formaction="{{ route('richmemo.delete') }}"><i class="fas fa-trash-alt"></i></button>
                <button type="submit" class="btn btn-success" formaction="{{ route('richmemo.update') }}"><i class="fas fa-save"></i></button>
            </div>
            <input type="text" id="memo-title" name="edit_title" placeholder="タイトルを入力する..." value="{{ $select_memo->title }}" />
            <textarea id="memo-content" name="edit_content" placeholder="内容を入力する...">{{ $select_memo->content }}</textarea>
        </form>
        @else
        <div class="mt-3 alert alert-info">
            <i class="fas fa-info-circle"></i>メモを新規作成するか選択してください。
        </div>
        @endif
        </div>
    </div>
</div>
@endsection