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
  
  radio checked
  預設勾選，參考 https://developer.mozilla.org/zh-CN/docs/Web/HTML/Element/Input/radio

  checkedbox selected
  預設勾選，參考 https://tools.wingzero.tw/article/sn/501
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
    // 建立與MySQL資料庫的連線
    $link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8mb4', $username, $password);

    // 抓取網址傳遞的帳戶變數
    $oldaccount = $_GET['account'];

    // 查詢舊帳戶資訊
    $query = "SELECT * FROM `sign` WHERE `account`= '$oldaccount'";
    $result = $link->query($query);

    // 儲存各欄位
    foreach($result as $row)
    {
      $name = $row['name'];
      $email = $row['email'];
      $gender = $row['gender'];
      $type = $row['type'];
      $question = $row['question'];
      $answer = $row['answer'];
      $picid = $row['picid'];
    }

    if(isset($_POST['帳號']) && isset($_POST['姓名']) && isset($_POST['email']) && isset($_POST['答案'])) // 資料填寫完全
    {      
      if ($_POST["帳號"] != "" && $_POST["姓名"] != "" && $_POST["email"] != "" && $_POST['答案'] != "")  // 資料不為空
      {               
        // 儲存介面回傳變數 
        $account = $_POST['帳號'];
        $name = $_POST['姓名'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $question = $_POST['questionlist'];
        $answer = $_POST['答案'];
        
        // 更新資料的語法
        $query = "UPDATE `sign` SET `account` = '$account',`name` = '$name',`email` = '$email',`gender` = '$gender',";
        $query = $query."`question` = '$question',`answer` = '$answer' WHERE `account` = '$oldaccount'";
        $result = $link->exec($query);

        // 通知
        echo "<script>alert('資料修改成功')</script>";

        // 判斷page1_home或page2_home並跳轉.php
        if($type == 0)
        {$str = "page1_home.php?account=".$account;}
        else{$str = "page2_home.php?account=".$account;}
        header("refresh:0 ;url= $str");
      }
      else
      {
        // 通知
        echo "<script>alert('輸入資料不完全')</script>";
      }
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
    <center><b><font size = 5>個人資料 - 修改資料</font></b></center>
    <center>
      <div>
      <form method="post">
        <table>
          <tr>
            <td width="100px">帳號：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="text" name="帳號" value = "<?php echo $oldaccount;?>" autocomplete='off'>
            </td>
          </tr>
          <tr>
            <td width="100px">姓名：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="text" name="姓名" value = "<?php echo $name;?>" autocomplete='off'>
            </td>
          </tr>
          <tr>
            <td width="100px">信箱：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="text" name="email" value = "<?php echo $email;?>" autocomplete='off'>
            </td>
          </tr>
          <tr>
            <td width="100px">性別：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type = "radio" name = "gender" value = "M" <?php if($gender == "M"){echo "checked";}?>>男 
              <input type = "radio" name = "gender" value = "F" <?php if($gender == "F"){echo "checked";}?>>女
            </td>
          </tr>
          <tr>
            <td width="100px">身分：</td>
            <td width="100px"><?php if($type == 0){echo "譯者";}else{echo "客戶";}?></td>
          </tr>  
          <tr>
            <td witdh="100px">提示問題：</td>
            <td width="100px" bgcolor="#F4FCD9">
            <select name="questionlist" style="margin-right:70px;">
              <option value = "您的生肖？" <?php if($question == "您的生肖？"){echo "selected";}?>>您的生肖？</option>
              <option value = "您的星座？" <?php if($question == "您的星座？"){echo "selected";}?>>您的星座？</option>
              <option value = "您的國小畢業於？" <?php if($question == "您的國小畢業於？"){echo "selected";}?>>您的國小畢業於？</option>
              <option value = "您有幾位兄弟姐妹？" <?php if($question == "您有幾位兄弟姐妹"){echo "selected";}?>>您有幾位兄弟姐妹？</option>
              <option value = "您在學生時期的綽號？"> <?php if($question == "您在學生時期的綽號？"){echo "selected";}?>您在學生時期的綽號？</option>
            </select>
            </td>          
          </tr>
          <tr>
            <td witdh="100px">答案：</td>
            <td width="100px" bgcolor="#F4FCD9">
              <input type="text" name="答案" value = "<?php echo $answer;?>" autocomplete='off'>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <center>
                <input type = "submit" value="修改">
                &emsp;
                <input type = "reset" value="復原">
              </center>
            </td>            
          </tr>
        </table> 
      </form>
      <a href=<?php
      if($type == 0)
      // 利用類別判斷要跳轉哪個頁面
      {echo "page1_info.php?account=".$oldaccount;}
      else
      {echo "page2_info.php?account=".$oldaccount;}
      ?>
      ><button class="btchange">取消修改</button></a>         
      </div>
    </center>
  </div>   
  
</body>
</html>
