<?php

namespace App;

require_once('EncodingAlgorithm.php');

/**
 * Class OffsetEncodingAlgorithm
 */
class OffsetEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * Lookup string
     */
    const CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var int
     */
    private $offset;

    /**
     * @param int $offset
     */
    public function __construct($offset = 13)
    {
        $this->offset = $offset;
    }

    /**
     * Encodes text by shifting each character (existing in the lookup string) by an offset (provided in the constructor)
     * Examples:
     *      offset = 1, input = "a", output = "b"
     *      offset = 2, input = "z", output = "B"
     *      offset = 1, input = "Z", output = "a"
     *
     * @param string $text
     * @return string
     */
    public function encode($text = '')
    {
        /**
         * @todo: Implement it
         */
		if (!$text) {
			return '';
		}
		 
		$text_array = str_split($text);
		 
		foreach($text_array as $key => $char) {
			$text_array[$key] = $this->encodeChar($char);
		}
        return implode($text_array);
    }
	
	/**
	* @param string $char
	**/
	private function encodeChar($char)
	{
		if (($pos = strpos(OffsetEncodingAlgorithm::CHARACTERS,$char)) !== false) {
			$index = ($pos + $this->offset) % strlen(OffsetEncodingAlgorithm::CHARACTERS);
			$char = substr(OffsetEncodingAlgorithm::CHARACTERS, $index, 1); 
		}
		
		return $char;
	}
}