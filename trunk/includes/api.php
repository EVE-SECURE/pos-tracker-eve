<?php

class API
{
    /**
     * API::API_UpdatePrices()
     * Using EVE Marketdata for now only.
     * @return
     */
    function API_UpdatePrices($args)
    {
		if ($args <= 999999) {
		$args = 10000002; //Default to Jita(The Forge)
		}
        $url = "http://eve-marketdata.com/api/item_prices.xml?type_ids=44,3683,3689,9832,9848,16274,17889,17887,17888,16273,16272&region_id=".$args;

        $xml = $this->API_Connect2($url);

        if (!$xml) { return false; }

        $fail = 0;
        $time = time();
        $dbconn =& DBGetConn(true);

        $count = 0;
        foreach ($xml->xpath('//price') as $row) {

           $sql = "UPDATE ".TBL_PREFIX."prices
                    SET    Value               = '".Eve::VarPrepForStore($row)."'
                    WHERE  typeID            = '".Eve::VarPrepForStore($row['id'])."'"; 

            $dbconn->Execute($sql);

            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', 'Could not update prices! ; ' . $dbconn->ErrorMsg());
                return false;
            }

            $count = $count + 1;

        }

        return $count;

    }

	function API_Connect2($url, $conntype = 'POST')
    {

        if (!$url) {
            Eve::SessionSetVar('errormsg', 'NO URL');
            return false;
        }

        $data = array();

        $extensions = get_loaded_extensions();
        $curl = in_array('curl', $extensions);

        if ($curl) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            $content = curl_exec($ch);
            curl_close($ch);
        }

        //Create XML Parser
        try {
            $xml = new SimpleXMLElement($content);
        } catch (Exception $e) {
            Eve::SessionSetVar('errormsg', 'Error: '.$e->getMessage());
            return false;
        }

        foreach ($xml->xpath('//error') as $error) {
            Eve::SessionSetVar('errormsg', 'Error Code: '.$error['code'].'::'.$error);
            return false; //$fail = 1;
        }

        return $xml;

    }
	
	
}
?>