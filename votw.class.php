<?php
class votw{
    private $domain = 'yourdomaingoes.here';
    private $key = 'API_KEY';
    private $usewebp = true;
    public function __construct(){
        $votw = false;
        if(isset($_SESSION['virtue'])){
            $votw = json_decode($_SESSION['virtue'],true);
            if(!$votw['logo'] || !$votw['gmtmod']){
                $json = $this->fetchVotw();
                $vt = json_decode($json,true);
                if($vt['status'] == 'success'){
                    $votw = $vt['data'];
                    // ensure the week number and GMT timestamp are not strings
                    $votw['week'] = (int)$votw['week'];
                    $votw['gmtmod'] = (int)$votw['gmtmod'];
                    $_SESSION['virtue'] = json_encode($votw);
                }
            }
        } else {
            $json = $this->fetchVotw();
            $vt = json_decode($json,true);
            if($vt['status'] == 'success'){
                $votw = $vt['data'];
                $votw['week'] = (int)$votw['week'];
                $votw['gmtmod'] = (int)$votw['gmtmod'];
                $_SESSION['virtue'] = json_encode($votw);
            }
        }
        return $votw;
    }
    
    private function supportsWebP() {
        $result = 0;
        // this detects if webp is supported by the visitor's browser
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            if(strpos( $_SERVER['HTTP_USER_AGENT'], ' Chrome/' ) !== false ) {
              $result = 1;
            }
        }
        return $result;
    }
    private function fetchVotw(){
        $url = "https://api.tlotl.cyou/data/vow.php";
        $webp = 0;
        if($this->usewebp !== false){
          $webp = $this->supportsWebP();
        }
        $postData = [
            'domain' => $this->domain,
            'useimages' => 1,
            'webp' => $webp
        ];
        $jsonData = json_encode($postData);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".$this->key
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
