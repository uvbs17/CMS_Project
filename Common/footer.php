<style>
  .site-footer {
    background-color: #26272b;
    padding: 45px 0 20px;
    font-size: 15px;
    line-height: 24px;
    color: #737373;
  }

  .site-footer hr {
    border-top-color: #bbb;
    opacity: 0.5
  }

  .site-footer hr.small {
    margin: 20px 0
  }

  .site-footer h6 {
    color: #fff;
    font-size: 16px;
    text-transform: uppercase;
    margin-top: 5px;
    letter-spacing: 2px
  }

  .site-footer a {
    color: #737373;
  }

  .site-footer a:hover {
    color: #3366cc;
    text-decoration: none;
  }

  .footer-links {
    padding-left: 0;
    list-style: none
  }

  .footer-links li {
    display: block
  }

  .footer-links a {
    color: #737373
  }

  .footer-links a:active,
  .footer-links a:focus,
  .footer-links a:hover {
    color: #3366cc;
    text-decoration: none;
  }

  .footer-links.inline li {
    display: inline-block
  }

  .site-footer .social-icons {
    text-align: right
  }

  .site-footer .social-icons a {
    width: 40px;
    height: 40px;
    line-height: 40px;
    margin-left: 6px;
    margin-right: 0;
    border-radius: 100%;
    background-color: #33353d
  }

  .copyright-text {
    margin: 0
  }

  @media (max-width:991px) {
    .site-footer [class^=col-] {
      margin-bottom: 30px
    }
  }

  @media (max-width:767px) {
    .site-footer {
      padding-bottom: 0
    }

    .site-footer .copyright-text,
    .site-footer .social-icons {
      text-align: center
    }
  }

  .social-icons {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none
  }

  .social-icons li {
    display: inline-block;
    margin-bottom: 4px
  }

  .social-icons li.title {
    margin-right: 15px;
    text-transform: uppercase;
    color: #96a2b2;
    font-weight: 700;
    font-size: 13px
  }

  .social-icons a {
    background-color: #eceeef;
    color: #818a91;
    font-size: 16px;
    display: inline-block;
    line-height: 44px;
    width: 44px;
    height: 44px;
    text-align: center;
    margin-right: 8px;
    border-radius: 100%;
    -webkit-transition: all .2s linear;
    -o-transition: all .2s linear;
    transition: all .2s linear
  }

  .social-icons a:active,
  .social-icons a:focus,
  .social-icons a:hover {
    color: #fff;
    background-color: #29aafe
  }

  .social-icons.size-sm a {
    line-height: 34px;
    height: 34px;
    width: 34px;
    font-size: 14px
  }

  .social-icons a.facebook:hover {
    background-color: #3b5998
  }

  .social-icons a.twitter:hover {
    background-color: #00aced
  }

  .social-icons a.linkedin:hover {
    background-color: #007bb6
  }

  .social-icons a.instagram:hover {
    background-color: #ea4c89
  }

  @media (max-width:767px) {
    .social-icons li.title {
      display: block;
      margin-right: 0;
      font-weight: 600
    }
  }
</style>
<!-- Site footer -->
<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <h6>About</h6>
        <p class="text-justify"><b>Bhagwan Mahavir University</b> is committed to inclusion and innovation in education through philanthropy and pioneering initiatives. Bhagwan Mahavir University provides world class education and empowering opportunities for all sections of society. As the world of business and job opportunities are changing rapidly, we are evolving to make our students not just job ready but also life ready, to help them see learning as a continuous process and to become future- ready professionals.</p>
      </div>

      <div class="col-xs-6 col-md-3">
        <h6>Categories</h6>
        <ul class="footer-links">
          <li><a href="/">C</a></li>
          <li><a href="/">UI Design</a></li>
          <li><a href="/">PHP</a></li>
          <li><a href="/">Java</a></li>
          <li><a href="/">Android</a></li>
          <li><a href="/">Templates</a></li>
        </ul>
      </div>

      <div class="col-xs-6 col-md-3">
        <h6>Quick Links</h6>
        <ul class="footer-links">
          <li><a href="/CMS/about-us.php">About Us</a></li>
          <li><a href="/CMS/contact-us.php">Contact Us</a></li>
          <li><a href="/">Contribute</a></li>
          <li><a href="/">Privacy Policy</a></li>
          <li><a href="/">Sitemap</a></li>
        </ul>
      </div>
    </div>
    <hr>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-6 col-xs-12">
        <p class="copyright-text"></p>
      </div>
<script>
  const now = new Date();
  const currentYear = now.getFullYear();
  
  const copyrightText = document.querySelector('.copyright-text');
  copyrightText.innerHTML = `Copyright &copy; ${currentYear} All Rights Reserved by <a href="/CMS/">BMU</a>.`;
  
</script>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <ul class="social-icons">
          <li><a class="facebook" href="https://www.facebook.com/BhagwanMahavirUniversity/"><i class="fa fa-facebook"></i></a></li>
          <li><a class="twitter" href="https://twitter.com/bmusurat"><i class="fa fa-twitter"></i></a></li>
          <li><a class="instagram" href="https://www.instagram.com/bhagwanmahaviruniversity/"><i class="fa fa-instagram"></i></a></li>
          <li><a class="linkedin" href="https://www.linkedin.com/company/bmusurat/"><i class="fa fa-linkedin"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>