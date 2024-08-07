<style>
    @keyframes focus-in-expand {
  0% {
    letter-spacing: -0.5em;
    filter: blur(12px);
    opacity: 0;
  }
  100% {
    filter: blur(0px);
    opacity: 1;
  }
}

.focus-in-expand {
	animation: focus-in-expand 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
}
</style>
<header id="header" class="alt">
    <div class="inner">
        <h1 class="focus-in-expand">Bhagwan Mahavir University</h1>
        <a class="nav-link" href="/CMS/Admission_form/admissionform.php">
            <button class="btn-app">
                Apply Now
            </button>
        </a>
    </div>
</header>