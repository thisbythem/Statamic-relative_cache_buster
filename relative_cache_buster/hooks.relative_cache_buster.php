<?php

class Hooks_relative_cache_buster extends Hooks {

  protected $file_updated;

  public function control_panel__publish($data = array()) {
    $this->file_updated = $data['file'];

    foreach ($this->config as $url_pattern => $pages_to_bust) {
      $actual_file_path = Path::resolve($url_pattern);
      if ($this->shouldBustRelativePagesCache($actual_file_path)) {
        $this->bustCacheForPages($pages_to_bust);
        break;
      }
    }
    return $data;
  }

  protected function shouldBustRelativePagesCache($filepath) {
   return (bool) $this->isUpdatedFile($filepath) || $this->isInDirectory($filepath);
  }

  protected function isUpdatedFile($actual_file_path) {
    return (bool) strpos($this->file_updated, $actual_file_path);
  }

  protected function isInDirectory($actual_file_path) {
    return (bool) Folder::matchesPattern($this->file_updated, $actual_file_path);
  }

  protected function bustCacheForPages($pages) {
    $content_root = Config::getContentRoot();
    $full_content_root = rtrim(Path::tidy(BASE_PATH . "/" . $content_root), "/");

    foreach ($pages as $page) {
      $page_full_path = $full_content_root . Path::resolve($page);
      if (File::exists($page_full_path)) {
        touch($page_full_path);
      }
    }
  }

}
