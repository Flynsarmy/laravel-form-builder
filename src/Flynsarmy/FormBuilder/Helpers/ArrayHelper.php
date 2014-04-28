<?php namespace Flynsarmy\FormBuilder\Helpers;

class ArrayHelper
{
	/**
	 * Returns the position of a given key in an associative array.
	 *
	 * @param  array  $arr Associative array to search
	 * @param  string $key Key to retrieve position of
	 *
	 * @return int         Key position. -1 if not found.
	 */
	public static function getKeyPosition(array $arr, $search_key)
	{
		if ( !isset($arr[$search_key]) )
			return -1;

		$position = 0;
		$keys = array_keys($arr);
		foreach ( $keys as $key )
		{
			if ( $key == $search_key )
				return $position;

			$position++;
		}

		return -1;
	}

	/**
	 * Insert one array into another at a given position
	 *
	 * @param  array   $src Source array to insert into
	 * @param  array   $ins Array to insert
	 * @param  integer $pos Position to insert at. Will append if $pos > sizeof($src)
	 *
	 * @return array        Source array with insertion
	 */
	public static function insert(array $src, array $ins, $pos) {
		if ( !$pos )
			return $ins + $src;
		else if ( $pos >= sizeof($src) )
			return $src + $ins;

		return array_merge(
			array_slice($src, 0, $pos),
			$ins,
			array_slice($src, $pos)
		);
	}
}