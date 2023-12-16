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
  <td colspan="16">
  欄位橫向合併，參考 https://www.wibibi.com/info.php?tid=HTML_Table_colspan_%E5%B1%AC%E6%80%A7
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
      $email = $row['email'];
      $gender = $row['gender'];
      $type = $row['type'];
      $picid = $row['picid'];
    } 

    if(isset($_POST['pic']) && $_POST['pic'] != "") // 資料填寫完全
    { 
      // 儲存介面回傳變數
      $picid = $_POST['pic'];
      
      // 更新資料的語法
      $query = "UPDATE `sign` SET `picid` = '$picid' WHERE `account` = '$account'";
      $result = $link->exec($query);

      // 通知
      echo "<script>alert('頭像設定成功')</script>";

      // 判斷page1_home或page2_home並跳轉info.php
      if($type == 0)
      {$str = "page1_info.php?account=".$account;}
      else{$str = "page2_info.php?account=".$account;}
      header("refresh:0 ;url= $str");
    }  
  ?>

  <!-- 介面 -->
  <p><center><b><font size = 7>翻譯社 - 訂單系統<?php if($type == 1){echo " - 管理端";}?></font></b></center><p>  
  <font size = 3><p align="right">您好， <?php echo $name;?>！
  <a href="sign.php"><button class="btexit">登出</button></a>
  &emsp;&emsp;</p></font>

  <table align="left" style="width: 14%;">
    <tr><td>
      <div class = "bookmarkdiv">
        <center>      
          <!-- 頁籤按鈕，網址附上傳遞的帳戶變數 -->
          <a href=
          <?php
          // 利用類別判斷要跳轉哪個頁面
          if($type == 0)
          {echo "page1_home.php?account=".$_GET['account'];}
          else
          {echo "page2_home.php?account=".$_GET['account'];}
          ?>
          ><button class="bt">首頁</button></a>
          <button class = "now bt">個人資料</button>  
          <?php if($type == 1)
          {       
          ?>
          <a href="page2_task.php?account=<?php echo $account;?>"><button class="bt">派發案件</button></a>  
          <a href="page2_deletetask.php?account=<?php echo $account;?>"><button class="bt">刪除案件</button></a>
          <?php
          }
          ?>       
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
            // 判斷帳戶資訊來客製化個人資訊框
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
    <center><b><font size = 5>個人資料 - 設定頭像</font></b></center>
    <center>
      <div>
      <form method="post">
        <table>
        <?php
          // 利用迴圈及數字判斷將排列頭像
          for($i=1;$i<=30;$i++)
          {
            if($i==1 || $i==9 || $i==17)
            {
              echo "<tr>";
            }                   
            if($i == $picid)
            {            
              echo "<td>$i.<input type='radio' name='pic' value=".$i." checked></td>";
            }
            else
            {
              echo "<td>$i.<input type='radio' name='pic' value=".$i."></td>";
            }
            echo "<td><img class='picimg' src='icon/$i.jpg' /></td>";
            if($i==8 || $i==16 || $i==24)
            {
              echo "</tr>";
            }
          } 
        ?>
          <tr>
            <td colspan="16">
              <center>
                <input type = "submit" value="設定">
              </center>
            </td>            
          </tr>
        </table>              
      </form>
      <a href=
      <?php
      // 利用類別判斷要跳轉哪個頁面
      if($type == 0)
      {echo "page1_info.php?account=".$account;}
      else
      {echo "page2_info.php?account=".$account;}
      ?>
      ><button class="btchange">取消設定</button></a>         
      </div>
    </center>
  </div>   
  
</body>
</html>
