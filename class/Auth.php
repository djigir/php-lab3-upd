<?php
session_start();

require_once 'Database.php';

$login = $_POST['login'];

$pass = $_POST['pass'];

    class Auth
    {

        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        public function setSessionValue($login) {
            $_SESSION['login'] = $login;
        }

        public function auth($login, $pass) {

            $user = $this->db->getRow("SELECT * FROM users WHERE login = ? AND password = ?", ["$login", "$pass"]);

            if  ($user) {

                $this->setSessionValue($user['login']);

                if ($user['role'] == 3) {

                    header("Location: /lab3/view/admin.php");

                }elseif ($user['role'] == 2) {

                    header("Location: /lab3/view/manager.php");

                }elseif ($user['role'] == 1) {

                    header("Location: /lab3/view/client.php");
                }
            }
        }


        public function out() {
            $_SESSION = array(); //Очищаем сессию
            session_destroy(); //Уничтожаем
        }
    }


$auth = new Auth();

if (isset($login) && isset($pass)) { //Если логин и пароль были отправлены
   $auth->auth($login, $pass);

}

if (isset($_GET["exit"])) { //Если нажата кнопка выхода
    if ($_GET["exit"] == true) {
        $auth->out(); //Выходим
        header("Location: ../login.php"); //Редирект после выхода
    }
}

$users = $db->getRows("SELECT * FROM users"); // получаю все данные о пользователе из БД для привествия


