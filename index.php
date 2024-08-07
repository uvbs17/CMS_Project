<!doctype html>
<?php ?>

<html lang="en">

<head>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" sizes="32x32" href="/CMS/Images/fav.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/CMS/Images/fav.png">

	<!-- css style goes here -->

	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/card.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style>
		button.btn-app {
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}


		div.card__background {
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		button.btn-app {
			--primary-color: #3974a7;
			--secondary-color: #fff;
			--hover-color: #111;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
			border: 0;
			border-radius: 20px;
			color: var(--secondary-color);
			transition: transform 0.5s;
			padding: 1em 1.8em;
			background: var(--primary-color);
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-align: center;
			-ms-flex-align: center;
			align-items: center;
			gap: 0.6em;
			font-weight: bold;
		}

		#fac {
			scroll-snap-align: start;
			scroll-margin-top: 70px;

		}


		button.btn-app:hover {
			background-color: var(--hover-color);
			transform: scale(1.1);
		}


		header.alt {
			display: grid;
		}

		header div button {
			margin: auto;
			border-radius: 15px;
		}

		.w-100.in-ad-ap {
			background-color: #1f5b6e;
			padding: 10px;
		}

		.row.m-auto.text-center>.col-md-4>a {
			text-decoration: none;
		}

		.cardtes {
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			border: 2px solid white;
			margin: 10px;
			padding: 10px;
			border-radius: 15px;
			color: white;
			font-size: 24px;
			font-weight: bold;
			text-transform: uppercase;
		}

		.cardtes:hover {
			cursor: pointer;
			background-color: white;
			color: #1f5b6e;
		}
	</style>

	<title>Home</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include "common/header.php"; ?>
	<?php include "common/hero.php"; ?>
	<div style=" background-color: #1f5b6e; padding: 10px;" class="w-100 in-ad-ap">
		<div class="row m-auto text-center">
			<div class="col-md-4">
				<a style="text-decoration: none;" href="#about">
					<h3 class="cardtes"
						style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border: 2px solid white; margin: 10px;padding: 10px; border-radius: 15px;">
						ABOUT US</h3>
				</a>
			</div>

			<div class="col-md-4">
				<a style="text-decoration: none;" href="/CMS/Admission_form/admissionform.php">
					<h3 class="cardtes"
						style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border: 2px solid white; margin: 10px; padding: 10px; border-radius: 15px;">
						APPLY NOW</h3>
				</a>
			</div>

			<div class="col-md-4">
				<a style="text-decoration: none;" href="#fac">
					<h3 class="cardtes"
						style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border: 2px solid white;margin: 10px;padding: 10px; border-radius: 15px;">
						FACULTIES</h3>
				</a>
			</div>
		</div>
	</div>
	<div id="about" style="background: url(https://image.ibb.co/mJ9tLa/image.png)center no-repeat fixed;
  background-color: #212121;
  background-blend-mode: overlay;
  background-position: center;
  background-size: cover;
  text-align: center;" class="aboutcard">
		<h1 style="color: whitesmoke;
  font-family: 'Exo 2', sans-serif;
  font-size: 46px;
  font-weight: 900;
  text-transform: uppercase;">
			ABOUT US
			<br>
			<img src="https://image.ibb.co/nk616F/Layer_1_copy_21.png" width="47" height="11">
		</h1>
		<article>
			<p style="max-width: 700px;
  min-height: 200px;
  padding: 0;
  margin: 20px;
  scroll-margin-top: 1000px;
  color: whitesmoke;
  font-family: Arial, sans-serif;
  font-size: 20px;
  font-weight: 300;
  line-height: 22px;">
				Bhagwan Mahavir University is committed to inclusion and innovation in education through philanthropy
				and pioneering initiatives.
				Bhagwan Mahavir University provides world class education and empowering opportunities for all sections
				of society. As the world of
				business and job opportunities are changing rapidly, we are evolving to make our students not just job
				ready but also life ready, to
				help them see learning as a continuous process and to become future- ready professionals.


			</p>
		</article>
	</div>
	<?php include "common/cards.php"; ?>
	<?php include "common/footer.php"; ?>

	<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script src="//code.tidio.co/sfpljtweovefrq2sz5uu7bmgnd6s0mpa.js" async></script>
</body>

</html>