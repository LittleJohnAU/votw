<?php
include 'votw.php';
$vw = new votw;
//the gmtmod is a GMT timestamp that will always be the first day of the week in GMT and can be used to format any date. In this case the GMT date format for the Last-Modified header using the gmdate function
header("Last-Modified: " . gmdate("D, d M Y H:i:s", $vw['gmtmod']) . " GMT");
// if you want to use it to set the meta revised tag, you would do it like this, using the date function
// <meta name="revised" content="<?php echo date('l, F j, Y', $vw['gmtmod']); ?>">
?>
<!-- You can link to the CSS file using a CDN -->
<link rel="stylesheet" href="https://cdn.statically.io/gh/LittleJohnAU/votw/refs/heads/main/votw.min.css">
<div class="votw" style="background-image:url('<?php echo $vw['bgimage']; ?>">
  <div class="votw-logo"> <img src="<?php echo $vw['logo']; ?>" alt="Virtue of the Week" width="319" height="200" loading="lazy"></div>
  <div class="frosted">
     <div class="votw-title"><?php echo $vw['title']; ?></div>
     <div>
        <img class="votw-icon" src="<?php echo $vw['icon']; ?>" width="36" height="45" alt="<?php echo $vw['character']; ?>" loading="lazy">
        <p class="votw-characteristic"><?php echo $vw['characteristic']; ?></p>
        <p class="votw-content"><?php echo $vw['content']; ?></p>
        <blockquote><?php echo $vw['verse']; ?><span></span><cite><?php echo $vw['cite']; ?></cite></blockquote>
        <p class="votw-content">Challenge yourself to be aware of any and all opportunities to practice and apply <?php echo strtolower($vw['title']); ?> in your life this week, and the times you should have, but didn't because of the characteristic pride, vanity, envy, selfishness, ambition, lust, greed, desire for creature comfort and/or fear for survival of the carnal, instinctual, egoistic (self-centered) nature of your flesh.</p>
        <p><a href="https://leagueoftrue.love/virtues" aria-label="The 52 virtues of true love" target="_blank" rel="noopener">All 52 Virtues</a></p>
     </div>
  </div>
</div>
