<?php

  $plugins[] = 'ETAG';
  $plugins[] = 'Compress';

  class Dasboard{

      const POC_SESSION_PREFIX = 'poc_';

      function __construct() {
          if(!session_id()){
              session_start();
          }
      }

      function printCheckbox($name,$text = true){
         if($text)
         {
            if($text == true)
            {
                echo $name.": ";
            }
            else
            {
                echo $text.": ";
            }
         }

         if($this->getValue($name))
         {
            $cecked = ' checked="yes" ';
         }
         else
         {
            $cecked = ' ';
         }

         echo'<INPUT TYPE="checkbox" NAME="'.$name.'" VALUE="1" '.$cecked.' > <br>';

      }

      function getValue($name){
          if(isset($_SESSION[self::POC_SESSION_PREFIX][$name]))
          {
              return $_SESSION[self::POC_SESSION_PREFIX][$name];
          }
      }

      function processForm(){
          if(isset($_POST) && !empty($_POST))
          {
            //var_dump($_POST);die();
              unset($_SESSION[self::POC_SESSION_PREFIX]);
              foreach($_POST as $key => $value)
              {
                  if($_POST[$key])
                  {
                      $_SESSION[self::POC_SESSION_PREFIX][$key] = $value;
                  }
              }
          }
      }
  }
