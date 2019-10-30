<?php

/*
 * This file is part of the https://github.com/petruchek/problem.appjobs
 *
 * @author Val Petruchek <petruchek@gmail.com>
 */

class Job_Matcher
{
	const REQUIRES_SOMETHING = "requires";
	const REQUIRES_NOTHING = "doesn't require anything";

	private $assets, $matches;

	/**
	 * Start the show.
	 *
	 * Save the assets candidate has, reset the matches.
	 *
	 * @param array $assets set of applicant's assets
	 * @return void
	 */
	public function __construct(array $assets)
	/*
		maybe it's better to accept applicant's assets as a string and parse them into array here?
	*/	
	{
		$this->assets = $assets;
		$this->matches = [];
	}

	/**
	 * Process one company line. Call internal parser for further processing.
	 *
	 * Saves company name if it's a match.
	 *
	 * @param string $s one line of predefined format: "Company X" (requires A, B, C|doesn't require anything)
	 * @return void
	 */
	public function incoming_company(string $textual)
	{
		if ($company = $this->parse_company_line($textual))
			$this->matches[] = $company;
	}

	/**
	 * Parse one company line. Call requirements checker if needed.
	 *
	 * Returns company name if it's a match, false otherwise.
	 *
	 * @param string $s one line of predefined format: "Company X" (requires A, B, C|doesn't require anything)
	 * @return mixed
	 */
	private function parse_company_line(string $s)
	{
		preg_match("#^(.*?) (".self::REQUIRES_SOMETHING."|".self::REQUIRES_NOTHING.")(.*)$#",$s,$matches);

		if (!$matches)
			return false; //invalid format, maybe should throw an exception?

		if ( ($matches[2] == self::REQUIRES_NOTHING) || $this->meet_requirements(trim($matches[3]), $this->assets))
			return $matches[1];

		return false;
	}

	/**
	 * Verify whether textual requirements are satisfied by the array of assets.
	 *
	 * Returns boolean == a match or not.
	 *
	 * @param string $s 'informal' list of requirements, example: a scooter or a bike, or a motorcycle and a driver's license and motorcycle insurance
	 * @param array $trues set of assets that evaluates as TRUE; the rest of assets assumed missing i.e. FALSE
	 * @return bool
	 */
	private function meet_requirements(string $s, array $trues)
	/*
		well, we really should convert $s into proper postfix notation (like Reverse Polish notation), but I need one of the following:
			a) formal description of requirements format (commas, ands, ors)
			b) bigger test data set to produce a)

		for now i'm assuming all incoming strings are valid, that's why eval() has been used
		
		in the real world it should be replaced with a well-documented parser.
	*/
	{
		$s = " ".trim($s,".")." ";
		$s = trim(str_replace([' an ',' a ',','],[' ',' ','/,/'],$s));
		//now we have an unified expression of X or and , Y (no articles)

		$s = str_replace([' and ',' or '], ['/&&/','/||/'], $s);

		$words = explode('/',$s);
		$stack = [];

		foreach ($words as $w)
		{
			if ( ($w == '||') || ($w == '&&') )
				$stack[] = $w;
			elseif ($w == ",")
				$stack = ["(".implode(' ',$stack).")"];
			elseif ($w) //we may have some spaces near operands which can be ignored
			{
				$value = (in_array($w, $trues)) ? 'true' : 'false';
				$stack[] = $value;
			}
		}

		eval ("\$x = ".implode(' ',$stack).";");
		return $x;
	}

	/**
	 * Report collected matches.
	 *
	 * Returns list of company names.
	 *
	 * @return array
	 */
	public function get_matches()
	{
		return $this->matches;
	}	
}
