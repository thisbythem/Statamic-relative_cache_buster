<?php

class Hooks_relative_cache_buster extends Hooks {

  public $meta = array(
    'name'       => 'Relative Cache Buster',
    'version'    => '1.0.0',
    'author'     => 'Jamie Wagner',
    'author_url' => 'http://thisbythem.com'
  );

  protected $file_updated;

  public function control_panel__publish($data) {
    if ($this->busterIsNeeded()) {
      $this->file_updated = $data['file'];

      foreach ($this->config as $url_pattern => $pages_to_bust) {
        $actual_file_path = Path::resolve($url_pattern);
        if ($this->shouldBustRelativePagesCache($actual_file_path)) {
          $this->bustCacheForPages($pages_to_bust);
          break;
        }
      }
    }
    return $data;
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
