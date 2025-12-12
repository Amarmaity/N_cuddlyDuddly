
document.addEventListener('DOMContentLoaded', () => {
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('navbar');
const body = document.body;
if (hamburger && mobileNav) { 
hamburger.addEventListener('click', (e) => {
  e.stopPropagation();

  mobileNav.classList.toggle('open');
  body.classList.toggle('no-scroll');

  const icon = hamburger.querySelector('i');
  if (mobileNav.classList.contains('open')) {
    icon.classList.remove('fa-bars');
    icon.classList.add('fa-times');
  } else {
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
  }

});
}

document.addEventListener('click', (e) => {
  if (!mobileNav || !hamburger) return; 
  if (mobileNav.classList.contains('open') &&
    !mobileNav.contains(e.target) &&
    !hamburger.contains(e.target)) {

    mobileNav.classList.remove('open');
    body.classList.remove('no-scroll');

    const icon = hamburger.querySelector('i');
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
  }
});

document.querySelectorAll('.menu-btn').forEach(button => {
  button.addEventListener('click', function (e) {
    e.stopPropagation();

    const dropdown = this.nextElementSibling;

    // CLOSE all other main dropdowns
    document.querySelectorAll('.dropdown').forEach(d => {
      if (d !== dropdown) {
        d.classList.add('hidden');
        d.classList.remove('grid');
      }
    });

    // CLOSE all megadropdowns too
    document.querySelectorAll('.megadropdown').forEach(m => {
      m.classList.remove('stay');
    });

    // Toggle this dropdown
    dropdown.classList.toggle('hidden');
    dropdown.classList.toggle('grid');
  });
});

// Close everything when clicking outside
document.addEventListener('click', () => {
  document.querySelectorAll('.dropdown').forEach(drop => {
    drop.classList.add('hidden');
    drop.classList.remove('grid');
  });

  document.querySelectorAll('.megadropdown').forEach(m => {
    m.classList.remove('stay');
  });
});


// MEGAMENU
const megamenu = document.querySelectorAll('.megadown-items');
megamenu.forEach(item => {
  const dropdown = item.querySelector('.megadropdown');
  const toggleBtn = item.querySelector('.megalink');

  toggleBtn.addEventListener('click', e => {
    e.preventDefault();
    e.stopPropagation();

    // CLOSE all other megadropdowns
    document.querySelectorAll('.megadropdown').forEach(m => {
      if (m !== dropdown) {
        m.classList.remove('stay');
      }
    });

    // CLOSE all main dropdowns
    document.querySelectorAll('.dropdown').forEach(d => {
      d.classList.add('hidden');
      d.classList.remove('grid');
    });

    // Toggle this one
    dropdown.classList.toggle('stay');
  });
});
      const tabs = document.querySelectorAll('.tab-btn');
      const contents = document.querySelectorAll('.tab-item');
 if (tabs.length > 0) {
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const target = tab.dataset.tab;

          // Hide all content
          contents.forEach(c => c.classList.add('hidden'));

          // Show target content
          document.getElementById(target).classList.remove('hidden');
        });
      });

      // Show first tab by default
      tabs[0].click();
    }
        const ctx = document.getElementById('wavyChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'My Wavy Line',
                    data: [30000, 60000, 20000, 80000, 40000, 70000, 50000], // use real numbers for k formatting
                    borderColor: '#459B44',
                    borderWidth: 1,
                    fill: false,
                    tension: 0.5 // makes line wavy
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false } // hide legend
                },
                scales: {
                    y: {
                        display: true,
                        ticks: {
                            // format numbers as 10k, 20k, etc.
                            callback: function (value) {
                                return value / 1000 + 'k';
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false // hide vertical grid lines
                        }
                    }
                }
            }
        });
        // another chart js
         const tst = document.getElementById('myChart');

  new Chart(tst, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
        });
        

        /* ---------------------------------------------------
   DASHBOARD NAV (dashboard sidebar hamburger)
---------------------------------------------------- */
document.addEventListener("DOMContentLoaded", () => {
  const dashboardbar = document.getElementById('dashboardhamburger');
  const dashboardnav = document.getElementById('dashboardnav-wrapper');
  const page = document.body;

  // Only proceed if both elements exist
  if (!dashboardbar || !dashboardnav) return;

  // Toggle dashboard nav on click
  dashboardbar.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent the document click from immediately closing it
    dashboardnav.classList.toggle('show');
    page.classList.toggle('no-scroll');

    const icon = dashboardbar.querySelector('i');
    if (dashboardnav.classList.contains('show')) {
      icon.classList.remove('fa-bars');
      icon.classList.add('fa-times');
    } else {
      icon.classList.remove('fa-times');
      icon.classList.add('fa-bars');
    }
  });

  // Close dashboard nav when clicking outside
  document.addEventListener('click', (e) => {
    if (!dashboardnav.classList.contains('show')) return; // Already closed, do nothing

    if (!dashboardnav.contains(e.target) && !dashboardbar.contains(e.target)) {
      dashboardnav.classList.remove('show');
      page.classList.remove('no-scroll');

      const icon = dashboardbar.querySelector('i');
      if (icon) { // Safety check
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
    }
  });
});

document.querySelectorAll('.menu-btn').forEach(btn => {
  btn.addEventListener('mouseenter', () => {
    const dropdown = btn.nextElementSibling; // your dropdown div
    dropdown.classList.remove('left-0', 'right-0'); // reset any positioning

    const rect = dropdown.getBoundingClientRect();
    if (rect.right > window.innerWidth) {
      dropdown.classList.add('right-0');   // move dropdown inside
      dropdown.style.left = 'auto';
    } else {
      dropdown.classList.add('left-0');
      dropdown.style.right = 'auto';
    }
  });
});
