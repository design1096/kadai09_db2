<?php
//1. DB接続
include("funcs.php");
$pdo = db_conn_local();

//2. SQL作成
$sql = "SELECT * FROM free_bgm;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if ($status==false) {
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}

//4. 全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($values,JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Let's make a playlist!</title>
</head>
<body>
    <div class="container">
        <!-- 左エリア -->
        <div class="left-section">
            <div class="title_h2">
                <h2>Let's make a playlist!</h2>
            </div>
            <!-- 一覧テーブル -->
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>YouTube URL</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 更新 -->
                    <?php foreach($values as $v){ ?>
                        <tr>
                            <td class="txt_center"><?=$v["id"]?></td>
                            <td>
                                <form method="POST" action="update.php">
                                <input type="text" placeholder="Title" name="title" value='<?=$v["title"]?>'>
                            </td>
                            <td>
                                <input type="text" placeholder="YouTube URL" name="url" value='<?=$v["url"]?>'>
                            </td>
                            <td class="txt_center">
                                    <input type="hidden" name="id" value=<?=$v["id"]?>>
                                    <button type="submit" class="btn btn-update">Update</button>
                                </form>
                                <form method="GET" action="delete.php">
                                    <input type="hidden" name="id" value=<?=$v["id"]?>>
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>                         
                            </td>
                        </tr>
                    <?php } ?>
                    <!-- 登録 -->
                    <tr>
                        <td></td>
                        <form method="POST" action="insert.php">
                            <td>
                                <input type="text" placeholder="Title" name="title" value="">
                            </td>
                            <td>
                                <input type="text" placeholder="YouTube URL" name="url" value="">
                            </td>
                            <td class="txt_center">
                                <button type="submit" class="btn btn-register">Register</button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
            <!-- プレイリスト作成ボタン -->
            <div class="playlist_btn_area">
                <button type="button" class="btn2 btn-playlist" onclick="playVideos()">Let's Listen!</button>
            </div>
        </div>
        <!-- 右エリア -->
        <div class="right-section">
            <div id="player" style="display: none;"></div>
        </div>
    </div>
    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="js/app.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script>
        const list = '<?php echo $json; ?>';
        const list_obj = JSON.parse(list);
        // Video ID 取得
        let videoId_list = new Array();
        let url_str = "";
        let target = "";
        let cut = "";
        let video_id = "";
        for (let i = 0; i < list_obj.length; i++) {
            url_str = list_obj[i].url;
            target = url_str.indexOf('?v=');
            cut = url_str.substring(target);
            video_id = cut.replace("?v=", "");
            videoId_list.push(video_id);
        }
        // sessionStorage にデータを保存
        sessionStorage.setItem("video_id", videoId_list);
    </script>
</body>
</html>