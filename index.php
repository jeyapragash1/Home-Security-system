<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sentinel Safe</title>

        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="css/home.css" type="text/css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    </head>
    <body>

        <!--------------- Navigation bar ------------------->
        <section class="header">
            <nav>
                <a href="index.php"><img src="images/logo.png" alt="sentinel safe" style="width: 150px; margin-top: 10px"></a>
                <div class="navi" id="navilinks">
                    <i class="fa fa-times" onclick="hideMenu()"></i>
                    <ul class="bar">
                        <li><a href="Index.php">Home</a></li>
                        <li class="sign"><a href="sign_up.php">Sign Up</a></li>
                        <li class="sign"><a href="login.php">Log In</a></li>
                    </ul>
                </div>
                <i class="fa fa-bars" onclick="showMenu()"></i>
            </nav>

            <!-------------- Title ---------------->
            <div class="title">
                <h2>Welcome to <br><span class="sri">Sentinel Safe</span></h2>
                <p>Ensuring the security of your home with advanced monitoring and alert systems.</p><br><br>
            </div>
        </section>

        <!-------------- About Sentinel Safe -------------->
        <section class="para1" data-aos="fade-up">
            <h2>About Sentinel Safe</h2><br>
          <p>
    Our home security system offers comprehensive protection and peace of mind with advanced features tailored to your needs. The system integrates seamless visitor management, including data entry, editing, and PDF generation, alongside real-time monitoring of visitor statistics. Whether managing security on-site or remotely, you remain in full control.
</p>
<br>
<p>
    With our system, security personnel can efficiently log and track visitors, generate detailed reports, and keep accurate records of checked-in, checked-out, and reported visitors. The intuitive dashboard provides a clear overview of visitor statistics, ensuring that you are always informed and ready to respond to any situation.
</p>
<br>
<p>
    We are dedicated to delivering a user-friendly and reliable security solution that adapts to your evolving needs. Our system is designed to be straightforward and effective, making home security management both simple and robust. Rely on our system to keep your home and loved ones safe.
