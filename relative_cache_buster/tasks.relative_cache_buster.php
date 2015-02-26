<?php

class Tasks_relative_cache_buster extends Tasks {

    protected $file_updated;

    public function bustAllCaches() {
        if ($this->busterIsNeeded()) {
            foreach ($this->config as $url_pattern => $pages_to_bust) {
                $actual_file_path = Path::resolve($url_pattern);
                $this->bustCacheForPages($pages_to_bust);
            }
            return true;
        }
        return false;
    }

    public function bustCache($file) {
        if ($this->busterIsNeeded()) {
            $this->file_updated = $file;

            foreach ($this->config as $url_pattern => $pages_to_bust) {
                $actual_file_path = Path::resolve($url_pattern);
                if ($this->shouldBustRelativePagesCache($actual_file_path)) {
                    $this->bustCacheForPages($pages_to_bust);
                }
            }
            return true;
        }

        return false;
    }
    
    public function regenerateCache($page) {
        $this->bustCacheForPages(array($page));
        file_get_contents(URL::makeFull($page));
    }

    public function regenerateAllCaches() {
        $this->bustAllCaches();
        foreach ($this->config as $url_pattern => $pages) {
            foreach ($pages => $page) {
                file_get_contents(URL::makeFull($page));
            }
        }
    }

    private function busterIsNeeded() {
        $html_caching_addon  = Addon::getApi('html_caching');
        $html_cache_enabled  = $html_caching_addon->fetchConfig('enable');
        $cache_length        = $html_caching_addon->fetchConfig('cache_length');
        $valid_cache_lengths = array('on last modified', 'on cache update');
        $valid_cache_length  = in_array($cache_length, $valid_cache_lengths);

        return $html_cache_enabled && $valid_cache_length;
    }

    private function shouldBustRelativePagesCache($filepath) {
        return (bool) $this->isUpdatedFile($filepath) || $this->isInDirectory($filepath);
    }

    private function isUpdatedFile($actual_file_path) {
        return (bool) strpos($this->file_updated, $actual_file_path);
    }

    private function isInDirectory($actual_file_path) {
        return (bool) Folder::matchesPattern($this->file_updated, $actual_file_path);
    }

    private function bustCacheForPages($pages) {
        // we delete the actual cache file because of this bug: https://lodge.statamic.com/public-house/1244-bug-in-rendered-html-code-somewhere
        foreach ($pages as $page) {
            $full_path = Path::assemble(BASE_PATH, '_cache', '_add-ons', 'html_caching', Helper::makeHash($page));
            if (File::exists($full_path)) {
                File::delete($full_path);
            }
        }
    }
}
