<?php
  session_start();
  include('admin/vendor/inc/config.php');
  
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!--Head-->
<?php include("vendor/inc/head.php");?>

<body>

    <!-- Navigation -->
    <?php include("vendor/inc/nav.php");?>
    <!--End Navigation-->

    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner" role="listbox">

                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item active" style="background-image: url('vendor/img/Background.jpg')">
                </div>

                <!-- Slide Three - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url('vendor/img/Background20.jpg')">
                </div>

                <!-- Slide Two - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url('vendor/img/B02.jpg')">
                </div>


            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
    </header>


    <!--============== How it works section=============== -->

    <section class="works">
        <div class="title">
            <h3>HOW TO BOOK A VEHICLE?</h3>
            <p>"Where convenience meets reliability. Experience seamless vehicle bookings tailored to your needs with just a few clicks."</p>
        </div>
        <div class="container works-container">
            <div class="step">
                <span class="number"><span>01</span></span>
                <span class="caption">Select Vehicle</span>
            </div>
            <div class="step">
                <span class="number"><span>02</span></span>
                <span class="caption">Pickup Location and Return Location</span>
            </div>
            <div class="step">
                <span class="number"><span>03</span></span>
                <span class="caption">Pickup Time and Return Time</span>
            </div>
            <div class="step">
                <span class="number"><span>04</span></span>
                <span class="caption">Check Out</span>
            </div>
            <div class="step">
                <span class="number"><span>05</span></span>
                <span class="caption">Done</span>
            </div>
        </div>
    </section>

    
    <!--============== About Us section=============== -->

    <section class="about" id="about">
        <div class="title">
            <h4><i class="fa-solid fa-car"></i></h4>
            <h2>About Us</h2>
        </div>

        <div class="about-container">
            <div class="image">
                <img src="vendor/img/City1.png" alt="">
            </div>
            <div class="content">
                <div class="title">
                    <h3>Welcome to City Taxi</h3>
                </div>
                <p>City Taxi (PVT) Ltd is your reliable partner in transportation, serving passengers across various city areas with a focus on affordability and accessibility. Catering to the low to mid-income range, we are committed to providing a transportation service that is both cost-effective and convenient, ensuring that every passenger can enjoy a comfortable journey without compromising on quality. Our dedication to punctuality means that whether you're rushing to work, attending a meeting, or heading home after a long day, you can count on us to get you there on time, every time. We also offer private usage options for those who require more personalized travel solutions, ensuring that all your transportation needs are met with the highest level of professionalism.</p> <br> <p>At City Taxi, we understand that safety is paramount. Our fleet of well-maintained, clean vehicles is driven by a team of courteous, professional drivers who prioritize your comfort and security. We have integrated advanced technology into our services, offering a user-friendly web-based system that allows passengers to easily reserve taxis, receive instant notifications, and complete seamless payments. This innovative approach not only streamlines the booking process but also enhances your overall travel experience, making each journey with us hassle-free. Our commitment to superior service and exceptional customer care is at the heart of everything we do, ensuring that you arrive at your destination with peace of mind and satisfaction.</p>
            </div>
        </div>
    </section>

    <!--============== Services section=============== -->

    <section class="services" id="services">
        <div class="title">
            <h4><i class="fa-solid fa-car"></i></h4>
            <h2>Services we ofeer to our customers</h2>
        </div>
        <div class="container services-container">
            <div class="card">
                <div>
                    <i class="fa fa-taxi" aria-hidden="true"></i>
                    <h4>Online Taxi Reservations</h4>
                </div>
                <p>"Passengers can easily book taxis through the City Taxi website, receiving instant SMS notifications with driver and vehicle details upon confirmation."</p>
            </div>
            <div class="card">
                <div>
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <h4>Manual Taxi Booking</h4>
                </div>
                <p>"For unregistered passengers, City Taxi provides a telephone operator service to manually reserve taxis, ensuring that even those without online access can book a ride efficiently."</p>
            </div>
            <div class="card">
                <div>
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <h4>Real-Time Driver Tracking</h4>
                </div>
                <p>"City Taxi offers clients the ability to track their assigned driver in real-time through the web-based system. This feature allows passengers to see the exact location of their driver as they approach, ensuring peace of mind and better coordination for pick-ups."</p>
            </div>
            <div class="card">
                <div>
                    <i class="fa fa-plane" aria-hidden="true"></i>
                    <h4>24/7 Airport Transfer Service</h4>
                </div>
                <p>"City Taxi (PVT) Ltd offers a 24/7 Airport Transfer Service, providing reliable, timely transportation to and from the airport with real-time flight tracking. Our professional drivers ensure on-time pick-ups and a stress-free journey in comfortable vehicles. Enjoy seamless travel from your doorstep to the terminal."</p>
            </div>
        </div>
    </section>


    <!--============== Blog section=============== -->

    <section class="blog" id="blog">
        <div class="title">
            <h4><i class="fa-solid fa-car"></i></h4>
            <h2>Vehicle Articles</h2>
            <p>"Welcome to Prasanna Rent a Car's blog, your go-to destination for travel tips, car rental insights, and adventure inspiration. Join us as we navigate the world of exploration, one blog post at a time."</p>
        </div>

        <div class="container blog-container">
            <div class="card card-1">
                <div class="image">
                    <img src="vendor/img/blog1.jpg" alt="">
                </div>
                <div class="content">
                    <p>"Step into a world where luxury meets performance with City Taxi's unparalleled selection of premium vehicles, featuring renowned brands such as BMW, Mercedes-Benz, Audi, and more. Our fleet represents the pinnacle of automotive engineering, embodying a harmonious fusion of cutting-edge technology, opulent comfort, and exhilarating performance. From the iconic silhouettes of BMW's sleek sedans to the refined elegance of Mercedes-Benz's luxury SUVs, each vehicle in our collection exudes an aura of exclusivity and refinement. Whether you're navigating bustling city streets or embarking on an epic road trip, our meticulously maintained fleet ensures a seamless and unforgettable driving experience.</p> <br><br> <p>Immerse yourself in the plush interiors of a Mercedes-Benz, where every detail is meticulously crafted to indulge your senses and elevate your comfort. Experience the dynamic performance and precision engineering of a BMW, where powerful engines and responsive handling transform every twist and turn of the road into an exhilarating adventure. Or revel in the sophisticated luxury of an Audi, where cutting-edge technology seamlessly integrates with timeless design to create a driving experience unlike any other.</p>     
                </div>
            </div>

            <div class="card card-2">
                <div class="content">
                    <p>"Welcome to a world of refined elegance and superior performance with City Taxi's premium vehicle lineup, featuring esteemed models like the Toyota Premio, Allion, Axio, and more. Designed to cater to discerning travelers seeking comfort, reliability, and style, our collection epitomizes the essence of luxury driving. Whether you're navigating urban landscapes or embarking on a scenic getaway, our meticulously maintained fleet ensures a seamless and enjoyable journey every time. Experience the unmatched sophistication of the Toyota Premio, with its plush interiors and advanced features providing a first-class driving experience.</p> <br><br> <p>in the timeless elegance of the Allion, where sleek design meets uncompromising comfort, creating an oasis of tranquility on the road. Or opt for the unmatched reliability and efficiency of the Axio, offering a perfect blend of performance and practicality for any adventure. With Prasanna Rent a Car, you don't just rent a vehicle; you embark on a journey of luxury, comfort, and unparalleled convenience."</p>     
                </div>
                <div class="image">
                    <img src="vendor/img/blog2.jpg" alt="">
                </div>
            </div>

            <div class="card card-3">
                <div class="image">
                    <img src="vendor/img/blog3.jpg" alt="">
                </div>
                <div class="content">
                    <p>
                        "Explore the world with City Taxi's versatile fleet of general vehicles, including popular models like the Alto, Celerio, Vitz, Swift, and more. Whether you're cruising through bustling city streets or embarking on a countryside adventure, our collection of reliable and fuel-efficient cars is designed to meet your every need. Experience the agility and compactness of the Alto, perfect for navigating narrow streets and tight parking spaces with ease. Opt for the practicality and efficiency of the Celerio, offering ample space for passengers and luggage without compromising on fuel economy. Discover the stylish charm of the Vitz, where sleek design meets agile performance, making it the ideal choice for urban commuters and weekend explorers alike.</p> <br><br>  <p>Or embrace the dynamic driving experience of the Swift, with its sporty design and responsive handling adding a touch of excitement to every journey. At City Taxi, we understand that every adventure is unique, which is why our general vehicle fleet offers a diverse range of options to suit your preferences and budget. With reliable performance, affordable rates, and exceptional customer service, City Taxi is your trusted partner in exploration and discovery."</p>     
                </div>
                
            </div>
        </div>
    </section>


    <!--============== Poster section=============== -->

    <section class="poster">
        <div class="container poster-container">
            <div class="box box-1">
                <span>20</span>
                <p>Years <br> Experience</p>
            </div>
            <div class="box">
                <span>200+</span>
                <p>Total <br> Vehicles</p>
            </div>
            <div class="box">
                <span>10000+</span>
                <p>Happy <br> Customers</p>
            </div>
            <div class="box">
                <span>3</span>
                <p>Total <br> Branches</p>
            </div>
        </div>
    </section>


    <!--============== Testimonials section=============== -->

    <br>
    <div class="container">

        
        
        <h2 class="my-4">CLIENT TESTIMONIALS</h2>

        <div class="row">
            <?php

      $ret="SELECT * FROM tms_feedback where f_status ='Published' ORDER BY RAND() LIMIT 3 "; //get all feedbacks
      $stmt= $mysqli->prepare($ret) ;
      $stmt->execute() ;//ok
      $res=$stmt->get_result();
      $cnt=1;
      while($row=$res->fetch_object())
    {
    ?>
      
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <h4 class="card-header"><?php echo $row->f_uname;?></h4>
                    <div class="card-body">
                        <p class="card-text"><?php echo $row->f_content;?></p>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include("vendor/inc/footer.php");?>
    <!--.Footer-->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>