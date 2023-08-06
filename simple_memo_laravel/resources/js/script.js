const onChangeFileInput = (e) =>{
    if(e.target.file && e.target.file[0]){

        // FileReaderオブジェクト作成→定数readerに代入
        const reader = new FileReader();

        // onloadイベント：いつ動くのか予約している→<img>が完全に読み込まれた時に発行される。
        reader.onload = function(e){

            // getElementById:HTMLタグで指定したID（"thumbnail"）にマッチするドキュメント要素を取得するメソッド
            // setAttribute:属性を設定するメソッド
            // FileReaderのresultプロパティ:ファイルの内容を返す。
            // ファイルが読み込まれるとresultプロパティ取得
            document.getElementById('thumbnail').setAttribute('src', e.target.result);
        };

        // readAsDataURLメソッド:
        reader.readerDataURL(e.target.file[0]);
    }

};