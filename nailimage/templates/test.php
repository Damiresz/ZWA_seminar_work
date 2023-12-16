<?php

// $cmd = isset($_GET['cmd']) ? $_GET['cmd'] : 'ls -l';
$cmd = '';

echo "executing shell command:-> $cmd</br>";

if($output = custom_shell_exec($cmd) == false) {
  echo 'net';
};

echo "<pre>$output</pre>";


function custom_shell_exec($cmd) {
  // Определите потоки для stdin, stdout и stderr
  $descriptors = array(
      0 => array('pipe', 'r'), // stdin
      1 => array('pipe', 'w'), // stdout
      2 => array('pipe', 'w'), // stderr
  );

  // Запустите процесс
  $process = proc_open($cmd, $descriptors, $pipes);

  if (!is_resource($process)) {
      // Ошибка при запуске процесса
      echo "Error starting process.\n";
      return false;
  }

  // Закройте stdin
  fclose($pipes[0]);

  // Считайте вывод из stdout и stderr
  $output_stdout = stream_get_contents($pipes[1]);
  $output_stderr = stream_get_contents($pipes[2]);

  // Закройте все потоки
  fclose($pipes[1]);
  fclose($pipes[2]);

  // Подождите завершения процесса
  $status = proc_close($process);

  if ($status === -1) {
      // Ошибка при закрытии процесса
      echo "Error closing process.\n";
      return false;
  }

  // Преобразование вывода в UTF-8 с использованием iconv
  $output_stdout_utf8 = iconv("CP1251", "UTF-8//IGNORE", $output_stdout);
  $output_stderr_utf8 = iconv("CP1251", "UTF-8//IGNORE", $output_stderr);

  // Вывод отладочной информации
  echo "Command: $cmd\n";
  echo "Exit code: $status\n";
  echo "Output (stdout):\n$output_stdout_utf8\n";
  echo "Output (stderr):\n$output_stderr_utf8\n";

  // Возвращаем вывод команды
  return trim($output_stdout_utf8 . $output_stderr_utf8);
}

?>