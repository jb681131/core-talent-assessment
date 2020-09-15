<?php

namespace App;

require_once('EncodingAlgorithm.php');

/**
 * Class CompositeEncodingAlgorithm
 */
class CompositeEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * @var EncodingAlgorithm[]
     */
    private $algorithms;

    /**
     * CompositeEncodingAlgorithm constructor
     */
    public function __construct()
    {
        $this->algorithms = array();
    }

    /**
     * @param EncodingAlgorithm $algorithm
     */
    public function add(EncodingAlgorithm $algorithm)
    {
		if ($algorithm) {
			$this->algorithms[] = $algorithm;
		}
    }

    /**
     * Encodes text using multiple Encoders (in orders encoders were added)
     *
     * @param string $text
     * @return string
     */
    public function encode($text)
    {
        /**
         * @todo: Implement it
         */
		 
		foreach($this->algorithms as $algorithm){ 
			if($algorithm) {
				$text = $algorithm->encode($text);
			}
		}

        return $text;
    }
}