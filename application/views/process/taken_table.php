<?php
  $parsed = explode(",",$varP);
  $output = $this->process->get_taken_table($parsed);
  echo $output;
?> 