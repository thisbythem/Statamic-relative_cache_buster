<?php

class API_relative_cache_buster extends API {

    public function bustCache($file) {
        return $this->tasks->bustCache($file);
	}
}