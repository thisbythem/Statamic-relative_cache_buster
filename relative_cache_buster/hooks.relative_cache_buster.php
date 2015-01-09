<?php

class Hooks_relative_cache_buster extends Hooks {

  public function control_panel__publish($data) {
    $this->tasks->bustCache($data['file']);
    return $data;
  }
}
