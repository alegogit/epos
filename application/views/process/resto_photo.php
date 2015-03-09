<?php
  $parsed = explode(",",$varP);
  //echo "<pre>" . var_dump($parsed) . "</pre>";
  $output = $this->curl->simple_get('http://localhost/upload/');
  echo $output;
?> 