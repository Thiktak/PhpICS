<?php

namespace ICS;

/**
 * iObjects
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Interface iObjects {
  public static function parseObject(Objects $doc, $content);
  public function saveObject();
}

?>