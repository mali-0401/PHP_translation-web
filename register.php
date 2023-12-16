<?php
  // 資料庫的帳號密碼設定
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

  radio checked
  預設勾選，參考 https://developer.mozilla.org/zh-CN/docs/Web/HTML/Element/Input/radio

  checkedbox selected
  預設勾選，參考 https://tools.wingzero.tw/article/sn/501
-->
<head>
	<meta charset="UTF-8" />
	<title>接單系統-註冊</title>
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

    if(isset($_POST['姓名']) && isset($_POST['帳號']) && isset($_POST['密碼']) && isset($_POST['email']) && isset($_POST['答案'])) // 資料填寫完全
    {
      if ($_POST["姓名"] != "" && $_POST["帳號"] != "" && $_POST["密碼"] != "" && $_POST["email"] != "" && $_POST['答案'] != "")  // 資料不為空
      {
        // 檢查是否重複帳號 
        $query = "SELECT * FROM `sign` WHERE `account`= '" .$_POST["帳號"]. "'";
        $result = $link->query($query);

        // 儲存查詢結果筆數
        $output = $result -> rowCount();

        if ($output >= 1) // 查詢結果超過一筆
        {
           // 通知
           echo "<script>alert('帳號已存在')</script>";
        }
        else
        {
          if (strlen($_POST["密碼"]) < 6) // 密碼少於6位數
          {
            // 通知
            echo "<script>alert('密碼至少需6位')</script>";
          }
          else
          {
            // 儲存介面回傳變數
            $account = $_POST['帳號'];
            $password = $_POST['密碼'];
            $name = $_POST['姓名'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $question = $_POST['questionlist'];
            $answer = $_POST['答案'];

            // 有勾選"客戶端"
            if(isset($_POST['type']))
            {              
              if(isset($_POST['key']) && $_POST['key'] == "test123") // 且有設定金鑰，金鑰正確
              {                
                //新增資料的語法
                $query = "INSERT INTO `$database`.`sign`(`account`,`password`,`name`,`email`,`gender`,`type`,`question`,`answer`,`picid`)";

                // 個別新增不同的資料(利用性別去設定預設頭像)
                if($gender == "F") // 女
                {
                  $query = $query."VALUES('$account','$password','$name','$email','$gender',1,'$question','$answer',12)";
                }
                else //男
                {
                  $query = $query."VALUES('$account','$password','$name','$email','$gender',1,'$question','$answer',18)";
                }

                // 執行新增
                $link->exec($query);

                // 通知
                echo "<script>alert('註冊成功 - 客戶端')</script>";

                // 跳轉回sign.php
                header("refresh:0 ;url= 'sign.php'");
              }
              else
              {
                // 通知
                echo "<script>alert('金鑰錯誤')</script>";
              }
            }
            else
            {
              // 新增資料的語法
              $query = "INSERT INTO `$database`.`sign`(`account`,`password`,`name`,`email`,`gender`,`type`,`question`,`answer`,`picid`)";

              // 個別新增不同的資料(利用性別去設定預設頭像)
              if($gender == "F") // 女
              {
                $query = $query."VALUES('$account','$password','$name','$email','$gender',0,'$question','$answer',12)";
              }
              else // 男
              {
                $query = $query."VALUES('$account','$password','$name','$email','$gender',0,'$question','$answer',18)";
              }

              // 執行新增
              $link->exec($query);

              // 通知
              echo "<script>alert('註冊成功 - 譯者端')</script>";    

              // 跳轉回sign.php
              header("refresh:0 ;url= 'sign.php'");      
            }
          } 
        }
      }
      else
      {
        // 通知
        echo "<script>alert('註冊資料不完全')</script>";
      }
    }    
  ?>

  <!-- 介面 -->
  <form method="post">
    <center>
      <div class="registerdiv">
        <table>
          <tr>
            <p><b><font size=5>註冊</font><b /><p>
          </tr>
          <tr>
            姓名：
            <input type="text" name="姓名" value = "" autocomplete='off'>
            <p>
          </tr>
          <tr>
            帳號：
            <input type="text" name="帳號" value = "" autocomplete='off'>
            <p>            
          </tr>
          <tr>
            密碼：
            <input type="password" name="密碼" value = "" autocomplete='off'>
            <p>
          </tr>
          <tr>
            信箱：
            <input type="text" name="email" value = "" autocomplete='off'>
            <p> 
          </tr>
        </table>
        <div>
          <label style="margin-right:36px;">設定忘記密碼的提示問題：</label>
          <br>
          <select name="questionlist" style="margin-right:70px;">
            <option value = "您的生肖？" selected>您的生肖？</option>
            <option value = "您的星座？">您的星座？</option>
            <option value = "您的國小畢業於？">您的國小畢業於？</option>
            <option value = "您有幾位兄弟姐妹？">您有幾位兄弟姐妹？</option>
            <option value = "您在學生時期的綽號？">您在學生時期的綽號？</option>
          </select>
          <p> 
          <label style="margin-right:180px;">答案：</label>
          <br>
          <input type="text" name="答案" value = "" style="margin-right:50px;" autocomplete='off'>          
          <p> 
          <div style="margin-right:95px;">
            <label>性別：</label>
            <input type = "radio" name = "gender" value = "M" checked>男 
            <input type = "radio" name = "gender" value = "F">女
          </div>
          <p>
          <input type = "checkbox" name ="type" value = "1">客戶端:金鑰
          <input type = "text" name = "key" value = "" size = 12 autocomplete = "off">
          <p>          
          <input type = "submit" value="註冊">
          &emsp;
          <input type = "reset" value="清除">   
          <p>
          <input type = "button" onclick = "javascript:location.href = 'sign.php'" value = "回到登入畫面" style="width:108px"></input>    
        </div>
      </div>
    </center>
  </form>
</body>
</html>
