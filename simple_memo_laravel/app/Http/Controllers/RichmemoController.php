<?php

namespace App\Http\Controllers;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RichmemoController extends Controller
{
    public function index()
    {
        $richmemos =Memo::where('user_id',Auth::id())
        ->where('pick_memo',2)
        ->orderBy('updated_at','desc')
        ->get();
        return view('richmemo',[
            'name' => $this->getLoginUserName(),
            'richmemos' => $richmemos,
            'select_memo'=>session()->get('select_memo')
        ]);

    }

    // メモの追加
    public function add()
    {
        Memo::create([
        'user_id'=>Auth::id(),
        'title'=>'新規メモ',
        'content'=>"",
        'pick_memo'=>2,
        ]);

        return redirect()->route('richmemo.index');
    }

    // ログインユーザー名取得
    public function getLoginUserName()
    {
        // ①現在認証しているユーザーを情報を取得
        $user=Auth::user();
        // ②ユーザー情報が取得できたら、ユーザーの名前を$nameに代入する
        $name="";
        if($name){
            // ７文字以上の場合、０〜７文字分の名前を取得し、超えた分は”。。。”で表示する
            if(7<mb_strlen($user->name)){
                $name = mb_substr($user->name,0,7)."...";
            }else{
                // そうでなければ、ユーザーの名前をそのまま取得する
                $name = $user->name;
            }
        }

    }

    // メモ選択機能
    public function select(Request $request)
    {
        $richmemo = Memo::find($request->id);
        // ユーザー情報を保持する
        session()->put('select_memo',$richmemo);

        return redirect()->route('richmemo.index');

    }

    // メモの更新
    public function update(Request $request)
    {
        $richmemo = Memo::find($request->edit_id);
        $richmemo->title = $request->edit_title;
        $richmemo->content = $request->edit_content;

        if($richmemo->update()){
            session()->put('select_memo', $memo);
        }else {
            session()->remove('select_memo');
    }

    return redirect()->route('richmemo.index');
    }

    public function delete(Request $request)
    {
        Memo::find($request->edit_id)->delete();
        session()->remove('select_memo');

        return redirect()->route('richmemo.index');
    }

    
        
}
    
