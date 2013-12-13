<?php

namespace Utility\Storage;

class Storage {

	protected $storage = array();

	public function __construct(array $storage = array()) {
		$this->storage = $storage;
	}

	public function getStorageToArray() {
		return $this->storage;
	}

	public function write($key, $value) {
		$insert = &$this->storage;
		foreach (explode('.', $key) as $folder) {
			$insert = &$insert[$folder];
		}
		$insert = $value;
	}

	public function read($key) {
		$result = $this->storage;
		foreach (explode('.', $key) as $value) {
			$result = @$result[$value];
		}
		return $result;
	}

	public function merge(array $storage) {
		$this->storage = $this->recursiveMerge($this->storage, $storage);
	}

	private function recursiveMerge(array $tab1, array $tab2) {
		foreach ($tab2 as $key => $value) {
			if(is_array($tab1[$key])) {
				$tab1[$key] = $this->recursiveMerge($tab1[$key], $tab2[$key]);
			}
			else {
				$tab1[$key] = $value;
			}
		}
		return $tab1;
	}

}