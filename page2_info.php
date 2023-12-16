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
  ?>

  <!-- 介面-->
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
          <a href="page2_home.php?account=<?php echo $_GET['account'];?>"><button class="bt">首頁</button></a>
          <button class = "now bt">個人資料</button>
          <a href="page2_task.php?account=<?php echo $account;?>"><button class="bt">派發案件</button></a>  
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
    <center><b><font size = 5>個人資料</font></b></center>
    <center>
      <div>
        <table>
          <tr>
            <th width="100px">頭像：</th>
            <td width="100px"><img class="picimg" src="icon/<?php echo $picid;?>.jpg"></td>
            <!-- 跳轉至設定頭像頁面，網址附上傳遞的帳戶變數-->
            <td><a href="page_changepic.php?account=<?php echo $account;?>"><button class="btchange">設定頭像</button></a></td>
          </tr>
          <tr>
            <th width="100px">帳號：</th>
            <td width="100px"><?php echo $account;?></td>
          </tr>
          <tr>
            <th width="100px">姓名：</th>
            <td width="100px"><?php echo $name;?></td>
          </tr>
          <tr>
            <th width="100px">信箱：</th>
            <td width="100px"><?php echo $email;?></td>
          </tr>
          <tr>
            <th width="100px">性別：</th>
            <td width="100px"><?php if($gender == "M"){echo "男性&emsp;&emsp;"."<img src='icon/Male-icon.png' />";}else{echo "女性&emsp;&emsp;"."<img src='icon/Female-icon.png' />";}?></th>
          </tr>  
          <tr>
            <th width="100px">身分：</th>
            <td width="100px"><?php if($type == 0){echo "譯者";}else{echo "客戶";}?></td>
          </tr>  
        </table>
        <!-- 跳轉至修改資料頁面，網址附上傳遞的帳戶變數-->
        <a href="page_changeingfo.php?account=<?php echo $account;?>"><button class="btchange">修改資料</button></a>
      </div>
    </center>
  </div>
</body>
</html>
