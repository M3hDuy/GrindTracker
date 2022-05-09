<?php
session_start();
if (!isset($_SESSION["id"])){
  header("location:index.php");
}
require_once('connection.php');
$id = $_SESSION["id"];

$sql = "SELECT username FROM register WHERE id = '$id'";
$result = mysqli_query($conn,$sql);
$value = mysqli_fetch_assoc($result);
$username = $value["username"];

date_default_timezone_set('UTC');
$timenow = date("Y-m-d");
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="script.js" defer></script>
    <script src="Adds/chart.js"></script>
    <script src="Adds/chartjs-adapter-date-fns.bundle.min.js"></script> 
    <script src="Adds/jquery-3.6.0.js"></script>
    <script src="Adds/jspdf-1.3.4.js"></script>
    
    <link rel="stylesheet" href="style.css" />
    <title>Summary</title>
    </head>

    <div class="loader1" id="loader"></div>
    <div class="loader" id="loader"></div>
    <header id="RAS" class="main-header dark-h">
      <nav class="nav main-nav">
        <ul>
          <li><a class="nav-elements" href="profile.php">Home</a></li>
          <li><a class="nav-elements" href="#RASF1">🔻</a></li>
          <li><a class="nav-elements" href="logout.php">Logout</a></li>
        </ul>
      </nav>
      <h1 class="TitleGT TitleGT1 TitleGT1-d">GrindTracker</h1>
      </header>    

    
  <style>
      @font-face {
        font-family: Kanit;
        src: url(Fonts/Kanit-Regular.ttf);
      }
      * {
        font-family: Kanit;
        margin: 0;
        padding: 0;
      }
      .chartBody{
        background: #13151b;
      }
      .chartMenu {
        height: 80px;
        background: #181a20;
        
      }

      .chartMenu p {
        padding: 10px;
        font-size: 4vh;
        text-align: center;
        font-weight: bold;
        color:#db0a40;
        text-shadow: 0 0 0.05em #db0a40;
     }
      
      .chartCard {
        padding:40px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .chartBox {
        width: 60vw;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px #db0a40;
        background:#f8fdff;
      }
      .main-footer {
        font-size: 1.5vh;
        position: relative;
        padding:0px;
        background: #181a20;
      }
      #RASF{
        cursor: pointer;
      }
      #SendGraph{
        font-size: 1.1em;
        width: 235px;
      }
      #SendGraph:hover{
        width: 255px;
      }
      .todo-div {
      background: rgb(19 21 27) !important;
      }
      #task1 li {
        color: white ;
      }
      .listing li{
        background: #2b2f3a ;

      }
      .dark-t1 {
        font-size: 0.6em;
        color: #e2e4e9 ;
      }
      .login {
      background: linear-gradient(120deg, #181a20, #13151b) !important;
        }


      .nav a {
        display: inline-block;
        color: white !important;
      }
      .TitleGT {
        color: #db0a40;
        text-shadow: 0 0 0.025em #db0a40;
      }
      .main-header {
        background: #181a20 !important;
      }


      .TitleGT2 {
        
        color: rgb(221, 240, 255);
        text-shadow: 0 0 0.025em #db0a40;
      }
      .todosing {
        display: none;
      }
    </style>
    <script>
      const plugin = {
      id: 'custom_canvas_background_color',
      beforeDraw: (chart) => {
      const ctx = chart.canvas.getContext('2d');
      ctx.save();
      ctx.globalCompositeOperation = 'destination-over';
      ctx.fillStyle = '#f8fdff';
      ctx.fillRect(0, 0, chart.width, chart.height);
      ctx.restore();
      }
    };
    </script>

<!-- SUMMARY OF -->
  <div class="chartMenu">
     <p>Summary of <?=$username?></p>
     <p class="todosing"> TODOS </p>
    </div>


<!-- Graphs -->
<div class="chartMenu">
      <p>GRAPHS</p>
    </div>

<body class="chartBody">

<?php
    $sql = "SHOW COLUMNS FROM pr$id WHERE field != 'PrDate' AND  field != 'TODO' AND field != 'TODOADDED' AND field != 'Completed'";
    $result = mysqli_query($conn,$sql);
    while($axe = mysqli_fetch_assoc($result)) {
      $axe = $axe['Field'];
 ?>


    <div class="chartCard">
      <div class="chartBox">
        <canvas id="myChart<?=$axe?>"></canvas>
      </div>
    </div>

		<?php
      try{
        $sql1 = "SELECT PrDate,$axe FROM pr$id WHERE $axe IS NOT NULL ORDER BY PrDate";
        $result1 = mysqli_query($conn,$sql1);
        $num = mysqli_num_rows($result1);
          if($num>0){
          
          $dateArray = [];
          $AxeArray = [];
          while($value = mysqli_fetch_assoc($result1)){
            $dateArray[] = $value["PrDate"];
            $AxeArray[] = $value[$axe];
          }

        } else{
          $dateArray = [];
          $valueArray = [];
          echo "Empty.";
          }
        }
        catch(e){
          die("ERROR");
        }
        ?>

    <script>

        /*/*/
      const dateArrayJS<?=$axe?> = <?= json_encode($dateArray); ?>;
      const AxeArrayJS<?=$axe?> = <?= json_encode($AxeArray); ?>;
      const dateChartJS<?=$axe?> = dateArrayJS<?=$axe?>.map((day, index) =>{
        let dayjs = new Date(day);
        return dayjs;
      })

      // setup 
      const data<?=$axe?> = {
        labels: dateChartJS<?=$axe?>,
        datasets: [{
          label: '<?= $axe ?>',
          data: AxeArrayJS<?=$axe?>,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 3,
      tension: 0.2

        }]
      };
      /*/*/

      // config
      const config<?=$axe?> = {
        plugins: [plugin],
        type: 'line',
        data: data<?=$axe?>,
        options: {
          fill:true,
          scales: {
        x:{
          type: 'time',
          time:{
            unit: 'day'
          }
        },
            y: {
              //beginAtZero: true,
            }
          }
        }
      };

      // render init block
      const myChart<?=$axe?> = new Chart(
        document.getElementById('myChart<?=$axe?>'),
        config<?=$axe?>);
  </script>
<?php
  }
?>
<!-- TODOS -->
  <div id="lfeyda">
    <div class="chartMenu">
          <p>TODOS</p>
        </div>
        <div class="todo-div ">
        <ul id="tasks" class="listing">

        <?php
          $sql = "SELECT * from pr$id WHERE TODO IS NOT NULL ORDER BY PrDate";
          $result = mysqli_query($conn,$sql);
          while($row = mysqli_fetch_assoc($result)) {
              ?>
                  <li> 
                  <p class="todosing"> <?= $row['TODO']?> </p>
                    <?php if ($row['Completed'] == TRUE){?>
                      <input disabled type ="text" value="<?= $row['TODO']?> ";></input>
                      <span class="todosing" type ="text">Completed:</span>
                    <?php }
                  else{ ?>
                      <input readonly type ="text" value="<?= $row['TODO']?>";></input>
                      <span class="todosing" type ="text">Not Completed:</span>
                  <?php } ?>
                  
                  <smaller  id="CompleteTime" class="dark-t1" placeholder="<?= $row['PrDate']?>">&nbsp&nbsp due to: <?= $row['PrDate']?>.</smaller>
                  <small id="CreatedTime" class="dark-t1" placeholder="<?= $row['TODOADDED']?>">created: <?= $row['TODOADDED']?>.</small>
                  </li>
      
              <?php
      
          }
        ?>
        </ul>
        </div>
      <p class="todosing">Created in: <?= $timenow?>.</p>
      </div>
  </body>

  <div id="editor"></div>
  <script>
    let darkMode = localStorage.getItem("darkMode");
    if (darkMode !== "enabled") {
        document.write("<link rel='stylesheet' href='graphdarkmode.css'/>");
      }
    </script>

<!-- ACTIONS -->
  <div class="chartMenu">
      <p>ACTIONS</p>
    </div>
  <div class="content-section container login">
    <button type="button" class="button signup" id="pdfDownload" >Download<br>Summary PDF</button>
    <button type="button" class="button signup" id="pdfEmail" >Email<br>Summary PDF</button>
    </div>

	<style>
		.signup{
			width:260px;
			height:150px;
			padding:20px;
			margin:30px auto;
			font-size: 1.2em;
		}
		.signup:hover{
			width:290px;
		}
	  </style>

	<script>
    var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
    };

  $('#pdfDownload').click(function () {
    //DOWNLOAD PDF
    $("html").css("cursor", "progress");
    var doc = new jsPDF();
    doc.fromHTML($('.chartMenu').html(), 15, 15, {
          'width': 700,
          'elementHandlers': specialElementHandlers
      });
      // Convert canvas to image
      try {
      const darke = document.querySelectorAll("canvas");
      var y= 40;
      for (let i = 0; i < darke.length; i++) {
        const CanvasID = darke[i].id;
        var canvas = document.getElementById(CanvasID);
        var dataURL = canvas.toDataURL("image/jpeg", 1.0);
        doc.addImage(dataURL, 'JPEG', 12, y, 190, 95,'','FAST');
        var y = y+ 106;
        if (i % 2 != 0){
          var y= 40;
          doc.addPage();
        }
      }
    } catch (e) {
      console.log(e);
    }
      doc.addPage();
      doc.fromHTML($('#lfeyda').html(), 15, 15, {
          'width': 700,
          'elementHandlers': specialElementHandlers
      });
		//DOWNLOAD PDF
    //margins.left, // x coord   margins.top, { // y coord
    $("html").css("cursor", "default");
    doc.save('GrindTracker Summary <?= $username ?>.pdf');
    });

  
  $('#pdfEmail').click(function() {
    //EMAIL PDF
    $("html").css("cursor", "progress");
    var doc = new jsPDF();
      doc.fromHTML($('.chartMenu').html(), 15, 15, {
          'width': 700,
          'elementHandlers': specialElementHandlers
      });
      // Convert canvas to image
      try {
      const darke = document.querySelectorAll("canvas");
      var y= 40;
      for (let i = 0; i < darke.length; i++) {
        const CanvasID = darke[i].id;
        var canvas = document.getElementById(CanvasID);
        var dataURL = canvas.toDataURL("image/jpeg", 1.0);
        doc.addImage(dataURL, 'JPEG', 12, y, 190, 95,'','FAST');
        var y = y+ 106;
        if (i % 2 != 0){
          var y= 40;
          doc.addPage();
        }
      }
    } catch (e) {
      console.log(e);
    }
      doc.addPage();
      doc.fromHTML($('#lfeyda').html(), 15, 15, {
          'width': 700,
          'elementHandlers': specialElementHandlers
      });
		//DOWNLOAD PDF
    // Making Data URI
    var out = doc.output();
    var url = 'data:application/pdf;base64,' + btoa(out);

		$.ajax({
		type: "POST",
		url: "emailSummary.php",
		data: { 
		doc: url
		},
		success: function(response){ 
		alert("Summary has been sent to your email."); 
    $("html").css("cursor", "default");
		},
    error: function(response){
      alert("An error has occured."); 
    $("html").css("cursor", "default");
    }
	  }) 
	  });

	</script>

  <footer class="main-footer" id="RASF1">
      <div class="container main-footer-container">
        <!--<hr />-->
        <h3 class="TitleGT TitleGT2">GrindTracker</h3>
        <a href="#RAS" id="RASF">🔺</a>
      </div>
    </footer>
</html>

<?php
unset($username);
 ?>