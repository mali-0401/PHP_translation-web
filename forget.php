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
  autocomplete='off'
  取消自動帶入，參考 https://www.vnewin.com/html-input-autocomplete-off/

  javascript:location.href
  跳轉頁面，參考 https://www.wibibi.com/info.php?tid=141
-->
<head>
	<meta charset="UTF-8" />
	<title>接單系統-忘記密碼</title>
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
    // 建立與MySQL資料庫的連線
    $link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8mb4', $username, $password);
    
    // 建立變數
    $bool = FALSE;
    $answer = "";

    if(isset($_POST['帳號']) && isset($_POST['email'])) // 資料填寫完全
    {
      if ($_POST["帳號"] != "" && $_POST["email"] != "")  // 資料不為空
      {
        // 儲存介面回傳變數
        $a = $_POST["帳號"];
        $e = $_POST["email"];

        // 檢查帳號是否存在 
        $query = "SELECT * FROM `sign` WHERE `account`= '" .$a. "' AND `email`= '" .$e. "'";
        $result = $link->query($query);
        $output = $result -> rowCount();
        if ($output == 1) // 帳號存在且匹配
        {
          // 抓取帳號所需變數
          foreach($result as $row)
          {
            $question = $row['question'];
            $answer = $row['answer'];
            $account = $row['account'];
          }
          $bool = TRUE;

          // 列印身分驗證表單
          echo "<form method='post'>"."<center>"."<div class='forgetdiv'>";
          echo "<table>";
          echo "<tr>"."<p><b><font size=5>身分驗證</font><b /><p>"."請針對註冊時選填的提示問題回答答案："."</tr>";
          echo "<tr>"."問題："."<input type='text' name='問題' value = '$row[question]' disabled>"."<p>"."</tr>";         
          echo "<tr>"."答案："."<input type='text' name='答案' value = '' autocomplete='off'>"."<p>"."</tr>";
          echo "<input type='hidden' name='answer' value = '$answer' >";       
          echo "<input type='hidden' name='account' value = '$account' >";   
          echo "<tr>"."<input type = 'submit' value='確認'>"."&emsp;";
          echo "<input type = 'reset' value='清除'>"."<p>"."</tr>";
          echo "<input type = 'button' onclick = 'javascript:location.href = 'sign.php'' value = '回到登入畫面' style='width:108px'></input>"."</from>";
          echo "</table>";
          echo "</div>"."</center>"."</form>";
        }
        else
        {
          // 通知
          echo "<script>alert('此帳號或信箱有誤，請再試一次')</script>";
        }
      }
      else
      {
        // 通知
        echo "<script>alert('輸入資料不完全')</script>";
      }
    }
    else if(isset($_POST['答案']) && $_POST['答案'] != "") //資料填寫完全且不為空
    {
      // 儲存介面回傳變數
      $userans = $_POST['答案'];
      $answer = $_POST['answer'];
      $account = $_POST['account'];
      if($userans == $answer)
      {
        //通知
        echo "<script>alert('身分驗證成功！')</script>";

        // 跳轉至changepd.php並附上帳號變數
        header("refresh:0 ;url= 'changepd.php?account=$account'");
      }
      else
      {
        // 通知
        echo "<script>alert('答案不正確！')</script>";
      }
    }
    else if(isset($_POST['答案']) && $_POST['答案'] == "")
    {
      // 通知
      echo "<script>alert('請輸入答案！')</script>";
      
    }   
  ?>
  
  <!-- 介面-->
  <?php
    if($bool == FALSE)
    {
      echo "<form method='post'>"."<center>"."<div class='forgetdiv'>";
      echo "<table>";
      echo "<tr>"."<p><b><font size=5>忘記密碼</font><b/><p>"."請輸入您的帳號與註冊時的信箱"."</tr>";
      echo "<tr>"."帳號："."<input type='text' name='帳號' value = '' autocomplete='off'>"."<p>"."</tr>";  
      echo "<tr>"."信箱："."<input type='text' name='email' value = '' autocomplete='off'>"."<p>"."</tr>";
      echo "<tr>"."<input type = 'submit' value='確認'>"."&emsp;";      
      echo "<input type = 'reset' value='清除'>"."<p>"."</tr>";      
      echo "</table>";
  ?>
      <input type = "button" onclick = "javascript:location.href = 'sign.php'" value = "回到登入畫面" style="width:108px"></input>
  <?php
      echo "</div>"."</center>"."</form>";
    }  
  ?>
  
</body>
</html>
