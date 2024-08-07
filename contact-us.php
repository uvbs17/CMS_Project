<!doctype html>

<?php include('common/header.php'); ?>
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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

	<style>
		/* Make the container full width */
		/* Set background color and font family */
		body {
			background-color: #e2ecf4;
			font-family: Arial, sans-serif;
		}

		/* Style the container */
		.contact {
			background-color: #ffffff;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
			padding: 30px;
			margin: 50px auto;
			margin-top: 100px;
		}

		/* Style the headings */
		h2 {
			font-family: 'Montserrat', sans-serif;
			font-weight: 700;
			font-size: 36px;
			color: #07294d;
			margin-bottom: 30px;
		}

		h3 {
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 26px;
			color: #000;
		}


		/* Style the form inputs and textarea */
		.form-control {
			border-radius: 0;
			border: none;
			border-bottom: 2px solid #005daa;
			margin-bottom: 20px;
			box-shadow: none;
		}

		.form-control:focus {
			border-color: #007bff;
			box-shadow: none;
		}

		textarea.form-control {
			resize: none;
		}

		/* Style the submit button */
		.btn-primary {
			background-color: #005daa;
			border-color: #005daa;
			border-radius: 0;
		}

		.btn-primary:hover,
		.btn-primary:focus {
			background-color: #007bff;
			border-color: #007bff;
		}

		/* Style the contact information section */
		.col-md-6:last-child {
			margin-top: 20px;
		}

		.col-md-6:last-child p {
			margin-bottom: 10px;
		}

		.col-md-6:last-child i {
			color: #005daa;
			margin-right: 10px;
			font-size: 24px;
		}

		/* Adjust spacing on mobile devices */
		@media (max-width: 576px) {
			.container.contact {
				padding-top: 2rem;
				padding-bottom: 2rem;
				margin: 0;
			}

			h2 {

				text-align: center;
			}
		}

		.info {
			padding: 0px;
			margin: 20px auto;
			max-width: 800px;
		}

		/* Style the form */
		form {
			background-color: #f7f7f7;
			padding: 2rem;
			border-radius: 0.5rem;
		}

		form label {
			font-weight: bold;
		}

		form input,
		form textarea {
			margin-bottom: 1rem;
		}

		form button[type="submit"] {
			margin-top: 1rem;
		}

		/* Style error messages */
		.invalid-feedback {
			color: #dc3545;
			margin-top: 0.25rem;
			font-size: 0.9rem;
		}

		.add {
			margin-top: 50px;
		}


		.col-md-12 {
			margin-bottom: 10px;
		}

		.add,
		div div h3 {
			color: #07294d;
		}

		ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}

		li {
			margin-bottom: 10px;
		}

		a {
			text-decoration: none;
			color: inherit;
		}

		a:hover {
			color: black;
		}


		p {
			margin: 0 10px;
		}

		.fa-lg {
			font-size: 24px;
		}

		div h4 a {
			font-size: 18px;
		}

		i.fab.fa-lg {
			margin: 0px;
			padding: 5px 0px;
		}

		i.fab.fa-facebook.fa-lg {
			color: #1873eb;
		}

		i.fab.fa-instagram.fa-lg {
			background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
			-webkit-background-clip: text;
			/* Also define standard property for compatibility */
			background-clip: text;
			-webkit-text-fill-color: transparent;
			/* change this to change the size*/
		}

		i.fab.fa-twitter.fa-lg {
			color: #1D9BF0;
		}

		i.fab.fa-linkedin.fa-lg {
			color: #0A66C2;
		}

		div ul hr {
			width: 80%;
			margin: 4px auto 10px auto;
		}

		.form-control {
			border-radius: 5px 5px 0 0;
			font-size: 17px;
		}

		input.form-control {
			height: 45px;
		}

		p.text-justify {
			margin: 0;
		}

		div ul li {
			margin: 0;
		}

		button.btn.btn-primary {
			height: 50px;
			color: #FFFFFF;
			background-color: #07294D;
			font-family: Roboto, Sans-serif;
			font-weight: 500;
			padding: 15px 30px;
			font-size: 15px;
			line-height: 17px !important;
			overflow: hidden;
			border-radius: 3px;
			-webkit-transition: 0.4s ease-in-out;
			transition: 0.4s ease-in-out;
		}

		div div form {
			background-color: #f2f2f2;
		}

		iframe {
			border-radius: 10px;
		}
		div div h4 {
  margin: 0;
}
	</style>
	<title>Admission</title>
	<!-- css style go to end here -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<div class="container contact ">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<h2>Contact Us</h2>
				<form method="POST" action="send-mail.php" onsubmit="return validateForm()">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Name"
							pattern="[A-Za-z ]+" oninput="validateName()" required>
						<div id="name-error" class="invalid-feedback"></div>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email"
							pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" oninput="validateEmail()" required>
						<div id="email-error" class="invalid-feedback"></div>
					</div>
					<div class="form-group">
						<label for="subject">Subject</label>
						<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject"
							oninput="validateSubject()" required>
						<div id="subject-error" class="invalid-feedback"></div>
					</div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea class="form-control" id="message" name="message" rows="5" placeholder="Message"
							oninput="validateMessage()" required></textarea>
						<div id="message-error" class="invalid-feedback"></div>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
			<div class="col-md-6 col-sm-12">

				<div class="container info">
					<div class="">
						<div class="col-md-12">
							<h3 class="add">Address</h3>
							<ul>
								<li>Sr. No. 149, VIP Road, Bharthana Road, Vesu, Surat, Gujarat 395007.</li>
								<hr>
								<li><a href="mailto:info@bmusurat.ac.in">info@bmusurat.ac.in</a></li>
							</ul>
						</div>
						<div class="col-md-12">
							<h3>Helpdesk</h3>
							<h4><a href="tel:+912616770101">+91 26167 70101</a>, <a href="tel:+912616770102">02</a>, <a
									href="tel:+912616770103">03</a>, <a href="tel:+912616770104">04</a></h4>
						</div>
						<div class="col-md-12">
							<h3>Admissions Enquiry on Whatsapp</h3>
							<h4><a
									href="https://api.whatsapp.com/send?phone=+917575807374&text=Hi,%20I%20contacted%20you%20through%20your%20website">+91
									75758 07374</a></h4>
							<h4><a
									href="https://api.whatsapp.com/send?phone=+9175758073475&text=Hi,%20I%20contacted%20you%20through%20your%20website">+91
									75758 07375</a></h4>
						</div>
						<div class="col-md-12">
							<h3>Follow Us</h3>
							<div class="d-flex">
								<p><a href="https://www.facebook.com/BhagwanMahavirUniversity/"><i
											class="fab fa-facebook fa-lg"></i> </a></p>
								<p><a href="https://www.instagram.com/bhagwanmahaviruniversity/"><i
											class="fab fa-instagram fa-lg"></i> </a></p>
								<p><a href="https://twitter.com/bmusurat"><i class="fab fa-twitter fa-lg"></i> </a>
								</p>
								<p><a href="https://www.linkedin.com/company/bmusurat/"><i
											class="fab fa-linkedin fa-lg"></i> </a></p>
							</div>
							<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
								src="https://maps.google.com/maps?q=Sr.%20No.%20149%2C%20VIP%20Road%2C%20Bharthana%20Road%2C%20Vesu%2C%20Surat%2C%20Gujarat%20395007.&#038;t=m&#038;z=10&#038;output=embed&#038;iwloc=near"
								title="Sr. No. 149, VIP Road, Bharthana Road, Vesu, Surat, Gujarat 395007."
								aria-label="Sr. No. 149, VIP Road, Bharthana Road, Vesu, Surat, Gujarat 395007."
								height="200px" width="100%">
							</iframe>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php include('common/footer.php') ?>
	<script>
		function validateName() {
			let nameInput = document.getElementById('name');
			let nameError = document.getElementById('name-error');
			if (!nameInput.checkValidity()) {
				nameInput.classList.add('is-invalid');
				nameError.textContent = 'Please enter a valid name.';
			} else {
				nameInput.classList.remove('is-invalid');
				nameError.textContent = '';
			}
		}

		function validateEmail() {
			let emailInput = document.getElementById('email');
			let emailError = document.getElementById('email-error');
			if (!emailInput.checkValidity()) {
				emailInput.classList.add('is-invalid');
				emailError.textContent = 'Please enter a valid email address.';
			} else {
				emailInput.classList.remove('is-invalid');
				emailError.textContent = '';
			}
		}

		function validateSubject() {
			let subjectInput = document.getElementById('subject');
			let subjectError = document.getElementById('subject-error');
			if (!subjectInput.checkValidity()) {
				subjectInput.classList.add('is-invalid');
				subjectError.textContent = 'Please enter a subject.';
			} else {
				subjectInput.classList.remove('is-invalid');
				subjectError.textContent = '';
			}
		}

		function validateMessage() {
			let messageInput = document.getElementById('message');
			let messageError = document.getElementById('message-error');
			if (!messageInput.checkValidity()) {
				messageInput.classList.add('is-invalid');
				messageError.textContent = 'Please enter a message.';
			} else {
				messageInput.classList.remove('is-invalid');
				messageError.textContent = '';
			}
		}

		function validateForm() {
			validateName();
			validateEmail();
			validateSubject();
			validateMessage();
			return document.querySelectorAll('.is-invalid').length === 0;
		}
	</script>

	<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>