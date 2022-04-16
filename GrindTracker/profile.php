<!--Session-->
<?php 
  session_start();
if (!isset($_SESSION["username"])){

  header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <script src="script.js" defer></script>
    <script src="profile.js" defer></script>
    <title weight="normal">GrindTracker 🔺| Profile</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="style.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="GrindTracker is a tool that let you keep track of your progress and
    visualise them to better grind your way up reaching your desired
    goals."
    />
  </head>
  <body>
    <header id="RAS" class="main-header dark-h">
      <nav class="nav main-nav">
        <ul>
          <li><a class="nav-elements" href="#RAS">Home</a></li>
          <li><a class="nav-elements" href="logout.php">Logout</a></li>
          <li>
            <label class="switch">
              <input type="checkbox" id="checkbox" />
              <span class="slider"></span>
            </label>
          </li>
        </ul>
      </nav>
      <!--<hr /> -->
      <h1 class="TitleGT TitleGT1 TitleGT1-d">GrindTracker</h1>
    </header>

    <!--load php maghyr refresh lel page; ajax?-->
    <div class="vars">
      <ul class="listing">
        <li>
          <input type="number" placeholder="weight" id="weight" name="weight" />
          <button class="button BtnS" onclick="GRAPHvar()">📈</button>
        </li>

        <li>
          <input type="number" placeholder="height" id="height" name="height" />
          <button class="button BtnS" onclick="GRAPHvar()">📈</button>
        </li>

        <li>
          <input
            type="number"
            placeholder="benchMAX"
            id="benchMAX"
            name="benchMAX"
          />
          <button class="button BtnS" onclick="GRAPHvar()">📈</button>
        </li>
      </ul>
      <button id="Settings" class="button BtnS" onclick="DisplaySettings()">
        ⚙️
      </button>
      <button id="Verify" class="button BtnS" onclick="Verify()">✔️</button>
    </div>

    <div class="vars Settings">
      <ul id="listing" class="listing">
        <li>
          <input type="number" placeholder="weight" id="weight" name="weight" />
          <button class="button BtnS" onclick="DELETEvar(this)">❌</button>
        </li>

        <li>
          <input type="number" placeholder="height" id="height" name="height" />
          <button class="button BtnS" onclick="DELETEvar(this);">❌</button>
        </li>

        <li>
          <input
            type="number"
            placeholder="benchMAX"
            id="benchMAX"
            name="benchMAX"
          />
          <button id="#test" class="button BtnS" onclick="DELETEvar(this)">
            ❌
          </button>
        </li>

        <li id="ADD1button">
          <button class="button BtnS" onclick="ADDvar()">➕</button>
        </li>
      </ul>
      <button id="Settings" class="button BtnS" onclick="DisplaySettings()">
        ⚙️
      </button>
      <button id="Verify" class="button BtnS" onclick="Verify()">✔️</button>
    </div>

    <div>
      <input type="date" value="today" id="calendar" name="calendar" required />
      <!--http://jsfiddle.net/trixta/cc7Rt/-->
      <i id="timenow"></i>
    </div>

    <div class="todo-div">
      <!--https://youtu.be/Ttf3CEsEwMQ-->

      <header class="todo-head">
        <h2 class="section-header dark-t">TODO:</h2>
      </header>

      <form class="todo-form">
        <div class="listing">
          <input type="text" class="todo-input" />
          <button class="todo-button button BtnS" type="submit">➕</button>
        </div>

        <div class="select">
          <select name="todos" class="filter-todo">
            <option value="all ">All</option>
            <option value="completed">Completed</option>
            <option value="uncompleted">Uncompleted</option>
          </select>
        </div>
      </form>

      <div class="todo-container">
        <ul class="todo-list"></ul>
      </div>
    </div>

    <footer class="main-footer">
      <div class="container main-footer-container">
        <!--<hr />-->
        <h3 class="TitleGT TitleGT2">GrindTracker</h3>
        <a href="#RAS" id="RASF">🔺</a>
      </div>
    </footer>
  </body>
</html>