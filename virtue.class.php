<?php
class virtue{
    private $token = 'YOUR_TOKEN';
    private $endpoint = 'https://api.tlotl.cyou/get?token';
    private $url;
    public function __construct($qry, $text=''){
        $data = false;
        $this->url = $this->endpoint.$this->token.'&q='.$qry;
        switch($qry){
            case 'week':
                if(isset($_SESSION['votw'])){
                    $response = $_SESSION['votw'];
                } else {
                    $response = $this->fetch();
                    $_SESSION['votw'] = $response;
                }
            break;
            case 'day':
                if(isset($_SESSION['votd'])){
                    $response = $_SESSION['votd'];
                } else {
                    $response = $this->fetch();
                    $_SESSION['votd'] = $response;
                }
            break;
            case 'one':
                $this->url .= '&title='.$text;
                if(isset($_SESSION['virtue'])){
                    $set = json_decode($_SESSION['virtue'],true);
                    if(strtoupper($set['title']) === strtoupper($text)){
                       $response = $_SESSION['virtue'];
                    } else {
                       $response = $this->fetch();
                       $_SESSION['virtue'] = $response;
                    }
                } else {
                    $response = $this->fetch();
                    $_SESSION['virtue'] = $response;
                }
            break;
            case 'tone':
                $this->url .= '&title='.$text;
                if(isset($_SESSION['vtone'])){
                    $set = json_decode($_SESSION['vtone'],true);
                    if(strtoupper($set[0]['tone']) === strtoupper($text)){
                      $response = $_SESSION['vtone'];
                    } else {
                      $response = $this->fetch();
                      $_SESSION['vtone'] = $response;
                    }
                } else {
                    $response = $this->fetch();
                    $_SESSION['vtone'] = $response;
                }
            break;
            case 'pairings':
                $response =  $this->fetch();
                $_SESSION['pairings'] = $response;
            break;
        }
        $data = json_decode($response,true);
        return $data;
    }
    private function fetch(){
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}