<?php

class Tournament
{
	private $title;
	private $dateOfBegin;
	private $players;

	public function __construct($title, $dateOfBegin = null)
	{
		$this->title = $title;
		$this->players = array();
		if ($dateOfBegin != null)
		{
			$this->dateOfBegin = dateTime::createFromFormat('Y.m.d', $dateOfBegin);
		} else {
			$this->dateOfBegin = (new DateTime('NOW'))->modify('1 day');
		}		
	}

	public function addPlayer($player)
	{
		array_push($this->players, $player);
		return $this;
	}

	public function createPairs()
	{
		// Current day of Tournament.
		$dateOfTournament = clone $this->dateOfBegin;

		// Copy array of players.
		$playersCopy = array_merge(array(), $this->players);

		// Push empty player to array.
		if (count($playersCopy) % 2 == 1) {
			array_push($playersCopy, new stdClass);
		}

		// Output text.
		$out = '';

		// Remains of days;
		$remainsOfDay = count($playersCopy);
		
		while (--$remainsOfDay)
		{		
			// Next day of Tournament.
			$dateOfTournament = $dateOfTournament->modify('1 day');		

			// Tournament and day.
			$out .= $this->title . ', ';
			$out .= ($dateOfTournament->format('d.m.Y')) . '<br>';

			// Create horizontal struct of pairs.
			$halfCount = count($playersCopy) / 2;
			$halfs = array_chunk($playersCopy, $halfCount);
			$halfs[1] = array_reverse($halfs[1]);
	
			// Create pairs;
			for ($index = 0; $index < $halfCount; $index++)
			{
				$player1 = $halfs[0][$index];
				$player2 = $halfs[1][$index];

				// Pair.
				if (!($player1 instanceof stdClass) && !($player2 instanceof stdClass)) {
					$out .= $player1 . ' - ' . $player2 . '<br>';
				}
			}
		
			// Empty string between days.
			$out .= '<br>';
	
			// Circular motion.
			$firstPlayer = array_shift($playersCopy);	
			$endPlayer = array_pop ($playersCopy);
			array_unshift ($playersCopy, $firstPlayer, $endPlayer);
		}

		// Empty string between tournaments.
		$out .= '<br>';
		
		echo $out;
	}
}
?>