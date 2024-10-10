

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JustKar</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css
    ">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">  

</head>
<body>
   
            <!-- Navbar -->
      
        <nav class="navbar fixed-top navbar-expand-lg bg-dark" id="navbar">
            <div class="container-fluid">
                <a href="/" class="navbar-brand px-3"><img src="/images/logo.png" alt="" width="50px" height="50px"></a>
                <button class="navbar-toggler btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navmenu">
                    <ul class="navbar-nav text-center">
                        <li class="nav-item px-3 ">
                            <a href="/" class="nav-link text-white " style="font-size: 16px;
                            font-weight: 500;">Back to Home</a>
                        </li>
                       
                      
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End of Navbar -->

        <div class="container mt-5">
            
            <div class="row  justify-content-center">

                <div class="col-lg-12 mt-5 ">
                    <div class="container mb-3">
                        <div class="row justify-content-end">
                          <div class="col-md-6">
                            <select id="carType" class="form-control w-50 float-end" onchange="changeIframe(this.value)">
                              <option selected disabled>Select Car Type</option>
                              <option value="sedan">Sedan</option>
                              <option value="suv">SUV</option>
                              <option value="hatchback">Hatchback</option>
                              <option value="pickup">Pickup</option>
                            </select>
                          </div>
                        </div>
                      </div>

                    <div class="container d-flex justify-content-center">
                        
                        {{-- car --}}
                        <div class="frame-container d-flex justify-content-center">
                          <iframe id="vehicle-image" class="alcar_bb" src="" width="100%" height="500px" scrolling="no"></iframe>

                        </div>

                    </div>
                </div>       
             </div>
             <div class="row">
                
                <div class="container d-flex justify-content-center p-3 bg-light">
                  <div id="wheels-sedan" style="display: none;">
                    @include('components/wheels/sedan')
                </div>
                <div id="wheels-suv" style="display: none;">
                    @include('components/wheels/suv')
                </div>
                <div id="wheels-hatchback" style="display: none;">
                    @include('components/wheels/hatchback')
                </div>
                <div id="wheels-pickup" style="display: none;">
                    @include('components/wheels/pickup')
                </div>
                    
                </div>
             </div>
        </div>
        {{-- <script>
            function changeIframe(vehicleType) {
              const iframe = document.getElementById('vehicle-image');
              const imageList = document.getElementById('image-list');
              let src = '';
              let wheelsComponent = '';

              switch(vehicleType) {
                case 'sedan':
                  src = 'https://bbimg.alcar-wheels.com/viewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&amp;lng=en&amp;dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&amp;fbld=F1296&amp;rbld=R020-99&amp;zoll=18';
                  break;
                case 'suv':
                  src = 'https://bbimg.alcar-wheels.com/configurator_blackbox/bbviewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&lng=en&dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&fbld=F1910&rbld=R021-150&zoll=20&bck=';
                  wheelsComponent = '@include('components/wheels/suv')';
                  break;
                case 'hatchback':
                  src = 'https://bbimg.alcar-wheels.com/configurator_blackbox/bbviewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&lng=en&dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&fbld=F1776&rbld=R020-99&zoll=18&bck=';
                  wheelsComponent = '@include('components/wheels/hatchback')';
                  break;
                case 'pickup':
                  src = 'https://bbimg.alcar-wheels.com/configurator_blackbox/bbviewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&lng=en&dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&fbld=F2046&rbld=R021-150&zoll=20&bck=';
                  wheelsComponent = '@include('components/wheels/pickup')';
                  break;
              }
              iframe.src = src;
              imageList.innerHTML = wheelsComponent;              
            }
          </script> --}}
          <script>
            function changeIframe(vehicleType) {
                const iframe = document.getElementById('vehicle-image');
                let src = '';
        
                // Hide all wheel components first
                document.getElementById('wheels-sedan').style.display = 'none';
                document.getElementById('wheels-suv').style.display = 'none';
                document.getElementById('wheels-hatchback').style.display = 'none';
                document.getElementById('wheels-pickup').style.display = 'none';
        
                // Show wheels and update car iframe based on vehicle type
                switch(vehicleType) {
                    case 'sedan':
                        src = 'https://bbimg.alcar-wheels.com/viewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&amp;lng=en&amp;dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&amp;fbld=F1296&amp;rbld=R020-99&amp;zoll=18'; // Sedan URL
                        document.getElementById('wheels-sedan').style.display = 'block';
                        break;
                    case 'suv':
                        src = 'https://bbimg.alcar-wheels.com/configurator_blackbox/bbviewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&lng=en&dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&fbld=F1910&rbld=R021-150&zoll=20&bck='; // SUV URL
                        document.getElementById('wheels-suv').style.display = 'block';
                        break;
                    case 'hatchback':
                        src = 'https://bbimg.alcar-wheels.com/configurator_blackbox/bbviewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&lng=en&dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&fbld=F1776&rbld=R020-99&zoll=18&bck='; // Hatchback URL
                        document.getElementById('wheels-hatchback').style.display = 'block';
                        break;
                    case 'pickup':
                        src = 'https://bbimg.alcar-wheels.com/configurator_blackbox/bbviewer.php?alclcs=2a92444ee73079a6a15b61fb8d7ba0a6&lng=en&dtlcs=Zu4bIeKkeZIFAq5Qk82L7QwgDbqs2oXw&fbld=F2046&rbld=R021-150&zoll=20&bck='; // Pickup URL
                        document.getElementById('wheels-pickup').style.display = 'block';
                        break;
                }
        
                // Update the iframe src for the vehicle
                iframe.src = src;
            }
        </script>
        <script src="/script.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js
"></script>  
</body>
</html>
