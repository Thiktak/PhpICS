<?php

Interface ICSiObjects {
  public static function parseObject(ICSDocument $doc, $content);
  public function saveObject();
}

?>