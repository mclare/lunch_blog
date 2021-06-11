<?PHP
$expires = 60*60*6;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');

$descriptors = array('awesome','good','great','cool','tasty','worth having again','average','what I expected','smooth and sweet','food');

if (isset($_GET['t'])) $now = $_GET['t'];
else $now = time();

$day = 60 * 60 * 24;
$page_worth = $day * 9;
$limit = $now - $page_worth;
$pandemic_start = 1584374481;
$pandemic_end   = 9584374481;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Matt Clare's Lunch Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A blog of what Matt Clare eats for lunch">
    <meta name="author" content="Matt Clare">
    <meta itemprop="image" content="https://mattclare.ca/lunch-blog/images/lunch.jpg">
    <meta property="og:title" content="Matt Clare's Lunch Blog" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://mattclare.ca/lunch-blog" />
    <meta property="og:image" content="https://mattclare.ca/lunch-blog/images/lunch.jpg" />
    <meta property="og:site_name" content="Matt Clare's Lunch Blog" />


    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
	.hero-unit{
		background: #000 url('images/making_a_pb_b_j.jpg') no-repeat top center;
		color:#FFF;
		text-shadow: 3px 3px 3px #000;
	}
	.span4{
		min-height:400px;
	}
  .lunch {background: #E6E6E6 url('images/lunch.jpg') no-repeat;}
  .lunch-pandemic {background: #E6E6E6 url('images/pandemic-lunch-small.jpg') no-repeat;}
	.span4 h2 {background-color: #DDD;}
	.reflection{margin-top:310px;height:60px;background: #E6E6E6;font-size:125%}
	footer {text-align:center;}
    </style>

<?PHP

$styles =array("background-position: left center;","background-position: left;","background-position: right bottom;","background-position: right top;","background-position: center bottom;");
?>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico">

  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Lunch Blog</a>

		 <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="https://mattclare.ca/blog">mattclare.ca/blog</a></li>
              <li><a href="https://twitter.com/mattclare">@mattclare</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Matt Clare's Lunch Blog</h1>
        <p>There's always interest in what I have for lunch.  I created this blog to share and reflect on what I enjoy for lunch each workday.</p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
		<?PHP
		$j = 0; //For storing the position of the last random description
		for ($i = $now;$i > $limit; $i-= $day) {


			if (date('l',$i) == 'Saturday' || date('l',$i) == 'Sunday') $limit -= $day;
			else {
				if ($now == $i && date('H') < 12) {}
				else {

				$t = floor(rand(0,count($descriptors)-1));

				while ($j == $t) {
					$t = floor(rand(0,count($descriptors)-1));
				}
				$j = $t;

				echo " <div class=\"span4";
        if ($now > $pandemic_start && $now < $pandemic_end ) echo " lunch-pandemic";
        else echo " lunch";
        echo "\" style=\"".$styles[floor(rand(0,count($styles)))]."\">
			          <h2>".date("F j, Y",$i)."</h2>
                <div class=\"reflection\">A picture of my lunch from ".date('l',$i).". It was $descriptors[$j].</div>
			       </div>";
			}
			}

		}

		?>
      </div>
      <hr />
      <footer>
        <p>A <a href="https://mattclare.ca">MattClare.ca</a> project.  You might want to read my non-food blog at <a href="https://mattclare.ca/blog">mattclare.ca/blog</a> or follow me on Twitter as <a href="https://twitter.com/mattclare">@mattclare</a>.</p>
		<?PHP
    $previous_month = strtotime(date("Y-n-j",$now).' last day of previous month');
    $next_month = strtotime(date("Y-n-j",$now).' first day of next month');

		echo "<p><a href=\"$_SERVER[PHP_SELF]?t=$previous_month\" class=\"btn btn-primary\"  role=\"button\">Previous Month</a> <a href=\"$_SERVER[PHP_SELF]?t=$limit\" class=\"btn btn-primary\"  role=\"button\">10 Older Posts</a>";
		if ($now <= time()-1) {
  	$next = $now + $page_worth + $day;
      if ($next_month > time() || $next > time()) {
          $next_month = time();
          $next = time();
        }
		echo " | <a href=\"$_SERVER[PHP_SELF]?t=$next\" class=\"btn btn-primary\"  role=\"button\">10 Newer Posts</a> <a href=\"$_SERVER[PHP_SELF]?t=$next_month\" class=\"btn btn-primary\"  role=\"button\">Next Month</a>";
		};
		?>
		</p>
      </footer>

    </div> <!-- /container -->

<?PHP
@include('../inc/code.php');
@google_track(); ?>
  </body>
</html>
