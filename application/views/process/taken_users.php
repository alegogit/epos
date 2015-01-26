<?php
  $parsed = $varP;
  //echo "<pre>" . var_dump($parsed) . "</pre>";
  $output = $this->process->get_taken_username($parsed);
  echo $output;
?> 