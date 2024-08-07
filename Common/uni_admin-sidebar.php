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
    header {

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


    header {

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
    <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/uni_admin/uni_admin-index.php") ? 'active' : ''; ?>"
      onclick="window.location.href = '../uni_admin/uni_admin-index.php';">
      <span class="material-symbols-outlined"> home </span>
      <span>Dashboard</span>
    </button>
</header>
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/uni_admin/stream.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/uni_admin/stream.php';">
    <span class="material-symbols-outlined">
      domain_add
    </span>
    <span>Streams</span>
  </button>
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/uni_admin/department.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/uni_admin/department.php';">
    <span class="material-symbols-outlined">
      apartment
    </span>
    <span>Departments</span>
  </button>
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/uni_admin/admin.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/uni_admin/admin.php';">
    <span class="material-symbols-outlined">
      account_box
    </span>
    <span>Admins</span>
  </button>
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/uni_admin/notification.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/uni_admin/notification.php';">
    <span class="material-symbols-outlined">
      notifications
    </span>
    <span>Notification</span>
  </button>
  <button class="<?php echo ($_SERVER['REQUEST_URI'] == "/CMS/uni_admin/adduniadmin.php") ? 'active' : ''; ?>"
    onclick="window.location.href = '/CMS/uni_admin/adduniadmin.php';">
    <span class="material-symbols-outlined"> account_circle </span>
    <span>Add Uniadmin</span>
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

  hamburger.addEventListener('click', function () {
    clickCount++;


    if (clickCount % 2 == 0) {
      sidebar.style.display = "none";

    } else {
      sidebar.style.display = "block";
    }
  });
</script>