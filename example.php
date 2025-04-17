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
$result = json_decode(getVotw('domain.com','MY_API_KEY'),true);
if($result['status'] === 'success'){
$votw = $result['data'];
?>
<div class="votw">
<div class="votw-title">Virtue of the Week</div>
          <div class="knight"> <img src="<?php echo $votw['knight']; ?>" alt="knight" width="134" height="130">
<img class="votw-icon" src="<?php echo $votw['icon']; ?>" width="36" height="45" alt="<?php echo $votw['character']; ?>">
</div>
  <div class="frosted">
     <div class="votw-title"><?php echo $votw['title']; ?></div>
     <div>
        <p class="votw-characteristic"><?php echo $votw['characteristic']; ?></p>
        <p class="votw-content"><?php echo $votw['content']; ?></p>
        <blockquote><?php echo $votw['verse']; ?><span></span><cite><?php echo $votw['cite']; ?></cite></blockquote>
        <p class="votw-content">Challenge yourself to be aware of any and all opportunities to practice and apply <?php echo strtolower($votw['title']); ?> in your life this week, and the times you should have, but didn't because of the characteristic pride, vanity, envy, selfishness, ambition, lust, greed, desire for creature comfort and/or fear for survival of the carnal, instinctual, egoistic (self-centered) nature of your flesh.</p>
        <p><a href="https://leagueoftrue.love/virtues">All 52 Virtues</a></p>
     </div>
  </div>
</div>
<?php
}
?>
