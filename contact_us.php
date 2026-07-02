<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Our Services | AirCon Service</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/CSS/style.css">
</head>


<body>
    <!-- NAVBAR -->
    <!-- INCLUDE NAVBAR -->
    <?php include('shared/navbar.html'); ?>

    <section class="contact-section">

        <div class="container my-5">


            <div class="contact-grid">


                <!-- IMAGE SIDE -->
                <div class="hero-image-side">


                    <img src="assets/images/hero.jpg" alt="AirCon Technician Team" class="contact-image">



                    <div class="overlay-content">


                        <h3>
                            Industry-Certified Excellence
                        </h3>


                        <p>
                            Expert & Passionate HVAC Team
                        </p>


                        <div class="rating">
                            ★ 4.9/5 Customer Rating
                        </div>


                    </div>


                </div>






                <!-- FORM SIDE -->


                <div class="form-container">


                    <h2>
                        Send Us a Message
                    </h2>


                    <p>
                        Have a question? Our team is ready to help.
                    </p>



                    <form action="contact_process.php" method="POST">


                        <input type="text" name="name" placeholder="Your Full Name" required>



                        <input type="email" name="email" placeholder="Your Email" required>



                        <input type="text" name="phone" placeholder="Phone Number">



                        <select name="service">

                            <option>
                                Select Service
                            </option>

                            <option>
                                AC Installation
                            </option>

                            <option>
                                AC Repair
                            </option>

                            <option>
                                Maintenance
                            </option>

                            <option>
                                Emergency Repair
                            </option>


                        </select>




                        <textarea name="message" rows="5" placeholder="Your Message"></textarea>




                        <button type="submit" class="send-btn">

                            Send Message

                        </button>



                    </form>


                </div>


            </div>





            <!-- CONTACT INFO -->


            <div class="contact-info">


                <div>

                    <h4>📞 Phone</h4>

                    <p>
                        +255 712 345 678
                    </p>

                </div>



                <div>

                    <h4>✉ Email</h4>

                    <p>
                        support@aircon.com
                    </p>

                </div>



                <div>

                    <h4>📍 Location</h4>

                    <p>
                        Dar es Salaam
                    </p>

                </div>


            </div>



        </div>


    </section>








    <!-- INCLUDE FOOTER -->
    <?php include('shared/footer.html'); ?>


</body>

</html>