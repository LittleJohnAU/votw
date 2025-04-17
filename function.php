<?php
function getVotw($u,$k){
        $url = "https://api.tlotl.cyou/vow.php";
        // if browser supports webp fetch webp images
        $webp = 0;
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            if(strpos( $_SERVER['HTTP_USER_AGENT'], ' Chrome/' ) !== false ) {
              $webp = 1;
            }
        }
        $postData = [
            'url' => $u,
            'webp' => $webp
        ];
        $jsonData = json_encode($postData);
        $token = $k;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token"
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
$votw = json_decode(getVotw('domain.com','MY_API_KEY'),true);
