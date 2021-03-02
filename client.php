<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Заготовки объектов
class Message{
  public $phone;
  public $text;
  public $date;
  public $type;
}

class MessageList{
  public $message;
}

class Request{
  public $messageList;
}


// создаем объект для отправки на сервер
$req = new Request();
$req->messageList = new MessageList();
$req->messageList->message = new Message();
$req->messageList->message->phone = $_POST['phoneHtml'];
$req->messageList->message->text = $_POST['textHtml'];
$req->messageList->message->date = date("H:i:s m.d.y.");;

$req->messageList->message->type = $_POST['typeHtml'];

try {
  // Создание SOAP-клиента
  $client = new SoapClient("http://{$_SERVER['HTTP_HOST']}/smsservice.wsdl"); 
  // Посылка SOAP-запроса c получением результат
  $result = $client->sendSms($req);
  var_dump($result);
  print_r($result);
} catch (SoapFault $exception) {
  echo $exception->getMessage(); 
}
?>
