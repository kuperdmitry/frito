<?php

class Player
{
	private $name;
	private $city;
	
	public function __construct($name)
	{
		$this->name = $name;
		$this->city = '';
	}

	public function setCity($city)
	{
		$this->city = $city;
		return $this;
	}

	public function __toString()
	{
		$out = $this->name;
		if (!empty($this->city)) {
			$out .= ' (' . $this->city . ')';
		}
		return $out;
	}
}
?>