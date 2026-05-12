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

  // ==== SCROLL SPY - Navbar Active Indicator ====
  document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector('.navbar');
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-links .nav-link');
    
    // Navbar blur effect on scroll
    function handleNavbarBlur() {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    }
    
    // Smooth scroll for anchor links (hanya untuk link internal di halaman yang sama)
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        // Cek apakah link menuju section di halaman ini (dimulai dengan #)
        // atau link ke halaman lain (mengandung route)
        if (href.includes('{{ route("home") }}')) {
          // Link ke homepage dengan anchor - biarkan browser handle redirect
          return; // Tidak preventDefault, biarkan link bekerja normal
        }
        
        // Untuk link internal (#home, #about, dll) di halaman yang sama
        if (href.startsWith('#')) {
          e.preventDefault();
          const targetId = href.substring(1);
          const targetSection = document.getElementById(targetId);
          
          if (targetSection) {
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const targetPosition = targetSection.offsetTop - navbarHeight - 20;
            
            window.scrollTo({
              top: targetPosition,
              behavior: 'smooth'
            });
          }
        }
      });
    });

    // Update active state on scroll
    function updateActiveNavOnScroll() {
      const scrollPosition = window.scrollY + 150;
      
      let currentSection = '';
      
      // Find current section
      sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
          currentSection = section.getAttribute('id');
        }
      });
      
      // Special case: organization section dianggap sebagai bagian dari about
      if (currentSection === 'organization') {
        currentSection = 'about';
      }
      
      // Update active class
      navLinks.forEach(link => {
        link.classList.remove('active');
        const linkSection = link.getAttribute('data-section');
        
        if (linkSection === currentSection) {
          link.classList.add('active');
        }
      });
    }
    
    // Throttle scroll event for performance
    let scrollTimeout;
    window.addEventListener('scroll', () => {
      if (scrollTimeout) {
        window.cancelAnimationFrame(scrollTimeout);
      }
      scrollTimeout = window.requestAnimationFrame(() => {
        updateActiveNavOnScroll();
        handleNavbarBlur();
      });
    });
    
    // Run on page load
    updateActiveNavOnScroll();
    handleNavbarBlur();
  });

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
  // ==== TIMELINE LIGHTING SYSTEM ====
  // Sistem lampu progressif untuk timeline numbers dengan delay dan animasi
  const wrapper = document.getElementById('timelineWrapper');
  
  if (wrapper) {
    const timelineItems = document.querySelectorAll('.timeline-item');
    const timelineNumbers = document.querySelectorAll('.timeline-number');
    let lightingTimeout = null;
    
    // Fungsi untuk mengecek apakah element terlihat di viewport
    function isElementVisible(el, container) {
      const containerRect = container.getBoundingClientRect();
      const elementRect = el.getBoundingClientRect();
      
      // Element dianggap visible jika sebagian atau seluruhnya terlihat dalam container
      const isVisible = (
        elementRect.left < containerRect.right &&
        elementRect.right > containerRect.left
      );
      
      return isVisible;
    }
    
    // Fungsi untuk update status lampu dengan delay dan animasi
    function updateTimelineLights() {
      // Clear timeout sebelumnya jika ada
      if (lightingTimeout) {
        clearTimeout(lightingTimeout);
      }
      
      // Delay 1 detik sebelum update
      lightingTimeout = setTimeout(() => {
        const visibleIndices = [];
        
        // Deteksi timeline items yang terlihat
        timelineItems.forEach((item, index) => {
          if (isElementVisible(item, wrapper)) {
            visibleIndices.push(index + 1); // +1 karena index mulai dari 0
          }
        });
        
        // Tentukan nomor maksimal yang harus menyala
        const maxVisibleIndex = Math.max(...visibleIndices, 0);
        
        // Update semua timeline numbers dengan staggered animation
        timelineNumbers.forEach((numberEl, index) => {
          const currentNumber = index + 1;
          
          // Logika: semua nomor <= maxVisibleIndex akan menyala
          if (currentNumber <= maxVisibleIndex) {
            // Tambahkan delay berbeda untuk setiap nomor (staggered effect)
            setTimeout(() => {
              numberEl.classList.add('active');
            }, (currentNumber - 1) * 80); // 80ms delay antar nomor - lebih cepat!
          } else {
            numberEl.classList.remove('active');
          }
        });
        
        // Jika tidak ada yang visible, tetap nyalakan yang pertama
        if (maxVisibleIndex === 0) {
          if (timelineNumbers[0]) {
            setTimeout(() => {
              timelineNumbers[0].classList.add('active');
            }, 80);
          }
        }
      }, 200); // 200ms delay - jauh lebih responsif!
    }
    
    // Update saat scroll dalam timeline wrapper
    wrapper.addEventListener('scroll', updateTimelineLights);
    
    // Drag to scroll functionality
    let isDown = false;
    let startX;
    let scrollLeft;

    wrapper.addEventListener('mousedown', (e) => {
      isDown = true;
      wrapper.style.cursor = 'grabbing';
      startX = e.pageX - wrapper.offsetLeft;
      scrollLeft = wrapper.scrollLeft;
    });

    wrapper.addEventListener('mouseleave', () => {
      isDown = false;
      wrapper.style.cursor = 'grab';
    });

    wrapper.addEventListener('mouseup', () => {
      isDown = false;
      wrapper.style.cursor = 'grab';
    });

    wrapper.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - wrapper.offsetLeft;
      const walk = (x - startX) * 2;
      wrapper.scrollLeft = scrollLeft - walk;
    });
    
    // Touch support untuk mobile
    let touchStartX = 0;
    let touchScrollLeft = 0;
    
    wrapper.addEventListener('touchstart', (e) => {
      touchStartX = e.touches[0].pageX - wrapper.offsetLeft;
      touchScrollLeft = wrapper.scrollLeft;
    });
    
    wrapper.addEventListener('touchmove', (e) => {
      const x = e.touches[0].pageX - wrapper.offsetLeft;
      const walk = (x - touchStartX) * 2;
      wrapper.scrollLeft = touchScrollLeft - walk;
    });
    
    // Initial update
    updateTimelineLights();
    
    // Update saat window resize
    window.addEventListener('resize', updateTimelineLights);
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