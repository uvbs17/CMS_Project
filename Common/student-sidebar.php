<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,600,1,0" /> -->
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <style>
  .ham {
    display: none;
    margin-bottom: -20px;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    transition: transform 400ms;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  .hamRotate.active2 {
    transform: rotate(45deg);
  }

  .hamRotate180.active2 {
    transform: rotate(180deg);
  }

  .line {
    fill: none;
    transition: stroke-dasharray 400ms, stroke-dashoffset 400ms;
    stroke: #000;
    stroke-width: 5.5;
    stroke-linecap: round;
  }

  .ham1 .top {
    stroke-dasharray: 40 139;
  }

  .ham1 .bottom {
    stroke-dasharray: 40 180;
  }

  .ham1.active2 .top {
    stroke-dashoffset: -98px;
  }

  .ham1.active2 .bottom {
    stroke-dashoffset: -138px;
  }

  button {
    background: transparent;
    border: 0;
    padding: 0;
    cursor: pointer;
    text-align: left;
  }

  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 240px;
    height: 100%;
    /* background: #211f25; */
    background: #f8f9fa;
    transition: width 0.4s;
  }

  .sidebar header {

    display: flex;
    align-items: center;
    /* height: 72px; */
    /* padding: 0 1.25rem 0 0; */
    /* border-bottom: 1px solid rgb(255 255 255 / 12%); */
  }

  .sidebar header button {
    margin-top: 10;
  }

  .sidebar button {
    position: relative;
    display: flex;
    gap: 16px;
    align-items: center;
    height: 50px;
    width: 100%;
    font-family: inherit;
    font-size: 16px;
    font-weight: 400;
    line-height: 1;
    padding: 0 16px 0 25px;
    /* color: #f7f7f7; */
    color: #211f25;
    transition: 0.25s;
  }

  .sidebar button.active,
  .subnav {
    background: #1f5b6e;
    color: #f7f7f7;
  }

  .sidebar button:hover {
    background: #3c3a48;
    color: #f7f7f7;
  }

  .sidebar button span:nth-child(2) {
    flex: 1 1 auto;
  }

  .sidebar button.active span:nth-child(3) {
    rotate: -180deg;
  }

  .sub-nav button.active::before {
    background: #f9f9f9;
  }

  .subnav {
    position: relative;
    overflow: hidden;
    height: 0;
    transition: 0.4s;
  }

  .subnav-inner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
  }

  .subnav button {
    padding-left: 64px;
    color: #f7f7f7;
  }

  .subnav button::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 36px;
    translate: 0 -50%;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background-color: rgb(255 255 255 / 40%);
  }

  .material-symbols-outlined {
    font-size: 22px;
    transition: 0.3s;
  }

  @media screen and (max-width: 1200px) {

  

    
    header{
      
      margin-top: -20;
    }

    .sidebar {
      position: relative;
      width: 100%;
      height: auto;
      display: none;
      /* background: #211f25; */
      background: #f8f9fa;
      transition: width 0.4s;
    }

    .ham1 {
      display: block;
    }

  }


  /* Target phones */

  @media only screen and (max-width: 480px) {

    /* CSS rules here */
  
    
    header{
      
      margin-top: -20;
    }

    .sidebar {
      position: relative;
      /* top: 0; */
      left: 0;
      width: 100%;
      height: auto;
      display: none;
      /* background: #211f25; */
      background: #f8f9fa;
      transition: width 0.4s;
    }

    .ham1 {
      display: block;
    }
  }
</style>
<svg class="ham hamRotate ham1" viewBox="0 0 100 100" width="80" onclick="this.classList.toggle('active2')">
  <path class="line top"
    d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40" />
  <path class="line middle" d="m 30,50 h 40" />
  <path class="line bottom"
    d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40" />
