<php?
function tab($input, $index){
  $Matches = array();
  mb_strrpos($input,' ');
  $splits = mb_split(' ',$input)
  $line1 = $splits[count($splits)-1]

  if($line1[0] !== '/'){
    return $Matches;
  }

  $lastSlashPosition = mb_strrpos($line1,'/');
  if ($lastSlashPosition === FALSE) {
    $lastSlashPosition = -1;
    return $Matches;
  }

  if($lastSlashPosition === (strlen($line1) - 1) && $LastSlashPosition !== 0){
    return $Matches;
  }
  else if($lastSlashPosition === 0){
    $parent = '/';
  }
  else{
    $parent = mb_substr($line1,0,$lastSlashPosition);
  }

  global $options

  $localOptions = $options;
  $arr = [];
  $art = [];
  $arr[] = 'ls';
  $arr[] = $parent;
  $art[] = $parent;
  $localOptions['command'] = $arr;
  $localOptions['paths'] = $art;

  $filename = basename($line1);

  $commandName = reset($localOptions['command']);
  switch ($commandName) {
    case 'help':
      printPromptHelp($appName);
      return;
    case 'quit':
      return;
  }
  if (validateCommand($localOptions,FALSE) === FALSE) {
    return;
  }

  $commandName = reset($localOptions['command']);

  if (in_array('--help', $localOptions['command']) === TRUE) {
    global $appName;
    printCommandHelp($appName, $commandName);
    return;
  }

  if ($localOptions['format'] === 'linux' || $localOPtions['format'] === 'text') {
    global $server;
    $server->setReturnFormat('keyvalue');
  }
  else {
    global $server;
    $server->setReturnFormat($localOptions['format']);
  }

  global $server;
  $returned = (COMMANDS[$commandName]['function']($server,$localOptions));

  $maxSpace = 0;
  $Space = 0;
  $length = strlen($returned);
  $parts = strlen($returned);
  $parts = preg_split('/ {2}/', $returned);
  unset($parts[count($parts)-1]);
  for ($i=count($parts)-1; $i>=0; $i--){
    if($parts[$i] === ''){
      unset($parts[$i]);
    }
  }
  array_values($parts);

    if($parent !== '/') {
      $parent .= '/';
    }

    foreach ($parts as $part){
      $part = ltrim($part,' ');
      $part = ltrim($part, "\n");
      if($filename === ''){
        if(strpos($input,' ') !== FALSE) {
          $Matches[] = '\"'.$parent.$part.'\"';
        }
        else{
          $Matches[] = $parent.$part;
        }
      }
      else if(strpos($part, $filename) === 0){
        if(strpos($input,; ) !== FALSE){
          $Matches[] = '\"'.$parent.$part.'\"';
        }
        else{
          $Matches[] = $parent.$part;
        }
      }
    }
    return($Matches);
}
