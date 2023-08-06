<?php

namespace App\Http\Controllers;
use App\Models\Memo;
use App\Models\Image;
use App\Enums\MemoType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class RichmemoController extends Controller
{
    public function index()
    {
        $richmemo = Memo::where('user_id', '=', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->where('pick_memo',MemoType::RICHMEMO)
        ->first();
        
        $image = Image::where('memo_id','=',$richmemo->id)
        ->first();
        
        if ($richmemo) {
            session()->put('select_memo', $richmemo);
        }
        
        if ($image) {
            session()->put('select_image', $image);
        }else{
            session()->put('select_image', '');
        }

        $richmemos =Memo::where('user_id',Auth::id())
        ->where('pick_memo',MemoType::RICHMEMO)
        ->orderBy('updated_at','desc')
        ->get();
        return view('richmemo',[
            'name' => $this->getLoginUserName(),
            'richmemos' => $richmemos,
            'select_memo'=>session()->get('select_memo'),
            'select_image'=>session()->get('select_image'),

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
        
        // return view('richmemo',[
        //     'name' => $this->getLoginUserName(),
        //     'richmemos' => $richmemos,
        //     'select_memo'=>session()->get('select_memo'),
        //     'select_image'=>session()->get('select_image'),
        // ]);
    }

    // ログインユーザー名取得
    private function getLoginUserName()
    {
        // ①現在認証しているユーザーを情報を取得
        $user = Auth::user();
        // ②ユーザー情報が取得できたら、ユーザーの名前を$nameに代入する
        $name = '';
        if($user){
            // ７文字以上の場合、０〜７文字分の名前を取得し、超えた分は”。。。”で表示する
            if(7<mb_strlen($user->name)){
                $name = mb_substr($user->name,0,7) . "...";
            }else{
                // そうでなければ、ユーザーの名前をそのまま取得する
                $name = $user->name;
            }
        }
        return $name;
    }

    // メモ選択
    public function select(Request $request)
    {
        $richmemo = Memo::find($request->id);
        $image = Image::where('memo_id','=',$richmemo->id)
        ->first();
        // ユーザー情報を保存する
        session()->put('select_memo',$richmemo);
        session()->put('select_image',$image);

        // logger()->debug('============================');
        // logger()->debug($image);

        // return redirect()->route('richmemo.index');
        
        $richmemos =Memo::where('user_id',Auth::id())
        ->where('pick_memo',MemoType::RICHMEMO)
        ->orderBy('updated_at','desc')
        ->get();
        return view('richmemo',[
            'name' => $this->getLoginUserName(),
            'richmemos' => $richmemos,
            'select_memo'=>session()->get('select_memo'),
            'select_image'=>session()->get('select_image'),
        ]);

    }

    // メモの更新
    public function update(Request $request)
    {
        $richmemo = Memo::find($request->edit_id);
        $richmemo->title = $request->edit_title;
        $richmemo->content = $request->edit_content;
        if($richmemo->update()){
            session()->put('select_memo', $richmemo);
        }else {
            session()->remove('select_memo');
        }

        logger()->debug('============================');
        logger()->debug($request);

         // ディレクトリ名
        $dir = 'img';
        
        // アップロードされたファイル名を取得
        // 条件つけるのここ！！
        $file_name = $request->file('image')->getClientOriginalName();
        // imgディクトリを作成し画像を保存
        // storage/app/public/img
        $files = $request->file('image')->storeAs('public/' . $dir,$file_name);

        // ファイル情報をDBに保存
        // Imageインスタンス作成
        $image = new Image();
        // $imageに持たせたい情報
        $image->memo_id = $request->edit_id;
        $image->name = $file_name;
        $image->path = 'storage/' . $dir . '/' . $file_name;
        if($image->save()){
            session()->put('select_image', $image);
        }else {
            session()->remove('select_image');
        }
      

        logger()->debug('============================');
        logger()->debug($image);

        // ユーザー情報保持
        session()->put('select_memo', $richmemo);
        session()->put('select_image', $image);

    return redirect()->route('richmemo.index');
    }

    // データ削除
    public function delete(Request $request)
    {
        Memo::find($request->edit_id)->delete();
        session()->remove('select_memo');

        return redirect()->route('richmemo.index');
    }
    
    // 画像ファイルのみ削除
    public function deleted_at(Request $request)
    {
        $richmemo = Memo::find($request->edit_id);
        $richmemo->title = $request->edit_title;
        $richmemo->content = $request->edit_content;

        Image::find($request->edit_id)->delete();
        \Storage::disk('public')->delete('$path');

        session()->put('select_memo', $richmemo);
        session()->remove('select_image');

        return redirect()->route('richmemo.index');
    }

    
}
    
