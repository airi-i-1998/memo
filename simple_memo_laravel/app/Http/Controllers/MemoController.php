<?php

namespace App\Http\Controllers;

use App\Models\Memo;
// Authファサードを読み込む＝現在ログインしているユーザーの情報を取得することができる
// ファサード：メソッドを実行できるようにしてくれる機能
// ・現在認証しているユーザーのID番号を取得　$user_id = Auth::id();
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index()
    {
        $memos = Memo::where('user_id', Auth::id())
        ->where('pick_memo','=',1)
        ->orderBy('updated_at', 'desc')
        ->get();
        // dd($memos = Memo::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->toArray());
        // $memos = Memo::where('user_id', Auth::id())->orderBy('updated_at')->get();

        return view('memo',[
            'name' => $this->getLoginUserName(),
            'memos' => $memos,
            'select_memo'=>session()->get('select_memo')
    ]); 
    }

    // public function pick()
    // {
    //     $pick_1 = Memo::where('pick_memo',1)
    //     -get();
    //     return view('memo',[
    //         'pick_1'=>$pick_1,
    //     ]);

    // }

    // public function richIndex()
    // {
        // パラメータが渡ってくるのを確認したら、memoテーブルのpickmemoに対してどのように検索クエリを投げれるか調べる
    
        
        // Auth::id()の代わりにMemoテーブルのpickmemoカラムを指定する
    //     $memos = Memo::where('user_id', Auth::id())->and('pick_memo',true)->orderBy('updated_at', 'desc')->get();

    // return view('memo',[
    //     'name' => $this->getLoginUserName(),
    //     'memos' => $memos,
    //     'select_memo'=>session()->get('select_memo')
    // ]); 
    // }

    public function add()
    {
        Memo::create([
            'user_id'=> Auth::id(),
            'title'=>'新規メモ',
            'content'=>"",
            'pick_memo'=>1,
        ]);

        return redirect()->route('memo.index');
    }

    public function update(Request $request)
    {
        $memo = Memo::find($request->edit_id);
        $memo->title = $request->edit_title;
        $memo->content = $request->edit_content;

        if ($memo->update()) {
            session()->put('select_richmemo', $memo);
        } else {
            session()->remove('select_richmemo');
        }

        return redirect()->route('memo.index');
    }

    private function getLoginUserName()
    {
        $user = Auth::user();

        $name = '';
        if ($user) {
            if (7 < mb_strlen($user->name)) {
                $name = mb_substr($user->name, 0, 7) . "...";
            } else {
                $name = $user->name;
            }
        }

        return $name;

    }
    
    public function select(Request $request){

        $memo = Memo::find($request->id);
        session()->put('select_memo',$memo);

        return redirect()->route('memo.index');

    }

    public function delete(Request $request)
    {
        Memo::find($request->edit_id)->delete();
        session()->remove('select_memo');

        return redirect()->route('memo.index');
    }


}
