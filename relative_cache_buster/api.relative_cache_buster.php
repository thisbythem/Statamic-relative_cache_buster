<?php

class API_relative_cache_buster extends API {

  public $meta = array(
    'name'       => 'Relative Cache Buster',
    'version'    => '1.1.0',
    'author'     => 'Jamie Wagner',
    'author_url' => 'http://thisbythem.com'
  );

  public function bustCache($file) {
    return $this->tasks->bustCache($file);
  }
}
