<?php
class TorrentParser
{
	public static function parse($s)
	{
		static $str;
		$str = $s;
		if ($str{0} == 'd')
		{
			$str = substr($str,1);
			$ret = array();
			while (strlen($str) && $str{0} != 'e')
			{
				$key = TorrentParser::parse($str);
				if (strlen($str) == strlen($s))
					break; // prevent endless cycle if no changes made
				if (!strcmp($key, "info"))
				{
					$save = $str;
				}
				$value = TorrentParser::parse($str);
				if (!strcmp($key, "info"))
				{
					$tosha = substr($save, 0, strlen($save) - strlen($str));
					$ret['info_hash'] = sha1($tosha);
				}
				// process hashes - make this stuff an array by piece
				if (!strcmp($key, "pieces"))
				{
					$value = explode("====",
					    substr(
				    		chunk_split( $value, 20, "===="),
				    		0, -4
					    )
					);
	
					foreach ($value as &$v)
					{
						$v = sha1($v);
					}
					
					unset($v); // break the reference with the last element
				}
	
				$ret[$key] = $value;
			}
	
			$str = substr($str,1);
	
			return $ret;
		}
		else if ($str{0} == 'i')
		{
			$ret = substr($str, 1, strpos($str, "e")-1);
			$str = substr($str, strpos($str, "e")+1);
			return $ret;
		}
		else if ($str{0} == 'l')
		{
			$ret = array();
			$str = substr($str, 1);
			while (strlen($str) && $str{0} != 'e')
			{
				$value = TorrentParser::parse($str);
				if (strlen($str) == strlen($s))
				{
					break; // prevent endless cycle if no changes made
				}
				$ret[] = $value;
			}
			$str = substr($str,1);
			return $ret;
		}
		else if (is_numeric($str{0}))
		{
			$namelen = substr($str, 0, strpos($str, ":"));
			$name = substr($str, strpos($str, ":")+1, $namelen);
			$str = substr($str, strpos($str, ":")+1+$namelen);
			return $name;
		}
	}
}
?>