<?php

namespace App;

require_once('EncodingAlgorithm.php');

/**
 * Class SubstitutionEncodingAlgorithm
 */
class SubstitutionEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * @var array
     */
    private $substitutions;

    /**
     * SubstitutionEncodingAlgorithm constructor.
     * @param $substitutions
     */
    public function __construct(array $substitutions = [])
    {
        $this->substitutions = $substitutions;
    }

    /**
     * Encodes text by substituting character with another one provided in the pair.
     * For example pair "ab" defines all "a" chars will be replaced with "b" and all "b" chars will be replaced with "a"
     * Examples:
     *      substitutions = ["ab"], input = "aabbcc", output = "bbaacc"
     *      substitutions = ["ab", "cd"], input = "adam", output = "bcbm"
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
		foreach($this->substitutions as $substitution) {
			if (is_string($substitution)) {
				$from_to = str_split($substitution);
				
				if (count($from_to) == 2) {
					foreach($text_array as $key => $char) {
						$text_array[$key] = ($char === $from_to[0]) ? 
												$from_to[1] : (($char === $from_to[1]) ? 
													$from_to[0] : $char);
					}
				}
			}
		}

        return implode($text_array);
    }
}