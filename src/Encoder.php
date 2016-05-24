<?php
	namespace Mintopia\VDFKeyValue;

	class Encoder {
		public function encode($root, $data) {
			return $this->encodeTree($root, $data, 0);
		}
		
		/**
		 * Encodes a tree of data as KeyValue.
		 *
		 * @param string $root The root name for this tree.
		 * @param mixed $data The data in this tree.
		 * @param int $level The level of the tree.
		 * @return string The encoded tree.
		 */
		protected function encodeTree($root, $data, $level = 0) {
			// We only work on arrays or scalars, try casting any objects
			if (is_object($data)) {
				$data = (array) $data;
			}
			
			// If we're not an array then it's easy to deal with
			if (!is_array($data)) {
				return $this->encodeScalar($data);
			}
			
			// Let's get the tab level here
			$tabs = str_repeat("\t", $level);
			
			// Our initial intro, the root name and opening braces
			$return = "{$tabs}\"{$root}\"\r\n{$tabs}{\r\n";
			
			// Iterate for every item in the data and encode it
			foreach ($data as $key => $item) {
				if (is_array($item) || is_object($item)) {
					// The item is an array or an object, we can iterate it
					// so let's recurse through
					$return .= $this->encodeTree($key, $item, $level + 1);
				} else {
					// We'll treat it as a scalar and turn it into a string
					$value = $this->encodeScalar($item);
					$return .= "{$tabs}\t\"{$key}\"\t{$value}";
				}
			}
			
			// Finish up the curly braces
			$return .= "{$tabs}}\r\n";
			return $return;
		}
		
		/**
		 * Encodes a scalar value.
		 *
		 * @param mixed $data The data to encode.
		 * @return string Encoded value.
		 */
		protected function encodeScalar($data) {
			// Our replacement mapping. Only disallowed characters are
			// newlines and single slashes.
			$replacements = array(
				"\r" => "",
				"\n" => "",
				"\"" => "\\\""
			);
			$cleaned = str_replace(array_keys($replacements), $replacements, $data);
			return "\"{$cleaned}\"\r\n";
		}
	}