<?php
require_once __DIR__ . '/includes/public_bootstrap.php';

/*$userEmail = '';*/
$userMessages = [];

/* If user is logged in, show their messages
if (isset($_SESSION['user_id'])) {
    $userId = (int) $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT  email FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $userEmail = $user['email'] ?? '';
    
    if ($userEmail) {
        $msgStmt = $conn->prepare("
            SELECT id, name, email, phone, subject, message, reply, status, created_at, replied_at
            FROM contact_messages
            WHERE email = ?
            ORDER BY created_at DESC
        ");
        $msgStmt->bind_param('s', $userEmail);
        $msgStmt->execute();
        $userMessages = $msgStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}*/


if (!empty($_SESSION['user_id'])) {
    $userId = (int) $_SESSION['user_id'];

    $msgStmt = $conn->prepare("
        SELECT id, name, email, phone, subject, message, reply, status, created_at, replied_at
        FROM contact_messages
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");

    $msgStmt->bind_param('i', $userId);
    $msgStmt->execute();
    $userMessages = $msgStmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

?>
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

                    <?php 
                    if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
                    <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= e($_SESSION['error']) ?></div>
                    <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                        <div><?= e($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>

                    <form action="/ACSS/airconservices_booking/actions/contact_process.php" method="POST">


                        <input type="text" name="name" placeholder="Your Full Name" required>



                        <input type="email" name="email" placeholder="Your Email" required>



                        <input type="text" name="phone" placeholder="Phone Number">



                        <select name="service" required>

                            <option value="">
                                Select Service
                            </option>

                            <option value="AC Installation">
                                AC Installation
                            </option>

                            <option value="AC Repair">
                                AC Repair
                            </option>

                            <option value="Maintenance">
                                Maintenance
                            </option>

                            <option value="Emergency Repair">
                                Emergency Repair
                            </option>

                            <option value="General Inquiry">
                                General Inquiry
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

        <!-- MESSAGE HISTORY -->
        <!-- MESSAGE HISTORY -->
        <!-- MESSAGE HISTORY SECTION (ALWAYS VISIBLE) -->
        <div style="margin-top:60px; padding:40px; background:#f9f9f9; border-top:2px solid #ddd;">
            <div class="container">

                <h3>Your Messages & Replies</h3>

                <?php if (!isset($_SESSION['user_id'])): ?>

                <p>Please login to view your messages.</p>

                <?php else: ?>

                <?php if (!empty($userMessages)): ?>

                <?php foreach ($userMessages as $msg): ?>

                <div style="margin:20px 0; padding:15px; background:#fff; border-left:4px solid #007bff;">

                    <h5><?= e($msg['subject']) ?></h5>

                    <p><?= nl2br(e($msg['message'])) ?></p>

                    <?php if (!empty($msg['reply'])): ?>
                    <div style="margin-top:10px; background:#e7f3ff; padding:10px;">
                        <strong>Admin Reply:</strong>
                        <p><?= nl2br(e($msg['reply'])) ?></p>
                    </div>
                    <?php endif; ?>

                </div>

                <?php endforeach; ?>

                <?php else: ?>

                <p>No messages yet. Send your first message above.</p>

                <?php endif; ?>

                <?php endif; ?>

            </div>
        </div>


    </section>








    <!-- INCLUDE FOOTER -->
    <?php include('shared/footer.html'); ?>


</body>

</html>