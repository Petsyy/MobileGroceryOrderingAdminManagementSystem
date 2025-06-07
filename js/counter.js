    document.addEventListener("DOMContentLoaded", () => {
      const counterContainer = document.querySelector(".counter-container");
      const counters = document.querySelectorAll(".counter-box span");

      setTimeout(() => {
        counterContainer.classList.add("visible");

        counters.forEach((counter, index) => {
          const parentBox = counter.closest(".counter-box");
          setTimeout(() => {
            parentBox.classList.add("visible");
          }, index * 150);
        });

        counters.forEach((counter) => {
          const target = parseInt(counter.textContent);
          counter.textContent = "0";
          animateCount(counter, target, 1500);
        });
      }, 300);

      function animateCount(el, target, duration) {
        const start = 0;
        const range = target - start;
        let current = start;
        const increment = target > start ? 1 : -1;
        const stepTime = Math.abs(Math.floor(duration / range));

        const timer = setInterval(() => {
          current += increment;
          el.textContent = current;
          if (current == target) {
            clearInterval(timer);
          }
        }, stepTime);
      }
});
