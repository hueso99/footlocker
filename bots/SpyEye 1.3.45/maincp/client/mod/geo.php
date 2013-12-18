<?
	if (!defined('IN_BNCP')) exit;
	include_once ROOT_PATH."/mod/db.php";	

function CountryCode($country)
{
	global $db;
	$sql = "SELECT cc FROM geo_country WHERE cn='$country'";
	$res = $db->query($sql);
	if( $db->affected_rows )
	{
		list($cc) = $res->fetch_array();
		return $cc;
	}
	return 0;
}

function GetCountries()
{
	global $db;
	$sql = "SELECT cc,cn FROM geo_country";
	$res = $db->query($sql);
	$RESULT = array();
	if( $db->affected_rows )
	{
		while( list($val, $key) = $res->fetch_array() ) $RESULT[$key] = $val;
		$RESULT['Unknown'] = 0;
		return $RESULT;
	}
	return 0;
}

function GetBotInfo($ip)
{
	global $db;
	$long = sprintf("%u", ip2long($ip));
	$sql = "SELECT cn as country_name, tr as region, tn as city from geo_city, geo_country where cc=tc and locId=
				(SELECT loc_id FROM geo_loc WHERE $long BETWEEN start AND end LIMIT 1)";
				
				//echo $sql."<br>";

	$res = $db->query($sql);
	//echo $db->affected_rows."<br>";
	if( $db->affected_rows )
	{
		$info = $res->fetch_object();
		return $info;
	}
	return 0;
}


	
?>