<?php
 // Проверка на ошибки
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class SoapSmsGateWay {
//Описание функции веб-сервиса
  public function sendSms($messagesData){

      $rawPost  = "Input:\r\n";
      //Читает содержимое файла в строку
      $rawPost .= file_get_contents('php://input');
      $rawPost .= "\r\n---\r\nmessageData:\r\n";
      // генерирует хранимое представление значения.
      $rawPost .= serialize($messagesData);
      //Пишет строку $rawPost в файл log.txt
      file_put_contents("log.txt",$rawPost);

      return array("status" => "true");
  }
}
 
// Отключение кэширования WSDL-документа
ini_set("soap.wsdl_cache_enabled", "0"); // отключаем для тестирования, т.к файлы очень хорошо кешируются
// Создание SOAP-сервер
$server = new SoapServer("http://{$_SERVER['HTTP_HOST']}/smsservice.wsdl");
// Добавить класс к серверу
//$server->addFunction("getStock"); // эта функция будет видна клиенту
$server->setClass("SoapSmsGateWay"); // заменяем только эту строку
// Запуск сервера
$server->handle();
?>