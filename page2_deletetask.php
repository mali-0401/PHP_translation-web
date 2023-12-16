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
  <input type="checkbox" name="delete[]">
  checkbox命名為陣列可儲存多筆勾選資料，參考 https://matthung0807.blogspot.com/2019/09/html-input-type-checkbox.html
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
    $output = $result -> rowCount();
    foreach($result as $row)
    {
      $name = $row['name'];
      $type = $row['type'];
      $gender = $row['gender'];      
      $email = $row['email'];
      $picid = $row['picid'];
    } 
    
    // 資料填寫完全
    if(isset($_POST['delete']))
    {
      // 儲存介面回傳變數
      $deleteid = $_POST['delete'];      
      $destr = "";

      // 利用迴圈抓取需要刪除的編號
      for($i=0;$i<count($deleteid);$i++)
      {
        $destr = $destr."編號 ".$deleteid[$i]." ";
        // 刪除資料的語法
        $id = intval($deleteid[$i]);
        $query = "DELETE FROM `task` WHERE `ID` = $id";
        // 執行刪除
        $link->exec($query);
      }
      //通知
      echo "<script>alert('刪除 ".$destr."的案件')</script>";
      
      //跳轉回page2_home.php並附上帳號變數
      header("refresh:0 ;url= 'page2_home.php?account=$account'"); 
    }
  ?>

  <!-- 介面 -->
  <p><center><b><font size = 7>翻譯社 - 訂單系統 - 管理端</font></b></center><p>  
  <font size = 3><p align="right">您好， <?php echo $name;?>！
  <a href="sign.php"><button class="btexit">登出</button></a>
  &emsp;&emsp;</p></font>

  <table align="left" style="width: 14%;">
    <tr><td>
      <div class = "bookmarkdiv">
        <center>
          <!-- 頁籤按鈕，網址附上傳遞的帳戶變數 --> 
          <a href="page2_home.php?account=<?php echo $account;?>"><button class="bt">首頁</button></a>
          <a href="page2_info.php?account=<?php echo $account;?>"><button class="bt">個人資料</button></a>
          <a href="page2_task.php?account=<?php echo $account;?>"><button class="bt">派發案件</button></a>
          <button class = "now bt">刪除案件</button>            
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
  
  <form method="post">
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
        
        // 查詢客戶自己派的案件
        $query = "SELECT * FROM `task` WHERE `transclient` = '$name'";
        
        // 執行查詢
        $result = $link->query($query);
        
        // 利用table顯示
        foreach ($result as $row) {
      ?>
        <tr>
          <td><input type="checkbox" name="delete[]" value="<?php echo $row["ID"];?>"><?php echo $row["ID"];?></td>
          <td><?php echo $row["title"];?></td>
          <td><?php echo $row["text"];?></td>
          <td><?php echo $row["money"];?></td>
          <td><?php echo $row["translator"];?></td>
          <td><?php echo $row["transtext"];?></td>
          <td><b><font size = 4><?php echo $row["transclient"];?></font></b></td>
          <td><?php echo $row["date1"];?></td>
          <td><?php echo $row["date2"];?></td>
        </tr>
      <?php
      } 
      ?>        
      </table>
      <center><input type = "submit" value="刪除"></center>
    </div>
  </form>
</body>
</html>
