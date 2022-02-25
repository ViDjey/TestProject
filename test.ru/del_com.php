<?php
  $mysql = mysqli_connect('localhost', 'root', '', 'comments');

  $result_s['success'] = false;
  $result_s['errors']='что-то с подлючением';
  $id_del=$_POST['button'];

  if (!$mysql) {
      $result_s['errors']='Ошибка: Невозможно подключиться к MySQL ';
  }

  $sql = "DELETE FROM `comments` WHERE id='$id_del'";
  $result = mysqli_query($mysql,$sql);
  if($result == true){
    $result_s ['success'] = true;
    $result_s['errors']='Ваш комментарий успешно удален';
  }else{ 
    $result_s['errors']='Комментарий не удален. Ошибка базы данных';
  }
  mysqli_close($mysql);
  echo json_encode($result_s);
?>