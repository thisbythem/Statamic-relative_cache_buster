<?php

class Hooks_relative_cache_buster extends Hooks {

    public function control_panel__publish($data) {
        $this->tasks->bustCache($data['file']);
        return $data;
    }

    public function relative_cache_buster__bust() {
        $this->tasks->bustAllCaches();
    }

    public function relative_cache_buster__regen() {
        $this->tasks->regenerateAllCaches();
    }   
}