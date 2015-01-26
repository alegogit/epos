<?php
  $parsed = $varP;
  //echo "<pre>" . var_dump($parsed) . "</pre>";
  $output = $this->process->get_taken_restname($parsed);
  echo $output;
?> 