<?php
  $parsed = explode(",",$varP);
  //echo "<pre>" . var_dump($parsed) . "</pre>";
  $output = $this->process->update_printer($parsed);
  echo $output;
?> 