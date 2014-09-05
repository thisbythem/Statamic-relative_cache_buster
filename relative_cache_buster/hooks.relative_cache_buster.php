<?php

class Hooks_relative_cache_buster extends Hooks {

  public $meta = array(
    'name'       => 'Relative Cache Buster',
    'version'    => '1.0.0',
    'author'     => 'Jamie Wagner',
    'author_url' => 'http://thisbythem.com'
  );

  public function control_panel__publish($data) {
    $this->tasks->bustCache($data['file']);

    return $data;
  }
}