</svg>
<aside class="sidebar">
  <header>
    <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/student/student-index.php") ? 'active' : ''; ?>"
      onclick="window.location.href = '../student/student-index.php';">
      <span class="material-symbols-outlined"> home </span>
      <span>Dashboard</span>
    </button>
  </header>
  <!-- <button
    class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Student.php") ? 'active' : ''; ?> <?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Teacher.php") ? 'active' : ''; ?>"
    onclick="handleHeaderClicked('tools')">
    <span class="material-symbols-outlined"> group </span>
    <span>Registration</span>
    <span class="material-symbols-outlined"> expand_more </span>
  </button>
  <div id="tools" class="subnav">
    <div class="subnav-inner">
      <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Student.php") ? 'active' : ''; ?>"
        onclick="window.location.href = '/CMS/dept_admin/Student.php';">
        <span>Student Registration</span>
      </button>
      <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Teacher.php") ? 'active' : ''; ?>"
        onclick="window.location.href = '/CMS/dept_admin/Teacher.php';">
        <span>Teacher Registration</span>
      </button>
    </div>
  </div>
  <button
    class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Student-attendance.php") ? 'active' : ''; ?> <?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Teacher-attendance.php") ? 'active' : ''; ?>"
    onclick="handleHeaderClicked('settings')">
    <span class="material-symbols-outlined">
      how_to_reg
    </span>
    <span>Attendance</span>
    <span class="material-symbols-outlined"> expand_more </span>
  </button>
  <div id="settings" class="subnav">
    <div class="subnav-inner">
      <button
        class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Student-attendance.php") ? 'active' : ''; ?>"
        onclick="window.location.href = '/CMS/dept_admin/Student-attendance.php';">
        <span>Student Attnedance</span>
      </button>
      <button
        class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/dept_admin/Teacher-attendance.php") ? 'active' : ''; ?>"
        onclick="window.location.href = '/CMS/dept_admin/Teacher-attendance.php';">
        <span>Teacher Attendance</span>
      </button>
    </div>
  </div> -->
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/student/student-personal-information.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/student/student-personal-information.php';">
    <span class="material-symbols-outlined">
      info
    </span>
    <span>Personal Information</span>
  </button>
  <!-- <button class="<?php //echo ($_SERVER['REQUEST_URI'] == "/CMS/student/student-result.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/student/student-result.php';">
    <span class="material-symbols-outlined">
description
</span>
    <span>Student Results</span>
  </button> -->
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/student/allnotification.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/student/allnotification.php';">
    <span class="material-symbols-outlined">
notifications
</span>
    <span>Announcement</span>
  </button>
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/student/student-fee.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/student/student-fee.php';">
    <span class="material-symbols-outlined">
credit_card
</span>
    <span>Student Fee</span>
  </button>
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/student/student-password.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/student/student-password.php';">
    <span class="material-symbols-outlined">
password
</span>
    <span>Change Password</span>
  </button>
  
</aside>
<script>
  const subNavs = document.querySelectorAll(`.subnav`);
  const buttons = document.querySelectorAll(`.sidebar button`);

  const resetSidebar = () => {
    subNavs.forEach((nav) => {
      nav.style.height = 0;
    });

    buttons.forEach((b) => {
      b.classList.remove("active");
    });
  };

  const handleHeaderClicked = (subNav) => {
    resetSidebar();

    const subNavOuter = document.querySelector(`#${subNav}`),
      subNavInner = document.querySelector(`#${subNav} .subnav-inner`),
      button = subNavOuter.previousElementSibling;

    if (subNavOuter.clientHeight > 0) {
      subNavOuter.style.height = 0;
      button.classList.remove("active");
      return;
    }

    button.classList.toggle("active");
    const newHeight = `${subNavInner.clientHeight}px`;
    subNavOuter.style.height = newHeight;
  };

</script>
<script>
  var hamburger = document.querySelector('.ham');
  var sidebar = document.querySelector('.sidebar');

  var clickCount = 0;

  hamburger.addEventListener('click', function() {
    clickCount++;


    if (clickCount % 2 == 0) {
      sidebar.style.display = "none";

    } else {
      sidebar.style.display = "block";
    }
  });
</script>