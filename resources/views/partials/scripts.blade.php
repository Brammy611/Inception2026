<script>
(function() {
  // Home section detection
  if (document.querySelector('section.home')) {
    document.body.classList.add('home');
  }

  // Nav menu toggle
  const btn = document.getElementById('navToggle');
  const links = document.getElementById('navLinks');
  if (btn && links) {
    btn.addEventListener('click', function() {
      const open = links.classList.toggle('open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // ==== ORGANIZATION CAROUSEL ====
  document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".carousel-track");
    const slides = Array.from(document.querySelectorAll(".carousel-slide"));
    const prevBtn = document.querySelector(".nav-button.prev");
    const nextBtn = document.querySelector(".nav-button.next");
    const dots = Array.from(document.querySelectorAll(".carousel-dots .dot"));

    if (!track || slides.length === 0) return;

    let currentIndex = 0;

    function updateCarousel(index) {
      if (index < 0) index = slides.length - 1;
      if (index >= slides.length) index = 0;

      track.style.transform = `translateX(-${index * 100}%)`;
      slides.forEach((s, i) => s.classList.toggle("active", i === index));
      dots.forEach((d, i) => d.classList.toggle("active", i === index));

      currentIndex = index;
    }

    if (prevBtn) prevBtn.addEventListener("click", () => updateCarousel(currentIndex - 1));
    if (nextBtn) nextBtn.addEventListener("click", () => updateCarousel(currentIndex + 1));

    dots.forEach((dot, i) => {
      dot.addEventListener("click", () => updateCarousel(i));
    });

    setInterval(() => updateCarousel(currentIndex + 1), 5000);

    updateCarousel(0);
  });
})();
</script>

<script>
  const trailContainer = document.createElement("div");
  trailContainer.style.position = "fixed";
  trailContainer.style.top = "0";
  trailContainer.style.left = "0";
  trailContainer.style.width = "100%";
  trailContainer.style.height = "100%";
  trailContainer.style.pointerEvents = "none";
  trailContainer.style.overflow = "hidden";
  trailContainer.style.zIndex = "9999";
  document.body.appendChild(trailContainer);

  window.addEventListener("mousemove", (e) => {
    const rocket = document.createElement("div");
    rocket.className = "rocket-trail";
    rocket.style.left = e.clientX + "px";
    rocket.style.top = e.clientY + "px";
    trailContainer.appendChild(rocket);

    setTimeout(() => {
      rocket.remove();
    }, 1200);
  });
</script>

<script>
  const cursor = document.createElement('div');
  cursor.classList.add('cursor-rocket');
  document.body.appendChild(cursor);

  document.addEventListener('mousemove', e => {
    cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
  });
</script>

<script>
  document.querySelectorAll('.event-card').forEach(card => {
    const inner = card.querySelector('.event-inner');

    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width - 0.5;
      const y = (e.clientY - rect.top) / rect.height - 0.5;
      inner.style.transform = `rotateY(${x * 20}deg) rotateX(${-y * 20}deg) translateY(-8px) scale(1.05)`;
    });

    card.addEventListener('mouseleave', () => {
      inner.style.transform = '';
    });
  });
</script>

<script>
  // Smooth scroll progress
  const wrapper = document.getElementById('timelineWrapper');
  const progress = document.getElementById('timelineProgress');
  const scrollIndicator = document.querySelector('.scroll-indicator');

  if (wrapper && progress) {
    wrapper.addEventListener('scroll', () => {
      const scrollLeft = wrapper.scrollLeft;
      const maxScroll = wrapper.scrollWidth - wrapper.clientWidth;
      const percentage = (scrollLeft / maxScroll) * 100;
      progress.style.width = percentage + '%';

      if (scrollIndicator) {
        if (scrollLeft > 50) {
          scrollIndicator.style.opacity = '0';
        } else {
          scrollIndicator.style.opacity = '0.6';
        }
      }
    });

    // Drag to scroll functionality
    let isDown = false;
    let startX;
    let scrollLeft;

    wrapper.addEventListener('mousedown', (e) => {
      isDown = true;
      startX = e.pageX - wrapper.offsetLeft;
      scrollLeft = wrapper.scrollLeft;
    });

    wrapper.addEventListener('mouseleave', () => {
      isDown = false;
    });

    wrapper.addEventListener('mouseup', () => {
      isDown = false;
    });

    wrapper.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - wrapper.offsetLeft;
      const walk = (x - startX) * 2;
      wrapper.scrollLeft = scrollLeft - walk;
    });
  }

  // Intersection Observer for animation
  const observerOptions = {
    threshold: 0.3,
    rootMargin: '0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
      }
    });
  }, observerOptions);

  document.querySelectorAll('.timeline-item').forEach(item => {
    observer.observe(item);
  });
</script>

<script>
  // Back to top button functionality
  const backToTop = document.getElementById('backToTop');

  if (backToTop) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        backToTop.classList.add('visible');
      } else {
        backToTop.classList.remove('visible');
      }
    });

    backToTop.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // Add ripple effect on social icons
  document.querySelectorAll('.footer-social').forEach(social => {
    social.addEventListener('mouseenter', function(e) {
      const ripple = document.createElement('span');
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;
      
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = x + 'px';
      ripple.style.top = y + 'px';
      ripple.classList.add('ripple');
      
      this.appendChild(ripple);
      
      setTimeout(() => ripple.remove(), 600);
    });
  });
</script>