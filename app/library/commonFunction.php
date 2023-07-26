<?php
namespace App\library{
	class commonFunction
	{
	    public static function years()
		{
			$years = array();
			for ($i=(int)date('Y'); $i <= ((int)date('Y')+20); $i++) 
			{ 
			  array_push($years, $i);
			}
			return $years;
		}

		public static function months(){
			$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

			return $months;
		}

		public static function dateFormateForDB($date){
			$date = date('Y-m-d', strtotime($date));
			return $date;
		}

		public static function slugify($text)
		{
		  // replace non letter or digits by -
		  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

		  // transliterate
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		  // remove unwanted characters
		  $text = preg_replace('~[^-\w]+~', '', $text);

		  // trim
		  $text = trim($text, '-');

		  // remove duplicate -
		  $text = preg_replace('~-+~', '-', $text);

		  // lowercase
		  $text = strtolower($text);

		  if (empty($text)) {
		    return 'n-a';
		  }

		  return $text;
		}
	}
}
?>