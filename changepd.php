<?php
  //資料庫的帳號密碼設定
	$hostname = "localhost";
	$username = "root";	
	$password = "";
	$database = "db";
?>
<!doctype html>
<html>
<!--
  javascript:location.href
  跳轉頁面，參考 https://www.wibibi.com/info.php?tid=141
-->
<head>
	<meta charset="UTF-8" />
	<title>接單系統-重設密碼</title>
  <!-- 連結css -->
  <link rel="stylesheet" href = "CSS/index.css">  
  <!-- 設定圖標 -->
  <link rel="icon" href="icon/logo.ico">
</head>

<body bgcolor="#F6F6F6">
  <center><b>
    <div style="display:block;"><font size=7>翻譯社 - 訂單系統</font></div>
  </b></center>

  <?php
    // 抓取網址傳遞的帳戶變數
    $account = $_GET['account'];

    // 建立與MySQL資料庫的連線
    $link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8mb4', $username, $password);    
    
    if(isset($_POST['密碼1']) && isset($_POST['密碼2'])) // 資料填寫完全
    {
      if($_POST["密碼1"] != "" && $_POST["密碼2"] != "")  // 資料不為空
      {
        if($_POST["密碼1"] != $_POST["密碼2"]) // 密碼需前後一致
        {
          // 通知
          echo "<script>alert('密碼前後不相同，請重新輸入')</script>";
        }
        else
        {
          if (strlen($_POST["密碼1"]) < 6) // 密碼少於6位數
          {
            // 通知
            echo "<script>alert('密碼至少需6位')</script>";
          }
          else
          {
            // 儲存介面回傳變數
            $pd = $_POST["密碼1"];

            // 更新資料語法 
            $query = "UPDATE `sign` SET `password` = '$pd' WHERE `account` = '$account'";
            $result = $link->exec($query);
            
            // 通知
            echo "<script>alert('密碼更新完成')</script>";
            // 跳轉回sign.php
            header("refresh:0 ;url= 'sign.php'"); 
          }
        }
      }
      else
      {
        // 通知
        echo "<script>alert('密碼不得為空')</script>";
      }
    }
  ?>
  <!-- 介面 -->
  <form method="post">
    <center>
      <div class="registerdiv">
        <table>
          <tr>
            <p><b><font size=5>修改密碼</font><b /><p>
          </tr>          
          <tr>
            更新密碼：
            <input type = "password" name="密碼1" value = "">
            <p>
          </tr>
          <tr>
            確認密碼：
            <input type = "password" name="密碼2" value = "">
            <p>
            <input type = "submit" value="更新">
            &emsp;
            <input type = "reset" value="清除">   
            <p>
            <form action = "sign.php">
              <input type = "button" onclick = "javascript:location.href = 'sign.php'" value = "回到登入畫面" style="width:108px"></input>
            </from>  
          </tr>          
        </table>        
      </div>
    </center>
  </form>
</body>
</html>
