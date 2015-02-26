<?php

class API_relative_cache_buster extends API {

    public $meta = array(
        'name'       => 'Relative Cache Buster',
        'version'    => '1.2.0',
        'author'     => 'Jamie Wagner',
        'author_url' => 'http://thisbythem.com'
    );

    public function bustCache($file) {
        return $this->tasks->bustCache($file);
    }
    
    public function bustAllCaches() {
        return $this->tasks->bustAllCaches();
    }

    public function regenerateCache($page) {
        return $this->tasks->regenerateCache($page);
    }

    public function regenerateAllCaches() {
        return $this->tasks->regenerateAllCaches();
    }
}
