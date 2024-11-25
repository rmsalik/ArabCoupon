


  // JavaScript to handle the dropdown toggle
      const countryDropdown = document.getElementById('countryDropdown');
        const countryMenu = document.getElementById('countryMenu');
        const selectedCountry = document.getElementById('selectedCountry');
        const selectedFlag = document.getElementById('selectedFlag');

        // Toggle menu display on button click
        countryDropdown.addEventListener('click', () => {
            countryMenu.classList.toggle('show');
        });

        // Handle country selection
        document.querySelectorAll('.country-option').forEach(option => {
            option.addEventListener('click', () => {
                const countryName = option.getAttribute('data-country');
                const flagSrc = option.getAttribute('data-flag');

                // Update button text and flag
                selectedCountry.textContent = countryName;
                selectedFlag.src = flagSrc;
                selectedFlag.style.display = 'inline'; // Show the flag image

                // Hide menu after selection
                countryMenu.classList.remove('show');
            });
        });

        // Close the menu if clicked outside
        document.addEventListener('click', (event) => {
            if (!countryDropdown.contains(event.target) && !countryMenu.contains(event.target)) {
                countryMenu.classList.remove('show');
            }
        });

  



        // Mobile navbar js start
        document.querySelectorAll('.nav-item.dropdown').forEach(function (dropdown) {
            const chevronRight = dropdown.querySelector('.chevron-right');
            const dropdownAfter = dropdown.querySelector('.dropdown-after');
        
            dropdown.querySelector('.nav-link').addEventListener('click', function (e) {
              e.preventDefault(); // Prevent default behavior for the link
        
              if (dropdownAfter.classList.contains('d-none')) {
                // Show the dropdown-after image and hide the chevron-right
                chevronRight.classList.add('d-none');
                dropdownAfter.classList.remove('d-none');
              } else {
                // Revert back to chevron-right and hide dropdown-after
                chevronRight.classList.remove('d-none');
                dropdownAfter.classList.add('d-none');
              }
            });
          });
        // Mobile navbar js End