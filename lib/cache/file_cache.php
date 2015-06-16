<?php
/**
 * @description 文件缓存类别
 * @author lzj
 * @2015/01/05
 */
class FileCache {
	private $expire;

	public function __construct() {
		$expire = C('FILECACHETIME');
		
		$this->expire = $expire;

		$files = glob(WEB_PATH . 'cache.*');

		if ($files) {
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);

				if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);
					}
				}
			}
		}
	}

	public function get($key) {
		$files = glob(WEB_PATH . C('FILECACHEDIE') . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			$handle = fopen($files[0], 'r');

			flock($handle, LOCK_SH);

			$data = fread($handle, filesize($files[0]));

			flock($handle, LOCK_UN);

			fclose($handle);

			return unserialize($data);
		}

		return false;
	}

	public function set($key, $value, $expire = 0) {
		$this->delete($key);
		
		if($expire != 0) {
			$this->expire = $expire;
		}
		
		$file = WEB_PATH . C('FILECACHEDIE').'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->expire);

		$handle = fopen($file, 'w');

		flock($handle, LOCK_EX);

		fwrite($handle, serialize($value));

		fflush($handle);

		flock($handle, LOCK_UN);

		fclose($handle);
	}

	public function delete($key) {
		$files = glob(WEB_PATH . C('FILECACHEDIE') . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}
}
