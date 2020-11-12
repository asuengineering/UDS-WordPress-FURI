<?php
/**
 * Template Name: About Page
 *
 * @package UDS-WordPress-FURI
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
    the_post();
    ?>

    <div class="wrapper" id="page-wrapper">

        <?php include get_template_directory() . '/hero.php'; ?>

        <div id="content">

            <section id="about-lead">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">

                        <h1><span class="highlight-gold">About FURI</span></h1>
                        <h3 class="subhead">Let's make something amazing.</h3>
                        
                        <p class="lead">The Fulton Undergraduate Research Initiative (FURI) is designed to enhance engineering and technical undergraduate curriculum by providing hands-on lab experience and independent and thesis-based research.</p>
                        
                        </div>
                    </div><!-- .row -->
                </div><!-- .container -->
            </section>

            <section class="section-wrapper" id="director-message">
                <div class="container">
                    <div class="row row-title">
                        <div class="col-md-12">
                            <h2 class="text-white">Message from the directors<h2>
                        </div>
                    </div>
                    <div class="row row-letter">
                        <div class="col-md-10 offset-md-1 bg-white">
                            <p>Access to research activities from students’ first semester is a core value of the Ira A. Fulton Schools of Engineering. Together with highly regarded faculty, first-year students through doctoral candidates collaborate on use-inspired research.</p>

                            <p>Students conducting research through the Fulton Undergraduate Research Initiative spend a semester conceptualizing an idea, developing a plan and investigating their research question. Through this work, they are developing innovative solutions to real-world challenges in data, education, energy, health, security and sustainability.</p>

                            <p>The program provides opportunities often only available to graduate students, including traveling to prestigious conferences and publishing their work in research journals.</p>

                            <p>Some of our researchers get extra funding through industry and alumni sponsors.</p>

                            <p>FURI advances students’ skills in innovation, independent thinking and problem-solving that will support their future pursuits and careers. High-level research also opens doors to additional opportunities for scholarships, internships and graduate research.</p>
                            
                            <p>Many FURI students have gone on to apply their unique experience to work in industry, as well as graduate studies in engineering, medicine, law and other disciplines.</p>

                            <p>We are proud of what our students have accomplished and we’re excited to share their work with you.</p>
                        </div>
                    </div>
                    <div class="row row-signature bg-white">
                        <div class="col-md-5 offset-md-1">
                            <p class="signee"><span>Kyle D. Squires</span>Dean, Ira A. Fulton Schools of Engineering<br/>Professor, mechanical and aerospace engineering</p>

                            <p class="signee"><span>Tami Coronella</span>Director<br/>Student Success and Engagement</p>
                        </div>
                        <div class="col-md-5">
                            <p class="signee"><span>Jay Oswald</span>FURI faculty director<br/>Associate Professor, mechanical and aerospace engineering</p>

                            <p class="signee"><span>Patrick Phelan</span>MORE faculty director<br/>Professor, mechanical and aerospace engineering<br/>Assistant Dean of Graduate Programs</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- the mock up has some half text, half image content here -->

            <section class="section-wrapper" id="ira-message">
                <div class="container">
                    <div class="row row-title">
                        <div class="col-md-12">
                            <h2 class="text-white">Made possible by our biggest fan.</h2>
                        </div>
                    </div>
                    <div class="row row-message">
                        <div class="col-md-4 offset-md-7">

                            <blockquote class="ws2-element-gold ws2-element-style ws2-element-spacing-entity">
                                <p>I strongly beleive that you cannot have a great city without a great school of engineering.</p>
                                <cite>Ira A. Fulton</cite>
                            </blockquote>

                            <hr />

                            <p>In 2003, Ira A. Fulton, founder and CEO of Arizona-based Fulton Homes, established an endowment of $50 million in support of ASU’s College of Engineering and Applied Sciences.</p>
                            
                            <p>His investment served as a catalyst, enabling the development of a dynamic portfolio of strategic initiatives that benefit our students and faculty and the communities where they live and work.</p>

                            <p>Launched in 2005, FURI is one of the most visible and vibrant ways Mr. Fulton’s investment is expanding opportunities for Fulton Schools students. Throughout the years, he has remained an active supporter and regular presence of the program and the school that bears his name.</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="section-head" id="life-after-furi-title">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Where are they <span class="text-gold">now?</span></h3>
                        </div>
                    </div>     
                </div>
            </div>

            <section id="life-after-furi">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-wrap">
                                <h4>Life After<span>FURI</span></h4>
                                <p class="intro">Each semester we invite FURI alumni to share where they are now as they embark on their careers or the pursuit of advanced degrees. They also look back on how FURI helped them build valuable skills, learn about themselves and succeed in their current endeavors. Over the past two semesters, 165 FURI alumni responded to our survey.</p>
                                <div id="donutchart"></div>
                                <div class="distribution d-flex flex-row justify-content-between">
                                    <div>42%<p>of FURI alumni<br/>in Arizona</p></div>
                                    <div>53%<p>of FURI alumni<br/>in the US</p></div>
                                    <div>5%<p>of FURI alumni<br/>around the world</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="section-head" id="furi-alumni-title">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3><span class="text-gold">FURI</span> alumni are...</h3>
                        </div>
                    </div>
                </div>
            </div>

            <section id="furi-alumni">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="col-wrap">
                                <h4>...working exciting careers</h4>
                                <p><a href="https://furi.engineering.asu.edu/participant/deotale-aditya/"><strong>Aditya Deotale</strong></a> is a software development engineer at Amazon.</p>
                                <p><strong>Joy Marsalla</strong> is protecting people and the planet through work with green chemistry and air emissions in Nike’s Sustainable Manufacturing team.</p>
                                <p><a href="https://furi.engineering.asu.edu/participant/mian-sami/"><strong>Sami Mian</strong></a> is head of engineering at Rizse, Inc., a small robotics company.</p>
                                <p><strong>Akhila Murella</strong> is working at Xbox as a program manager.</p>
                                <p><a href="https://furi.engineering.asu.edu/participant/sim-esther/"><strong>Esther Sim</strong></a> is a postbaccalaureate research fellow at the National Institutes of Health, where she is conducting tissue engineering and 3D bioprinting research.</p>
                                <p><strong>Stephanie Thacker (Naufel) </strong>is a technical program manager on Facebook’s Brain-Computer Interface team.</p>
                                <p><a href="https://furi.engineering.asu.edu/participant/warrayat-mohanad/"><strong>Mohanad Warrayat</strong></a> is an associate mechanical engineer at Ad Astra Rocket Company.</p>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="col-wrap">
                                <h4>...pursuing advanced degrees and working in academia</h4>
                                <p><strong>Christopher Balzer</strong> is pursuing his doctorate and researching polymer physics at the California Institute of Technology.</p>
                                <p><strong>Ryan Dougherty</strong> is a tenure-track assistant professor of computer science at West Point.</p>
                                <p><a href="https://furi.engineering.asu.edu/participant/durso-michael/"><strong>Michael Durso</strong></a> is pursuing his doctorate in materials at Massachusetts Institute of Technology.</p>
                                <p><a href="https://furi.engineering.asu.edu/participant/gilbert-alia/"><strong>Alia Gilbert</strong></a> is pursuing her doctorate in robotics at the University of Michigan.</p>
                                <p><a href="https://furi.engineering.asu.edu/participant/mulford-philip/"><strong>Phillip Mulford</strong></a> is pursuing his doctorate in mechanical engineering/robotics at Dartmouth College.<br><strong>Joanna Sipe</strong> is pursuing her doctorate in environmental engineering at Duke University</p>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="col-wrap">
                                <h4>...starting their own companies</h4>
                                <p><strong>Rick Ahlf</strong> is the co-founder and chief technology officer of 6-4-3 Charts, which provides weekly advanced scouting reports and analytics for baseball.
                                <p><strong>Taylor Graber</strong> is running a company revolving around a patent for a biomedical device that facilitates airway management for anesthesiologists, and a company called ASAP IVs, which provides on-demand IV therapies for hydration, wellness, immunity boosting and athletic performance recovery.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div><!-- #content -->

    </div><!-- #page-wrapper -->

<?php
} // End loop/

get_footer();
