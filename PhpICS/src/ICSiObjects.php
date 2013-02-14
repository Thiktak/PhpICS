<?php

/**
 * ICSiObjects
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Interface ICSiObjects {
  public static function parseObject(ICSObjects $doc, $content);
  public function saveObject();
}

?>