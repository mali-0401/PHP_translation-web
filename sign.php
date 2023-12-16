<?php
// 資料庫的帳號密碼設定
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db";
?>
<!doctype html>
<html>

<head>
  <meta charset="UTF-8" />
  <title>接單系統-登入</title>
  <!-- 連結css -->
  <link rel="stylesheet" href = "CSS/index.css">  
  <!-- 設定圖標 -->
  <link rel="icon" href="icon/logo.ico">
</head>

<body bgcolor="#F6F6F6">
  <p>
    <center><b>
      <div style="display:block;"><font size=7>翻譯社 - 訂單系統</font></div>
    </b></center>
    <?php
      if(isset($_POST['帳號']) && isset($_POST['密碼']))  // 帳號密碼完全
      {
        if ($_POST["帳號"] != "" && $_POST["密碼"] != "") // 帳號密碼不為空
        {
          // 建立與MySQL資料庫的連線
          $link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8mb4', $username, $password);
    
          // 儲存介面回傳變數&密碼加密
          $userid = $_POST["帳號"];
          $userpd = $_POST["密碼"];
          $password_hash = password_hash($userpd, PASSWORD_DEFAULT);   
          
          // 查詢帳戶資訊  
          $query = "SELECT * FROM `sign` WHERE `account`= '$userid'";
          $result = $link->query($query);
          // 儲存所需查詢結果
          foreach($result as $row)
          {
            $password = $row['password'];
            $type = $row['type'];
          }
          
          // 儲存查詢結果筆數
          $output   = $result -> rowCount();
          
          if ($output == 1) // 1筆帳戶匹配
          {
            if (password_verify($password, $password_hash)) // 密碼驗證成功
            {
              echo "<script>alert('登入成功')</script>";  // 帳號密碼正確     
              if($type == 0)  // 0為譯者端
              {
                header("refresh:0 ;url= 'page1_home.php?account=$userid'");  // 譯者端首頁
              }
              else
              {
                header("refresh:0 ;url= 'page2_home.php?account=$userid'");  // 管理端首頁
              }
            }
            else  //密碼驗證不成功
            {
              echo "<script>alert('密碼錯誤')</script>";  // 密碼驗證失敗
            }
          }
          else if($output == 0) //匹配筆數為0
          {
            echo "<script>alert('帳號不存在')</script>";  // 資料庫沒有這筆帳戶
          }
        }
        else
        {
          echo "<script>alert('請輸入帳號密碼')</script>";  // 未輸入帳號密碼
        }
      }
    ?>

  <!-- 介面 -->
  <form method = "post">
    <center>
      <div class = "signdiv">      
        <table>
          <tr>
            <p><b>
                <font size=5>登入</font><b />
                <p>
          </tr>
          <tr>
            帳號：
            <input type="text" name="帳號">
            <p>
          </tr>
          <tr>
            密碼：
            <input type="password" name="密碼">
            <p>
            <input type="submit" value="登入">
          </tr>
          <tr>
            <!-- 跳轉至其他頁面 -->
            <a href="register.php">
              <font size=2>註冊</font>
            </a>
            &emsp;&emsp;
            <a href="forget.php">
              <font size=2>忘記密碼</font>
            </a>
          </tr>
        </table>
      </div>
    </center>
  </form>
</body>

</html>