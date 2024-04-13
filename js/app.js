// YouTubeプレーヤーを作成する関数
function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '100%',
        width: '100%',
        playerVars: {
            'autoplay': 0,  // 自動再生を無効にする
            'controls': 1,  // コントロールバーを表示する
            'modestbranding': 1,  // YouTubeロゴを非表示にする
            'rel': 0  // 関連動画を非表示にする
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// プレーヤーが準備完了したときに呼び出される関数
function onPlayerReady(event) {
    // プレーヤーが準備完了したら、ここに初期設定を行う
}

// プレーヤーの状態が変更されたときに呼び出される関数
function onPlayerStateChange(event) {
    // プレーヤーの状態が変更されたら、ここに対応する処理を記述する
}

// 複数の動画を再生する関数
function playVideos() {
    // ボタンをクリックしたらプレーヤーを表示
    document.getElementById('player').style.display = 'block';
    // 動画のIDの配列
    // sessionStorage に保存したデータを取得
    let videoIds = sessionStorage.getItem("video_id");
    // 動画を再生
    player.cuePlaylist(videoIds);
}