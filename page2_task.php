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
  <option selected="selected" disabled="disabled" style='display: none' value=''></option>
  空白選項，參考 https://www.796t.com/content/1546660623.html

  text disabled
  文字方框不輸入設定，參考 https://www.w3schools.com/tags/att_input_disabled.asp

  <input type="date">
  date資料欄位，參考 https://developer.mozilla.org/zh-CN/docs/Web/HTML/Element/Input/date
  
  <td colspan="2">
  欄位橫向合併，參考https://www.wibibi.com/info.php?tid=HTML_Table_colspan_%E5%B1%AC%E6%80%A7
-->
<head>
	<meta charset="UTF-8" />
	<title>接單系統-主畫面</title>
  <!-- 連結css -->
  <link rel="stylesheet" href = "CSS/index.css">  
  <!-- 設定圖標 -->
  <link rel="icon" href="icon/logo.ico">
</head>

<body bgcolor = "#F9F7F7">
  <?php
    // 抓取網址傳遞的帳戶變數
    $account = $_GET['account'];

    // 建立與MySQL資料庫的連線
    $link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8mb4', $username, $password);

    // 抓取帳號所需變數 
    $query = "SELECT * FROM `sign` WHERE `account`= '$account'";
    $result = $link->query($query);
    foreach($result as $row)
    {
      $name = $row['name'];
      $type = $row['type'];
      $gender = $row['gender'];      
      $email = $row['email'];
      $picid = $row['picid'];
    }
    
    // 資料填寫完全
    if(isset($_POST["title"]) && isset($_POST["text"]) && isset($_POST["money"]) && isset($_POST["translator"]) && isset($_POST["transtext"]) && isset($_POST["date1"]) && isset($_POST["date2"]))
    {      
      // 資料不為空
      if ($_POST["title"] != "" && $_POST["text"] != "" && $_POST["money"] != "" && $_POST["translator"] != "" && $_POST["transtext"] != ""&& $_POST["date1"] != "" && $_POST["date2"] != "")
      {  
        // 儲存介面回傳變數
        $title = $_POST['title'];
        $text = $_POST['text'];
        $money = $_POST['money'];
        $translator = $_POST['translator'];
        $transtext = $_POST['transtext'];
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        
        if (strtotime($date2) < strtotime($date1)) // 日期合理性判斷
        {
          //通知
          echo "<script>alert('交件日期應在派件日期之後')</script>";
        }
        else
        {
          // 插入資料的語法
          $query = "INSERT INTO `task`(`title`,`text`,`money`,`translator`,`transtext`,`transclient`,`date1`,`date2`)";
          $query = $query."VALUES('$title','$text','$money','$translator','$transtext','$name','$date1','$date2')";

          // 執行插入
          $result = $link->exec($query);

          //通知
          echo "<script>alert('案件新增成功')</script>";

          //跳轉至page2_home.php並附上帳號變數
          header("refresh:0 ;url= 'page2_home.php?account=$account'");
        }        
      }
      else
      {
        //通知
        echo "<script>alert('輸入資料不完全')</script>";
      }     
    } 
  ?>

  <!-- 介面 -->
  <p><center><b><font size = 7>翻譯社 - 訂單系統 - 管理端</font></b></center><p>  
  <font size = 3><p align="right">您好， <?php echo $name;?>！
  <a href="sign.php"><button class="btexit">登出</button></a>
  &emsp;&emsp;</p></font>

  <table align="left" style="width: 14%;">
    <tr><td>
      <!-- 頁籤方框 -->
      <div class = "bookmarkdiv">
        <center>
          <!-- 頁籤按鈕，網址附上傳遞的帳戶變數 -->
          <a href="page2_home.php?account=<?php echo $account;?>"><button class="bt">首頁</button></a>
          <a href="page2_info.php?account=<?php echo $account;?>"><button class="bt">個人資料</button></a>
          <button class = "now bt">派發案件</button>  
          <a href="page2_deletetask.php?account=<?php echo $account;?>"><button class="bt">刪除案件</button></a>
        </center>
      </div>
    </td></tr>
    <tr><td>
      <!-- 個人資訊方框 -->
      <div class = "bookmarkdiv">
        <center>
          <img class="picimg" src="icon/<?php echo $picid;?>.jpg">
          <br>
          <?php 
            //判斷帳戶資訊來客製化個人資訊框
            if($type == 0)
            {echo "譯者 - ";}
            else
            {echo "客戶 - ";}
            echo $name;
            if($gender == "M")
            {echo "<img src='icon/Male-icon.png' /><br>";}
            else
            {echo "<img src='icon/Female-icon.png' /><br>";}
            echo $email;
          ?>
        </center>
      </div>
    </td></tr>
  </table>  
  
  <!-- 主頁方框 -->
  <div class = "maindiv">
    <center><b><font size = 5>派發案件</font></b></center>
    <form method="post">
      <center>
        <table>
          <tr>
            <td width="100px">案件名稱：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="text" name="title" value = "" autocomplete='off'>
            </td>
          </tr>
          <tr>
            <td width="100px">案件內容：</td>
            <td width="100px" bgcolor="#F4FCD9">
            <textarea rows="6" cols="40" name="text"></textarea>
            </td>
          </tr>
          <tr>
            <td width="100px">派發稿費：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="number" name="money" value = "" autocomplete='off'>
            </td>
          </tr>
          <tr>
            <td width="100px">負責譯者：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <select name="translator">                
                <option selected="selected" disabled="disabled" style='display: none' value=''></option>
                <?php
                  // 從資料庫抓取譯者資料 
                  $query = "SELECT * FROM `sign` WHERE `type`= 0";
                  $result = $link->query($query);
                  foreach($result as $row)
                  {
                    $translator = $row['name'];
                    echo "<option value = '" .$translator. "'>" .$translator. "</option>";
                  }
                ?>               
              </select>  
            </td>
          </tr>
          <tr>
            <td width="100px">負責範圍：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <textarea rows="6" cols="40" name="transtext"></textarea>
            </td>
          </tr>  
          <tr>
            <td width="100px">派件客戶：</td>
            <td width="100px">
              <input type="text" name="transclient" value = "<?php echo $name;?>" autocomplete='off' disabled> 
            </td>          
          </tr>
          <tr>
            <td width="100px">派件日期：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="date" name="date1" value = "" autocomplete='off'> 
            </td>
          </tr>
          <tr>
            <td width="100px">交件日期：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="date" name="date2" value = "" autocomplete='off'> 
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <center>
                <input type = "submit" value="新增">
                &emsp;
                <input type = "reset" value="復原">
              </center>
            </td>            
          </tr>
        </table>
      </center>     
    </form>
  </div>
</body>
</html>
