// navbar
document.querySelectorAll('.navbar-nav .nav-link').forEach(item => {
    item.addEventListener('click', () => {
        document.querySelector('.navbar-collapse').classList.remove('show');
    });
});

// const navbar = document.getElementById("navbar");

//             let lastScrollTop = 0;
//             addEventListener("scroll", () => {
//                 // Current scroll position
//                 const scrollTop =
//                     window.pageYOffset || document.documentElement.scrollTop;

//                 // check scroll direction
//                 const distance = scrollTop - lastScrollTop;
//                 const currentTop = parseInt(
//                     getComputedStyle(navbar).top.split("px")
//                 );

//                 // Clamp value between -80 and 0
//                 let amount = Math.max(
//                     Math.min(
//                         currentTop +
//                             (distance < 0
//                                 ? Math.abs(distance) // scrolling up
//                                 : -Math.abs(distance)// scrolling down
//                                 ) * 40, // (1)
//                         0
//                     ),
//                     -80
//                 );

//                 console.log(amount, currentTop, Math.abs(distance));

//                 navbar.style.top = `${amount}px`;

//                 lastScrollTop = scrollTop;
//             });

// form input tel
function allowNumbersOnly(event) {
    // Get the keycode of the pressed key
    var keycode = event.keyCode || event.which;
    
    // Allow only numeric keys (0-9), Backspace, Delete, Tab, and arrow keys
    if ((keycode < 48 || keycode > 57) && keycode !== 8 && keycode !== 9 && keycode !== 46 && (keycode < 37 || keycode > 40)) {
        // Prevent default action (typing the key)
        event.preventDefault();
    }
}


// wheels
const container = document.getElementById('image-list');

function scrollImages(direction) {
  container.scrollLeft += direction * 150; // Adjust 150 as needed for scroll distance
}
// update car
function updateCar(newWheelSrc) {
    // Update the URL with the new wheel image
    const carImage = document.getElementById("vehicle-image");
    carImage.src = newWheelSrc;
  }

  //products submit
  document.getElementById('product_image').addEventListener('change', function() {
    var submitBtn = document.getElementById('submitBtn');
    var fileInput = this;
    var filePath = fileInput.value;

    // Allowed file types
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.bmp|\.webp|\.svg)$/i;

    if (allowedExtensions.exec(filePath)) {
        submitBtn.disabled = false; // Enable the submit button
    } else {
        submitBtn.disabled = true;  // Disable the submit button
        alert('Please upload a valid image file.');
        fileInput.value = ''; // Clear the input
    }
});
