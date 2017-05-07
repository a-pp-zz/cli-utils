<?php
namespace AppZz\CLI;

class Utils {

	const FG_COLOR_BLACK         = 30;
	const FG_COLOR_RED           = 31;
	const FG_COLOR_GREEN         = 32;
	const FG_COLOR_YELLOW        = 33;
	const FG_COLOR_BLUE          = 34;
	const FG_COLOR_MAGENTA       = 35;
	const FG_COLOR_CYAN          = 36;
	const FG_COLOR_LIGHTGRAY     = 37;
	const FG_COLOR_DEFAULT       = 39;
	const FG_COLOR_DARK_GRAY     = 90;
	const FG_COLOR_LIGHT_RED     = 91;
	const FG_COLOR_LIGHT_GREEN   = 92;
	const FG_COLOR_LIGHT_YELLOW  = 93;
	const FG_COLOR_LIGHT_BLUE    = 94;
	const FG_COLOR_LIGHT_MAGENTA = 95;
	const FG_COLOR_LIGHT_CYAN    = 96;
	const FG_COLOR_WHITE         = 97;
	
	const BG_COLOR_DEFAULT       = 49;
	const BG_COLOR_BLACK         = 40;
	const BG_COLOR_RED           = 41;
	const BG_COLOR_GREEN         = 42;
	const BG_COLOR_YELLOW        = 43;
	const BG_COLOR_BLUE          = 44;
	const BG_COLOR_MAGENTA       = 45;
	const BG_COLOR_CYAN          = 46;
	const BG_COLOR_LIGHT_GRAY    = 47;
	const BG_COLOR_DARK_GRAY     = 100;
	const BG_COLOR_LIGHT_RED     = 101;
	const BG_COLOR_LIGHT_GREEN   = 102;
	const BG_COLOR_LIGHT_YELLOW  = 103;
	const BG_COLOR_LIGHT_BLUE    = 104;
	const BG_COLOR_LIGHT_MAGENTA = 105;
	const BG_COLOR_LIGHT_CYAN    = 106;
	const BG_COLOR_WHITE         = 107;

	public static function color ($string, $foreground_color = NULL, $background_color = NULL)
	{				
		if (empty ($foreground_color))
			return $string;

		if ( !empty ($foreground_color)) {
			$foreground_color = 'self::FG_COLOR_' . strtoupper($foreground_color);
			if (defined($foreground_color))
				$foreground_color = constant ($foreground_color);
			else
				$foreground_color = Utils::FG_COLOR_DEFAULT;
		}

		$colored_string = "\033[" . $foreground_color . "m";

		if ( ! empty ($background_color)) {
			$background_color = 'self::BG_COLOR_' . strtoupper($background_color);
			
			if (defined($background_color)) {
				$colored_string .= "\033[" . constant ($background_color) . "m";
			}
		}

		$colored_string .=  $string . "\033[0m";

		return $colored_string;
	}

    public static function params ($argv = null)
    {
        $argv = $argv ? $argv : $_SERVER['argv']; array_shift($argv); $o = array();
        for ($i = 0, $j = count($argv); $i < $j; $i++) { $a = $argv[$i];
            if (substr($a, 0, 2) == '--') { $eq = strpos($a, '=');
                if ($eq !== false) { $o[substr($a, 2, $eq - 2)] = substr($a, $eq + 1); }
                else { $k = substr($a, 2);
                    if ($i + 1 < $j && $argv[$i + 1][0] !== '-') { $o[$k] = $argv[$i + 1]; $i++; }
                    else if (!isset($o[$k])) { $o[$k] = true; } } }
            else if (substr($a, 0, 1) == '-') {
                if (substr($a, 2, 1) == '=') { $o[substr($a, 1, 1)] = substr($a, 3); }
                else {
                    foreach (str_split(substr($a, 1)) as $k) { if (!isset($o[$k])) { $o[$k] = true; } }
                    if ($i + 1 < $j && $argv[$i + 1][0] !== '-') { $o[$k] = $argv[$i + 1]; $i++; } } }
            else { $o[] = $a; } }
        return $o;
    }	
}