<?php session_start();?>
<?php
    $mysql = mysqli_connect('localhost', 'root', '', 'comments');

    $result_s['success'] = false;
    $result_s['errors'] = 'что-то с подлючением';

    if (!$mysql) {
        $result_s['errors'] = 'Ошибка: Невозможно подключиться к MySQL ';
    }
    else{
        if($_POST['comment'] != '' && $_POST['name'] != ''&& $_POST['capcha'] !=''){
            if ($_POST['capcha'] != $_SESSION['capcha']){
                $result_s['errors'] = 'Капча неверна';
            }
            else{
                $author = $_POST['name'];
                if(strlen($author) > 60){
                    $result_s['errors']='Слишком длинное имя!';
                }
                else{
                    $message = $_POST['comment'];
                    $date = date("d-m-Y в H:i:s");
                    $sql = "INSERT INTO `comments` (`name`, `mess`, `date_time`) VALUES ('$author', '$message', '$date')";
                    $result = mysqli_query($mysql,$sql);
                    if($result == true){
                        $result_s ['success'] = true;
                        $result_s['errors']='Ваш комментарий успешно оставлен';
                    }else{ 
                    $result_s['errors']='Комментарий не отправлен. Ошибка базы данных';
                    }
                }

            }

        }
        else{
            $result_s['errors']= 'Нельзя оставлять пустые поля';
        }
        mysqli_close($mysql);
    }
    session_write_close();
    echo json_encode($result_s);
?>