</p>
        </section>

        <!-------------- Statistics Section ------------>
        <section class="stats-section" data-aos="fade-up">
            <h2>Trusted by Thousands</h2><br>
            <div class="row">
                <div class="stat-box" data-aos="zoom-in">
                    <i class="fa fa-users"></i>
                    <h3>5000+</h3>
                    <p>Active Users</p>
                </div>
                <div class="stat-box" data-aos="zoom-in">
                    <i class="fa fa-shield"></i>
                    <h3>99.9%</h3>
                    <p>Security Rate</p>
                </div>
                <div class="stat-box" data-aos="zoom-in">
                    <i class="fa fa-clock-o"></i>
                    <h3>24/7</h3>
                    <p>Monitoring</p>
                </div>
                <div class="stat-box" data-aos="zoom-in">
                    <i class="fa fa-check-circle"></i>
                    <h3>10000+</h3>
                    <p>Visitors Tracked</p>
                </div>
            </div>
        </section>

        <!---------------- our features ---------------->
        <section class="interest" data-aos="fade-up">
            <h2>Our Features</h2><br>
            <div class="row">
                <div class="int" data-aos="fade-up">
                    <img src="images/f1.jpg" alt="Real-time Monitoring">
                    <div class="layer">
                        <h3>Monitoring</h3>
                        <p>Keep track of all visitors with updates.</p>
                    </div>

                </div>
                <div class="int" data-aos="fade-up">
                    <img src="images/f2.jpg" alt="Instant Alerts">
                    <div class="layer">
                        <h3>Visitor Management</h3>
                        <p>Easily enter, edit, or delete visitor information.</p>
                    </div>

                </div>
                <div class="int" data-aos="fade-up">
                    <img src="images/f3.jpg" alt="Emergency Contact">
                    <div class="layer">
                        <h3>Report Issue</h3>
                        <p style="padding: 5px">Generate a report and quickly reach out to authorities with a single click.</p>
                    </div>

                </div>
                <div class="int" data-aos="fade-up">
                    <img src="images/f4.jpg" alt="Secure Data Storage">
                    <div class="layer">
                        <h3>Secure Data Storage</h3>
                        <p>Ensure your data is protected and private.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-------------- How It Works ------------>
        <section class="how-it-works" data-aos="fade-up">
            <h2>How It Works</h2><br>
            <p class="subtitle">Get started with Sentinel Safe in 3 simple steps</p><br>
            <div class="row">
                <div class="step" data-aos="fade-right">
                    <div class="step-number">1</div>
                    <i class="fa fa-user-plus"></i>
                    <h3>Sign Up</h3>
                    <p>Create your account in less than 2 minutes. Provide basic information and set up your security profile.</p>
                </div>
                <div class="step" data-aos="fade-up">
                    <div class="step-number">2</div>
                    <i class="fa fa-cog"></i>
                    <h3>Configure</h3>
                    <p>Set up your preferences, add security personnel, and customize your monitoring settings.</p>
                </div>
                <div class="step" data-aos="fade-left">
                    <div class="step-number">3</div>
                    <i class="fa fa-check-circle-o"></i>
                    <h3>Start Monitoring</h3>
                    <p>Begin tracking visitors, receive alerts, and manage your home security with confidence.</p>
                </div>
            </div>
        </section>

        <!-------------- Why Choose Us ------------>
        <section class="why-choose" data-aos="fade-up">
            <h2>Why Choose Sentinel Safe?</h2><br>
            <div class="row">
                <div class="why-left" data-aos="fade-right">
                    <img src="images/security-team.jpg" alt="Security Team" onerror="this.src='images/logo.png'">
                </div>
                <div class="why-right" data-aos="fade-left">
                    <div class="why-item">
                        <i class="fa fa-lock"></i>
                        <div>
                            <h3>Advanced Security</h3>
                            <p>State-of-the-art encryption and security protocols to protect your data and privacy.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <i class="fa fa-mobile"></i>
                        <div>
                            <h3>Easy to Use</h3>
                            <p>Intuitive interface designed for everyone. No technical knowledge required.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <i class="fa fa-headphones"></i>
                        <div>
                            <h3>24/7 Support</h3>
                            <p>Our dedicated team is always available to assist you with any questions or concerns.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <i class="fa fa-money"></i>
                        <div>
                            <h3>Affordable Pricing</h3>
                            <p>Premium security features at competitive prices. No hidden fees or charges.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-------------- Testimonials ------------>
        <section class="testimonials" data-aos="fade-up">
            <h2>What Our Users Say</h2><br>
            <div class="row">
                <div class="testimonial-box" data-aos="flip-left">
                    <i class="fa fa-quote-left"></i>
                    <p>Sentinel Safe has completely transformed how we manage security at our residence. The visitor tracking system is incredibly efficient and easy to use.</p>
                    <div class="user-info">
                        <h4>Sarah Johnson</h4>
                        <p>Homeowner</p>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="testimonial-box" data-aos="flip-left">
                    <i class="fa fa-quote-left"></i>
                    <p>The real-time monitoring and instant alerts give me peace of mind. I always know who's entering and leaving my property. Highly recommended!</p>
                    <div class="user-info">
                        <h4>Michael Chen</h4>
                        <p>Security Manager</p>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="testimonial-box" data-aos="flip-left">
                    <i class="fa fa-quote-left"></i>
                    <p>Outstanding system with excellent customer support. The PDF reporting feature is particularly useful for keeping detailed visitor records.</p>
                    <div class="user-info">
                        <h4>Emily Rodriguez</h4>
                        <p>Property Manager</p>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-------------- Call to Action ------------>
        <section class="cta-section" data-aos="zoom-in">
            <h2>Ready to Secure Your Home?</h2>
            <p>Join thousands of satisfied users and experience peace of mind with Sentinel Safe</p><br>
            <div class="cta-buttons">
                <a href="sign_up.php" class="btn-primary">Get Started Free</a>
                <a href="#contact" class="btn-secondary">Contact Us</a>
            </div>
        </section>

        <!----------Footer ---------->
        <section class="footer">
            <div class="info">
                <div class="main">
                    <div class="col">
                        <h4>Join</h4>
                        <ul>
                            <li><a href="sign_up.php">Sign Up</a></li>
                            <li><a href="login.php">Log In</a></li>

                        </ul>
                    </div>
                    <div class="col">
                        <h4>Policies</h4>
                        <ul>
                            <li><a href="Terms.php">Terms and Conditions</a></li>
                            <li><a href="Privacy.php">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="contact.php">Contact</a></li>
                            <li><a href="FAQ.php">FAQ</a></li>
                            <li><a href="Blog.php">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <h4>Connect with us</h4>
                        <div class="social">
                            <a href="#p"><i class="fa fa-facebook"></i></a>
                            <a href="#q"><i class="fa fa-instagram"></i></a>
                            <a href="#r"><i class="fa fa-twitter"></i></a>
                            <a href="#s"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <div class="rights">
                    <p>All rights reserved &copy; 2022</p>
                </div>
            </div>
        </section>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
                    AOS.init();
        </script>

        <!------------------ JavaScript link ----------------------> 
        <script src="js/js.js"></script>
    </body>
</html>
