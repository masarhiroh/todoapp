<?php
if (isset($_POST['query']) === TRUE) {
    $query  = htmlspecialchars($_POST['query'], ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>スーパーグローバル変数使用例</title>
</head>
<body>
    <h1>検索しよう</h1>
<?php
    // formから検索文字列が渡ってきている場合はGoogleへのリンクを表示
    if (isset($query) === TRUE) {
?>
    <a href="https://www.google.co.jp/search?q=<?= $query; ?>" target="_blank">「<?= $query; ?>」をGoogleで検索する</a><br>
    <a href="http://www.bing.com/search?q=<?= $query; ?>" target="_blank">「<?= $query; ?>」をbingで検索する</a><br>
    <a href="http://search.yahoo.co.jp/search?p=<?= $query; ?>" target="_blank">「<?= $query; ?>」をyahooで検索する</a><br>
    <p>このページをブックマークしてみましょう。<br>ブックマークからこのページにアクセスしても同じページが表示されます</p>
<?php
    }
?>
    <!-- 検索文字列送信用フォーム -->
    <form method="post">
        <input type="text" name="query" value="<?php if (isset($query) === TRUE) { print $query; } ?>">
        <input type="submit" value="送信">
    </form>
</body>
</html>