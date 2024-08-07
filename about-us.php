<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="32x32" href="/CMS/Images/fav.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/CMS/Images/fav.png">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/card.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .container_about {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }

        h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        p {
            font-size: 1em;
            line-height: 1.5em;
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            /* margin-bottom: 10px; */
        }

        .vision-image {
            max-width: 80%;
            display: block;
            margin: 0 auto;
        }

        .mission-list,
        .quality-objectives-list {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .mission-list li,
        .quality-objectives-list li {
            display: inline-block;
            width: 100%;
            margin-bottom: 10px;
        }

        .mission-list li:before,
        .quality-objectives-list li:before {
            content: "•";
            margin-right: 10px;
        }
    </style>
    <title>Admission</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
</head>

<body>
    <?php include('common/header.php') ?>
    <div class="container_about">
        <h1>Welcome to BMU</h1>
        <h2>About Us</h2>
        <p class="description">Bhagwan Mahavir University is committed to inclusion and innovation in education through
            philanthropy and pioneering initiatives. We provide world-class education and empowering opportunities for
            all sections of society. Our focus is on making students not just job-ready but also life-ready, fostering a
            continuous learning mindset and developing future-ready professionals.</p>
        <p class="description">We offer Undergraduate, Postgraduate, and Doctoral Programs in various fields such as
            Engineering, Pharmacy, Life and Basic Sciences, Business and Management, and Education. Our curriculum is
            industry-relevant and skills-oriented, promoting interdisciplinary studies.</p>
        <p class="description">At Bhagwan Mahavir University, we believe in inculcating the vital attitude of lifelong
            learning in our students. We provide ample opportunities for self-motivation, creativity, and a unique
            learning process that emphasizes self-leadership. Our learning environment nurtures life-building traits
            like dedication, commitment, hard work, reliability, sincerity, team spirit, and transparency.</p>
        <p class="description">We collaborate with the industry to ensure our faculty members and students have
            real-world impact through research. Our Central Placement Cell facilitates continuous interaction with the
            corporate world, understanding industry needs, and preparing students to meet industry expectations.</p>
        <h2>Vision</h2>
        <p class="description">To emerge as a "Centre For Excellence" offering quality technical education and research
            opportunities, preparing students for dynamic and global careers.</p>
        <img class="vision-image" src="https://bmusurat.ac.in/wp-content/uploads/2021/10/bmu_vision.jpg"
            alt="bmu_vision">
        <h2>Mission</h2>
        <ul class="mission-list">
            <li>To impart sound technical competency and quality education to enhance employability and ethical values.
            </li>
            <li>To continuously develop infrastructure and enhance state-of-the-art equipment.</li>
            <li>To collaborate with industry, government, and research institutions to achieve global excellence.</li>
            <li>To achieve overall excellence in education by continuously upgrading the teaching-learning process,
                contributing to the social and economic betterment of society.</li>
            <li>To focus on the multifaceted development of students, making them leaders in the global community.</li>
            <li>To provide an inspiring and stimulating environment that encourages knowledge acquisition, making our
                institute a preferred choice for knowledge seekers.</li>
        </ul>
        <h2>Quality Objectives</h2>
        <ul class="quality-objectives-list">
            <li>To facilitate teaching, research, and entrepreneurship in interdisciplinary areas encompassing
                engineering.</li>
            <li>To provide quality technical education.</li>
            <li>To prepare students to develop all-round competitiveness.</li>
            <li>To extend the frontiers of knowledge through research and development.</li>
            <li>To encourage creative talent and establish an epicenter of excellence in learning and research.</li>
            <li>To instill in students a sense of value and equip them to serve society well.</li>
        </ul>
    </div>
    <?php include('common/footer.php') ?>
    <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</body>

</html>