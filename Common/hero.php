<style>
 .hero-slider {
  position: relative;
  width: 100%;
  height: 500px;
  overflow: hidden;
}

.slider-item {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  transition: opacity 0.5s ease-in-out;
}

.slider-item.active {
  opacity: 1;
}

.slider-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.slider-item:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Change the opacity value (0.5) to adjust the transparency */
}

.inner {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

h1.focus-in-expand {
  font-size: 70px;
  margin: 0;
  width: 1400px;
  color: white;
}

div div hr {
  border: 2px solid;
  width: 800px;
  color: white;
}

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

/* Responsive Styles */

@media (max-width: 767px) {
  .hero-slider {
    height: 300px;
  }

  h1.focus-in-expand {
    font-size: 40px;
    width: 100%;
  }

  div div hr {
    width: 80%;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  .hero-slider {
    height: 400px;
  }

  h1.focus-in-expand {
    font-size: 50px;
    width: 100%;
  }

  div div hr {
    width: 60%;
  }
}

@media (min-width: 992px) {
  .hero-slider {
    height: 500px;
  }

  h1.focus-in-expand {
    font-size: 70px;
    width: 1400px;
  }

  div div hr {
    width: 800px;
  }
}

</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="hero-slider"></div>

<script>
  window.addEventListener("DOMContentLoaded", function () {
    const sliderData = [
      {
        imageUrl: "https://images.shiksha.com/mediadata/images/1599475415phpScz8NU.jpeg",
        altText: "Image 1"
      },
      {
        imageUrl: "https://images.shiksha.com/mediadata/images/1599475432phpDe15S1.jpeg",
        altText: "Image 2"
      },
      {
        imageUrl: "https://images.shiksha.com/mediadata/images/1599475387phpkrkpW8.jpeg",
        altText: "Image 3"
      }
    ];
    const slider = document.querySelector(".hero-slider");
    const sliderItems = [];
    let currentSlide = 0;

    function createSliderItem(slideData) {
  const item = document.createElement("div");
  item.classList.add("slider-item");
  const image = document.createElement("img");
  image.src = slideData.imageUrl;
  image.alt = slideData.altText;
  const inner = document.createElement("div");
  inner.classList.add("inner");
  const heading = document.createElement("h1");
  heading.classList.add("focus-in-expand");
  heading.textContent = "Bhagwan Mahavir University";
  const line = document.createElement("hr"); // Add horizontal line element
  const link = document.createElement("a");
  link.classList.add("nav-link");
  link.href = "/CMS/Admission_form/admissionform.php";
  const button = document.createElement("button");
  button.classList.add("btn-app");
  button.textContent = "Apply Now";

  link.appendChild(button);
  inner.appendChild(heading);
  inner.appendChild(line); // Add the horizontal line element after the heading
  inner.appendChild(link);
  item.appendChild(image);
  item.appendChild(inner);

  return item;
}


    function showSlide(index) {
      sliderItems.forEach(function (item) {
        item.classList.remove("active");
      });

      sliderItems[index].classList.add("active");
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % sliderItems.length;
      showSlide(currentSlide);
    }

    sliderData.forEach(function (slideData) {
      const item = createSliderItem(slideData);
      slider.appendChild(item);
      sliderItems.push(item);
    });

    showSlide(currentSlide);
    setInterval(nextSlide, 3500);
  });
</script>