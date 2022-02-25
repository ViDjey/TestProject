
<!DOCTYPE html>
<html lang = "ru">
  <head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width = device-width, user-scalable = no, initial-scale = 1.0, maximum-scale = 1.0, minimum-scale = 1.0">
    <meta http-equiv = "X-UA-Compatible" content = "ie=edge">
    <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">  <!--p>connecting to Bootstrap</p-->
    <script src = "https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script> <!--p>connecting to Vue</p-->
    <title>Тестовое задание</title>
  </head>

  <body> 
    <style type ="text/css">
      body {
      background-color: #E0FFFF;
      }
      .con{
        margin-left:300px;
        margin-right:300px;
        margin-top:60px;
        padding:24px;
      }
      .img-fluid{
        padding:20px; 
        margin-right:10px; 
        margin-bottom:10px; 
        outline:1px solid #666; 
        background:#f0f0f0; 
      }
      input[type=text] {
        padding: 15px;
        resize: vertical;
        border:0;
        border-radius:10px;
        box-shadow:10px 10px 20px rgba(0.1,0.1,0.1,0.1);
      }
      textarea{
        width:50%;
        resize: vertical;
        padding:15px;
        border-radius:15px;
        border:0;
        box-shadow:10px 10px 20px rgba(0,0,0,0.1);
        height:150px;
      }
      input[type=submit] {
        display: inline-block;
        color: #696990;
        padding: 15px;
        background-color:#ADD8E6;
        border-radius:4px;
        border: 2px solid #87CEEB;
      }
      input[type=submit]: hover{background-color: #6495ED}
      button{
        display: inline-block;
        padding: 8px;
        color: #FF0000;
        background-color:#FFFAFA;
        border-radius:0 px; 
        border: 0px; 
      }
      button: hover {background-color: #6495ED}
    </style>

      <div class = "con bg-light">
        <br><br>
        <img src="test.jpg" alt = "Моё тестовое изображение" class = "img-fluid" width = "800">
        <p>"Черный супрематический квадрат"</p>
         <p>Автор: Казимир Северинович Малевич</p><br><br> 

        <form action = "send_com.php" method = "post" id = "form">
            <textarea name = "comment" placeholder = "Поделиться своим мнением"></textarea><br>
            <input type = "text"  name = "name" placeholder = "Ваше имя"><br><br>
            <input id = "validator" type = "text" name = ":" style = "display: none;" value = "">                  <!--p>additional protection</p-->
            <img src = "captcha.php" alt = "captcha" width = "200" height = "80"/>
            <p class = "fs-5">Код, изображенный на картинке:
            <input type = "text"  name = "capcha"></p>
            <input type = "submit" name = "push_kom" value = "Добавить комментарий"><br>
        </form>
        <hr />
        <p class = "fs-3">Комментарии</p>
        <div class = "border border-3" style = "width: 85rem; padding: 24px;">
          <div id="vue"> {{push_com}}</div>
          <?php
            $mysql = mysqli_connect('localhost', 'root', '', 'comments');
            mysqli_set_charset($mysql, "utf8");
            if (!$mysql) {
              echo("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
            }
            $sql = 'SELECT * FROM `comments` ORDER BY `id` DESC';
            $result = mysqli_query($mysql, $sql);
            if ($result == false) {
              print("Произошла ошибка при выполнении запроса");
            }
            else{
              while ($req = mysqli_fetch_array($result)) {
                echo("<div class = 'text-primary fs-3 fw-bold'>" . $req['name'] . "</div><br>");
                $mess = wordwrap($req['mess'], 200, "\n", true) ;
                echo( " <div class = 'fs-4'>" . $mess. "</div><br>" . " <div class = 'text-end fw-lighter'>" . $req['date_time']. "</div><br>" );
                $id_com[] = $req['id'];
                echo('<button class = "del" name = "button" title = "Удалить" style="float: right;">X</button><br><br><hr />');
              }
              $json = json_encode($id_com);
            } 
            mysqli_close($mysql);
          ?>
        </div>
        <script>
          const form = document.querySelector('#form');
          form.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch(form.action, {
              method: form.method,
              credentials: 'same-origin',
              body: new FormData(form)
            })
            .then((response) => {
              if (response.ok){
              return response.json();}
            })
            .then((data) => {
            console.log(data);
            alert(data['errors']);
            if (data['success']) {
              form.reset();
              window.location.reload(true);}
            })
            .catch(err => console.log(err))
          })


          let del = document.querySelectorAll( ".del" );
          var but_id = JSON.parse('<?php echo $json;?>');
          for(let i = 0; i < del.length; i++){
            del[i].addEventListener('click', (e) => {
              e.preventDefault();
              var params = new URLSearchParams(); 
              params.set('button', but_id[i]);
              fetch('del_com.php', {
                method: 'POST',
                body: params,
              })
              .then((response) => {
                if (response.ok){
                return response.json();}
              })
              .then((data) => {
              console.log(data);
              alert(data['errors']);
              if (data['success']) {
                window.location.reload(true);}
              })
              .catch(err => console.log(err))
            })
          }
        </script>
  </body>
</html>
