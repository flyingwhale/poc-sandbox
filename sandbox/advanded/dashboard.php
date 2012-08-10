<?php

  require_once (__DIR__."/lib/common.php");

  $db = new Dasboard;
  
  if($db->getValue('ShowPage')){
    require __DIR__.'/index.php';
  }


  $db->processForm();
  echo'<form name="form1" method="post" action="'.$_SERVER['PHP_SELF'].'" >';

  foreach ($plugins as $plugin =>$val)
  {
      $db->printCheckbox($plugin);
  }

  $db->printCheckbox('ShowPage');

  echo'<input type="submit" name="mysubmit" value="send" />';
  echo'</form>';


