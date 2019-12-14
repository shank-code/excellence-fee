<?php 

class API {

    public function GetallProducts($url,$auth) {
        $data = $this->callAPI('GET', $url, $auth);
        $data = json_decode($data);
        $varientIds = array();
        foreach ($data->products as $key => $item) {            
            foreach ($item->variants as $key => $value) {
                if($value->price != '0.00')
                $varientIds[$value->id] = $value->sku;
            }
        }
   return $varientIds;
        
    }
    public function Getcollection($url,$auth) {
        $data = $this->callAPI('GET', $url, $auth);
        $data = json_decode($data);
        foreach ($data->smart_collections as $c_key => $c_item) {
            if ($c_item->title == 'gift') {
                $collection_id = $c_item->id;
                break;
            }
        }
        return $collection_id;
    }
       public function GetcollectionbyID($url,$auth) {
       $data = $this->callAPI('GET', $url, $auth);
        $data = json_decode($data);
        $gift_varientIds = array();
        foreach ($data->products as $g_key => $g_item) {
            foreach ($g_item->variants as $gift_key => $gift_value) {
                $gift_varientIds[$gift_value->id] = $gift_value->sku;

            }
        }
        return $gift_varientIds;
    }

    public function Getscript($url, $auth)
    {
        $data = $this->callAPI('GET', $url, $auth);
        $data222 = json_decode($data);
        $array = (array)$data222;
        $dataV = $array['script_tags'];
        foreach ($dataV as $dataValue) {
            $dataArray = (array)$dataValue;
     
            if($dataArray['src'] != 'https://giftcard.js/'){
                
                $url1 = "https://" . $_SESSION['store'] . "/admin/api/2019-10/script_tags.json";
                $payload = '{"script_tag": {"event": "onload","src": "https://plivo1.demo.xmagestore.com/shopify_giftcard_app/giftcard.js"}}';
                $data = $this->callAPI('POST', $url1, $auth,$payload);  
            }
        }

    }

    public function callAPI($method, $url, $auth, $payload = false)
    {
        $username = $auth['username'];
        $password = $auth['password'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if( $method === 'POST' ){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            ));
        }
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
        
    }
  

}

?>