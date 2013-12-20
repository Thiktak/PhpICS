<?php

date_default_timezone_set('Europe/paris');
include '../PhpICS/ICS/index.php';

$get_file = filter_input(INPUT_GET, 'file', FILTER_SANITIZE_SPECIAL_CHARS) ?: '&lt;filename&gt;';

$FILE = 'ics/' . $get_file . '.ics';
$icalc = null;

try {

?><!DOCTYPE html>
<html>
  <head>
    <title>PhpICS - Tests - <?php echo $FILE; ?></title>
    <link rel="stylesheet" type="text/css" href="assets/style.css" />
  </head>
  <body>
    <div id="global">
      <header id="header">
        <h1>Tests for <em><?php echo $FILE; ?></em></h1>
      </header>

      <ul class="tests">
      <?php foreach( scandir('./ics/') as $file ): if( in_array($file, array('.', '..')) ) continue; ?>
        <li><a href="?file=<?php echo pathinfo(urlencode($file), PATHINFO_FILENAME); ?>"><?php echo $file; ?></a></li>
      <?php endforeach; ?>
      </ul>

<?php
// .ics file open test
try {
  $icalc = ICS\ICS::open($FILE);
}
catch(ICS\ICSException $e) { echo '<div class="alert alert-error">Error : ', $e->getMessage(), '</div>'; }
?>

      <h1>Output :: <em><?php echo $FILE; ?></em></h1>
      
      <pre><h2>Generated export for <em><?php echo $FILE; ?></em></h2><code><?php echo $icalc; ?></code></pre>

      <pre><h2><em><?php echo $FILE; ?></em></h2><code><?php echo file_exists($FILE) ? file_get_contents($FILE) : '404 Not Found'; ?></code></pre>
    </div>
  </body>
</html><?php
}
catch(ICS\ICSException $e) {
  echo 'Error : ', $e->getMessage();
}
?>