<?php
require (__DIR__."/lib/common.php");

  $db = new Dasboard;
  $db->processForm();
  echo'<form name="form1" method="post" action="'.$_SERVER['PHP_SELF'].'" >';

  foreach ($plugins as $plugin)
  {
      $db->printCheckbox($plugin);
  }

  echo'<input type="submit" name="mysubmit" value="send" />';
  echo'</form>';
