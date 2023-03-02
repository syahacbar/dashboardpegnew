<?php
/**
Helper format
https://jagowebdev.com
*/

function format_ribuan($value) {
	return number_format($value, 0, ',' , '.');
}

function format_golru($value) {
	switch ($value) {
	  case "I/A":
	  	return "I/a";
	  break;
	  case "I/B":
	  	return "I/b";
	  break;
	  case "I/C":
	  	return "I/c";
	  break;
	  case "I/D":
	  	return "I/d";
	  break;

	  case "II/A":
	  	return "II/a";
	  break;
	  case "II/B":
	  	return "II/b";
	  break;
	  case "II/C":
	  	return "II/c";
	  break;
	  case "II/D":
	  	return "II/d";
	  break;

	  case "III/A":
	  	return "III/a";
	  break;
	  case "III/B":
	  	return "III/b";
	  break;
	  case "III/C":
	  	return "III/c";
	  break;
	  case "III/D":
	  	return "III/d";
	  break;

	  case "IV/A":
	  	return "IV/a";
	  break;
	  case "IV/B":
	  	return "IV/b";
	  break;
	  case "IV/C":
	  	return "IV/c";
	  break;
	  case "IV/D":
	  	return "IV/d";
	  break;
	  case "IV/E":
	  	return "IV/e";
	  break;

	  default:
	  	return $value;
	}

}