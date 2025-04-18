<?php
include 'votw.php';
$vw = new votw;
?>

<div class="votw" style="background-image:url('<?php echo $vw['bgimage']; ?>">
          <div class="votw-logo"> <img src="<?php echo $vw['logo']; ?>" alt="Virtue of the Week" width="319" height="200" loading="lazy">
</div>
  <div class="frosted">
     <div class="votw-title"><?php echo $vw['title']; ?></div>
     <div>
<img class="votw-icon" src="<?php echo $vw['icon']; ?>" width="36" height="45" alt="<?php echo $vw['character']; ?>" loading="lazy">
        <p class="votw-characteristic"><?php echo $vw['characteristic']; ?></p>
        <p class="votw-content"><?php echo $vw['content']; ?></p>
        <blockquote><?php echo $vw['verse']; ?><span></span><cite><?php echo $vw['cite']; ?></cite></blockquote>
        <p class="votw-content">Challenge yourself to be aware of any and all opportunities to practice and apply <?php echo strtolower($vw['title']); ?> in your life this week, and the times you should have, but didn't because of the characteristic pride, vanity, envy, selfishness, ambition, lust, greed, desire for creature comfort and/or fear for survival of the carnal, instinctual, egoistic (self-centered) nature of your flesh.</p>
        <p><a href="https://leagueoftrue.love/virtues" aria-label="The 52 virtues of true love">All 52 Virtues</a></p>
     </div>
  </div>
</div>
