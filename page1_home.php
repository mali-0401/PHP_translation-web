<?php
  //資料庫的帳號密碼設定
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
      $type = $row['type'];
      $gender = $row['gender'];      
      $email = $row['email'];
      $picid = $row['picid'];
    } 
  ?>

  <!-- 介面 -->
  <p><center><b><font size = 7>翻譯社 - 訂單系統</font></b></center><p>  
  <font size = 3><p align="right">您好， <?php echo $name;?>！
  <a href="sign.php"><button class="btexit">登出</button></a>
  &emsp;&emsp;</p></font>

  <table align="left" style="width: 14%;">
    <tr><td>
      <!-- 頁籤方框 -->
      <div class = "bookmarkdiv">
        <center>      
          <!-- 頁籤按鈕，網址附上傳遞的帳戶變數 -->
          <button class = "now bt">首頁</button>
          <a href="page1_info.php?account=<?php echo $account;?>"><button class="bt">個人資料</button></a>   
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
    <center><b><font size = 5>首頁</font></b></center>
    <center>
      <table cellspacing="0" border="1">
        <tr class="tasktr">
          <td width=80px>案件編號</td>
          <td width=200px>案件名稱</td>
          <td width=200px>案件內容</td>
          <td width=80px>派發稿費</td>
          <td width=80px>負責譯者</td>
          <td width=200px>負責範圍</td>
          <td width=80px>派件客戶</td>
          <td width=80px>派件日期</td>
          <td width=80px>交件日期</td>
        </tr>
      
    </center>
    <?php
			// 建立與MySQL資料庫的連線
			$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8mb4', $username, $password);
      
      // 查詢使用者的案件
			$query = "SELECT * FROM `task` WHERE `translator` = '$name'";
      
      // 執行查詢
			$result = $link->query($query);
      
      // 利用table顯示
			foreach ($result as $row) {
    ?>
      <tr>
        <td><?php echo $row["ID"];?></td>
        <td><?php echo $row["title"];?></td>
        <td><?php echo $row["text"];?></td>
        <td><?php echo $row["money"];?></td>
        <td><b><font size = 4><?php echo $row["translator"];?></font></b></td>
        <td><?php echo $row["transtext"];?></td>
        <td><?php echo $row["transclient"];?></td>
        <td><?php echo $row["date1"];?></td>
        <td><?php echo $row["date2"];?></td>
      </tr>
    <?php
     } 
    ?>
		</table>
  </div>
</body>
</html>
