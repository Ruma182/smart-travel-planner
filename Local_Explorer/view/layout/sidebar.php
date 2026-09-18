<aside class="sidebar"><div class="brand"><div class="brand-icon">LE</div><div><h2>Local Explorer</h2><span>Smart Travel Planner</span></div></div><nav>
<a class="<?= (($page??'')==='dashboard')?'active':'' ?>" href="<?= pageUrl('dashboard') ?>">Dashboard</a>
<a class="<?= (($page??'')==='recommendation')?'active':'' ?>" href="<?= pageUrl('recommendation') ?>">Recommendations</a>
<a class="<?= (($page??'')==='travel_tip')?'active':'' ?>" href="<?= pageUrl('travel_tip') ?>">Travel Tips</a>
<a class="<?= (($page??'')==='destination_info')?'active':'' ?>" href="<?= pageUrl('destination_info') ?>">Destination Info</a>
<a class="<?= (($page??'')==='question_response')?'active':'' ?>" href="<?= pageUrl('question_response') ?>">Traveler Questions</a>
<a class="<?= (($page??'')==='feedback')?'active':'' ?>" href="<?= pageUrl('feedback') ?>">Feedback & Ratings</a>
</nav><a class="logout" href="<?= pageUrl('logout') ?>">Logout</a></aside>
