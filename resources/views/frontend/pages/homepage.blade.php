@extends('frontend.layouts.main')
@section('content')
    <!-- Banner Section -->
    <div class="banner-section">
        <div class="owl-carousel banner-carousel owl-theme">
            <div class="item">
                <div class="banner01"><img src="{{ asset('frontend/images/banner01.png') }}" class="img-fluid" alt="">
                </div>
                <!-- <div id="overlay"></div> -->
                <div class="container">
                    <div class="bannercarousel-text wow animate fadeInLeft">
                        <h2>Get your<br> Swaasth Fit<br> with <a href="#">SwaasthFiit</a></h2>
                        <p>We're here to help you stay motivated and achieve your health and fitness goals with utmost
                            guidance from team of our experts!</p>
                        <a href="#" class="btn-download">Download Free App</a> <a href="{{route('frontend.signup')}}"
                            class="btn-readmore">Signup for Free</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Fitness Goals Section -->
    <div class="fitnessgoals-section">
        <div class="container">
            <h2>Achieve your fitness goals</h2>

            <div class="row">

                <div class="col-lg-3 col-md-3 col-12">
                    <div class="fitnessgoal-sect">
                        <div class="fitnessgoal-card">
                            <img src="{{ asset('frontend/images/goal-img01.png') }}" alt="">
                            <div class="content">
                                <h3>Expert Guidance for Better Health</h3>
                            </div>
                        </div>
                        <div class="content2">
                            <p>Utilize the expertise & Guidance of a trainer and follow along workout videos to help you
                                reach your fitness goals</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-12">
                    <div class="fitnessgoal-sect">
                        <div class="fitnessgoal-card">
                            <img src="{{ asset('frontend/images/goal-img02.png') }}" alt="">
                            <div class="content">
                                <h3>Diet & Food Recipes</h3>
                            </div>
                        </div>
                        <div class="content2">
                            <p>Utilize the expertise & Guidance of a trainer and follow along workout videos to help you
                                reach your fitness goals</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-12">
                    <div class="fitnessgoal-sect">
                        <div class="fitnessgoal-card">
                            <img src="{{ asset('frontend/images/goal-img03.png') }}" alt="">
                            <div class="content">
                                <h3>Diet & Food Recipes</h3>
                            </div>
                        </div>
                        <div class="content2">
                            <p>Utilize the expertise & Guidance of a trainer and follow along workout videos to help you
                                reach your fitness goals</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-12">
                    <div class="fitnessgoal-sect">
                        <div class="fitnessgoal-card">
                            <img src="{{ asset('frontend/images/goal-img04.png') }}" alt="">
                            <div class="content">
                                <h3>Customized Packages that Fit Your Lifestyle</h3>
                            </div>
                        </div>
                        <div class="content2">
                            <p>Utilize the expertise & Guidance of a trainer and follow along workout videos to help you
                                reach your fitness goals</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- Fitness Goals Section End -->


    <!-- Features1 Section -->
    <div class="features-section">
        <div class="container">

            <div class="row">

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="featuresleft">
                        <h6>AI Features</h6>
                        <h3>Know Yourself Inside and Out: Unveiling
                            the Secrets of Your Body and Food with AI.</h3>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="featuresright">
                        <p>Imagine stepping into a future where technology understands your body better than you do. No
                            more guesswork, no more mystery. Meet our revolutionary AI models, designed to demystify
                            your health and empower you with knowledge:</p>
                    </div>
                </div>

            </div>


            <section>

                <div class="content">
                    <div class="accordion">
                        {{-- <div class="line01"><img src="{{ asset('frontend/images/line01.png') }}" alt=""> --}}
                        {{-- </div> --}}
                        <div class="title active" data-image="{{ asset('frontend/images/featuresimg01.png') }}">
                            Body Scan
                        </div>
                        <div class="desc active">
                            This isn't just a mirror, it's a blueprint! Analyze your *height, shoulder width, chest
                            circumference, even body water levels* - all with a simple scan. Know your unique physique
                            and track progress like never before.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/foodscan-01.png')}}">
                            Food Scan
                        </div>
                        <div class="desc">
                            Craving that delicious *Indian dish* but unsure of the calorie count? No problem! Our AI
                            deciphers the secrets of your plate, *predicting the calories* so you can indulge guilt-free
                            (or make informed choices).
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/GenderDetectionimg01.png')}}">
                            Age & Gender Detection
                        </div>
                        <div class="desc">
                            More than just a party trick, this model reveals fascinating insights from a single image.
                            Discover the *estimated age and gender* with remarkable accuracy, unlocking potential
                            applications in various fields.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/BMIPredictionimg01.png')}}">
                            BMI Prediction
                        </div>
                        <div class="desc">
                            Understand your *Body Mass Index* in a flash. This model analyzes key factors to provide a
                            *personalized assessment*, helping you make informed decisions about your health and
                            well-being.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/SymptomPrediction-img01.png')}}">
                            Illness & Symptom Prediction
                        </div>
                        <div class="desc">
                            Feeling under the weather? Our AI might have the answers.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/FaceEmotion-img01.png')}}">
                            Face Emotion Recognition
                        </div>
                        <div class="desc">
                            Unlock the power of nonverbal communication. This model *reads the emotions on your face*,
                            helping you understand yourself and others better, fostering deeper connections and
                            emotional intelligence.
                        </div>

                    </div>
                    <div class="image">
                        <img src="{{ asset('frontend/images/featuresimg01.png') }}">
                    </div>
                </div>

            </section>

            <p>These are just a glimpse into the possibilities. Our AI models are constantly evolving, pushing the
                boundaries of what's possible.
                <span>*Imagine a future where technology becomes your personal health companion, guiding you towards a
                    healthier, happier you.*</span>
            </p>

            <p><span>*This is the future of self-awareness. This is the future of YOU.*</span></p>

        </div>
    </div>
    <!-- Features1 Section End -->

    <!-- Brain teaser games Section -->
    <div class="brainteasergame-section">
        <div class="brainteasergamebg"><img src="{{ asset('frontend/images/teasergames-bg01.png') }}" alt=""></div>
        <div class="container">
            <div class="bainteaser-text">
                <h5>Other Features</h5>
                <h4>Brain teaser games</h4>
                <p>Brain teaser games on a fitness website offer mental workouts alongside physical exercise. From
                    puzzles to memory games, they challenge cognitive abilities, promoting mental agility and enhancing
                    user engagement.</p>

                <div class="row">
                    <div class="col-md-12 col-12">
                        <a href="#" class="btn-download">Download Free App</a> <a href="{{route('frontend.signup')}}"
                            class="btn-readmore">Signup for Free</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Brain teaser games Section End -->


    <!-- Customised guidance Section -->
    <div class="customisedguidance-section">
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-md-7 col-12">
                    <div class="customisedguidance-left">
                        <div class="dguidanceicon"><img src="{{ asset('frontend/images/guidance-icon.png') }}"
                                alt=""></div>
                        <h3>Customised guidance</h3>

                        <p><span>Based on</span></p>
                        <p>Busy! Can’t find few hours to workout. No problem SwaasthFiit got your back. Plan Your own
                            workout. Just enter.</p>

                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="customisedguidance-right">

                        <div class="personalisedcard">
                            <div class="personalisedcard-img"><img src="{{ asset('frontend/images/DietPlan-bg01.png') }}"
                                    alt="">
                            </div>
                            <h3>Personalised<br> <span>Diet Plan</span></h3>
                            <a href="#" class="planbtn">Diet of the Day</a>
                        </div>

                        <div class="personalisedcard">
                            <div class="personalisedcard-img"><img src="{{ asset('frontend/images/WorkoutRegime.png') }}"
                                    alt="">
                            </div>
                            <h3>Personalised<br> <span>Workout Regime</span></h3>
                            <a href="#" class="planbtn">Workout of the Day</a>
                        </div>

                        <div class="personalisedcard">
                            <div class="personalisedcard-img"><img
                                    src="{{ asset('frontend/images/WorkoutRegime02.png') }}" alt="">
                            </div>
                            <h3>Health<br> <span>Checkup</span></h3>
                            <a href="#" class="planbtn">Check Health</a>
                        </div>

                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-12">
                    <div class="fitnessleft">
                        <img src="{{ asset('frontend/images/fitnessleft-img01.png') }}" alt="">
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-12">
                    <div class="fitnessright">
                        <div class="fitnessrighticon"><img src="{{ asset('frontend/images/Basedimg01.png') }}"
                                alt=""></div>
                        <h2>Fitness pause</h2>

                        <p><span>Based on</span></p>
                        <p>Elevate your workouts with moments of mindfulness. Take a break, realign, and maximize your
                            fitness potential."</p>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Customised guidance Section End -->


    <!-- Health Assurance Section -->
    <div class="healthassurance-section">
        <div class="healthassurancebg"><img src="{{ asset('frontend/images/healthassurancebg.png') }}" alt="">
        </div>

        <div class="container">
            <div class="healthassurance-left">
                <div class="healthassurance-right"><img src="{{ asset('frontend/images/healthassurance-02.png') }}"
                        alt=""></div>
                <div class="dhealthassuranceicon"><img src="{{ asset('frontend/images/Basedimg01.png') }}"
                        alt=""></div>
                <h3>Health Assurance</h3>
                <p>"Reward progress in health with our tailored system: earn points for workouts, unlock badges, access
                    exclusive discounts, and join a supportive community to celebrate achievements."</p>
            </div>
        </div>
    </div>
    <!-- Health Assurance Section End -->

    <!-- Sweat Coins2 Section -->
    <div class="features-section features-section2">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="featuresleft">
                        <h6>Features</h6>
                        <h3>sweat Coins By</h3>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="featuresright">
                        <p>Sweatcoins for walking or running. Users can exchange Sweatcoins for goods, services, or
                            experiences.
                        </p>
                    </div>
                </div>
            </div>

            <section>

                <div class="content">
                    <div class="accordion">
                        <div class="title active" data-image="{{ asset('frontend/images/StepsTracking-img01.png') }}">
                            Steps Tracking
                        </div>
                        <div class="desc active">
                            Step tracking involves using wearable devices or smartphones to monitor and record the
                            number of steps taken daily, aiding in promoting physical activity and setting fitness
                            goals.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/CalorieTracking-img01.png') }}">
                            Calorie Tracking
                        </div>
                        <div class="desc">
                            Calorie tracking: Monitoring daily calorie intake to manage weight and make informed
                            nutritional choices.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/FoodTracking-img01.png')}}">
                            Food Tracking
                        </div>
                        <div class="desc">
                            Food tracking involves monitoring and recording what you eat each day to help manage your
                            diet, weight, and overall health.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/BodyMeasurement-img01.png')}}">
                            Body Measurement Tracking
                        </div>
                        <div class="desc">
                            Body measurement tracking is the practice of regularly measuring aspects of your body, like
                            weight, waist size, and body fat percentage, to monitor changes and progress toward fitness
                            goals.
                        </div>

                        <div class="title" data-image="{{ asset('frontend/images/Gamelevels-img01.png')}}">
                            Game levels
                        </div>
                        <div class="desc">
                            "Game Levels Fitness App" turns workouts into an exciting adventure! Conquer levels, earn
                            rewards, and compete with friends for the top spot. Get ready to level up your fitness game!
                        </div>

                    </div>
                    <div class="image">
                        <img src="{{ asset('frontend/images/StepsTracking-img01.png') }}">
                    </div>
                </div>

            </section>


        </div>
    </div>
    <!-- Sweat Coins2 Section -->

    <!-- Wallet system Section -->
    <div class="customisedguidance-section walletsystem">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="customisedguidance-left">
                        <div class="dguidanceicon"><img src="{{ asset('frontend/images/wallet-icon.png') }}"
                                alt=""></div>
                        <h3>Wallet System</h3>

                        <p><span>Based on</span></p>
                        <p>Wallet system is to collect sweat coins from various activities like face scan, body scan
                            food scan brain games. you can see your sweat coins count here and use these to shop, travel
                            , dine in & so on.</p>

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="walletsystemimg01"><img src="{{ asset('frontend/images/walletsystemimg01.png') }}"
                            alt="">
                        <div class="walletsystemimg02"><img src="{{ asset('frontend/images/walletsystemimg02.png') }}"
                                alt=""></div>
                    </div>
                </div>

            </div>
            <h5>To explore more download our app</h5>

            <div class="mostconvenient">

                <h4>Download the most convenient &<br> Pocket Friendly Fitness App</h4>
                <h5>Start your Fitness Journey with us.<br> Join Swaasthfiit Community!</h5>


                <a href="#" class="btn-android">Download for Android</a>

            </div>


        </div>
    </div>
    <!-- Wallet system Section -->

    <!-- First Walth Section -->
    <div class="firstwealth-section">

        <div class="owl-carousel firstwealth-carousel owl-theme wow animate fadeInRight">
            <div class="item">
                <div class="firstwealth-sect">
                    <p>"A healthy lifestyle not only changes your body, it changes your mind, your attitude, and your
                        mood."
                    </p>
                    <h6>- Unknown</h6>
                </div>
            </div>
            <div class="item">
                <div class="firstwealth-sect">
                    <p>"The first wealth is health."</p>
                    <h6>- Ralph Waldo Emerson</h6>
                </div>
            </div>
            <div class="item">
                <div class="firstwealth-sect">
                    <p>"Health is a state of the body; wellness is a state of being."</p>
                    <h6>- J. Stanford</h6>
                </div>
            </div>
            <div class="item">
                <div class="firstwealth-sect">
                    <p>"Healthy habits are learned in the same way as unhealthy ones - through repetition."</p>
                    <h6>- Brian Tracy</h6>
                </div>
            </div>


        </div>

    </div>
    <!-- First Walth Section End -->

    <!-- Video Content Section -->
    <div class="videocontent-section">
        <div class="squareeffect"><img src="{{ asset('frontend/images/SquareEffect.png') }}" alt=""></div>
        <div class="container">
            <div class="videocontentcard">
                <h3>Video Content</h3>
            </div>


            <div class="theplan-head">
                <h2>The Plan that Fit</h2>
                <p>Choose a plan that suits Your Lifestyle & Goal</p>
            </div>

            <div class="row">

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="thetlanfit-sect active">
                        <h4><span>Recommended</span><br>
                            Swasth Arambh
                        </h4>
                        <ul>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> AI
                                Customised diet plan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Food
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                planner</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Body
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Face
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Yoga
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Brain
                                teaser game</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span>
                                Meditation</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> 799
                                Sweat coins</li>
                        </ul>

                        <div class="firstwealthfooter">
                            <h6>@799/mo only</h6> <a href="#" class="subscribe-btn">Subscribe</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="thetlanfit-sect">
                        <h4><span>Recommended</span><br>
                            Swasth Anubhav
                        </h4>
                        <ul>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Food
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                planner</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Body
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Face
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Yoga
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Brain
                                teaser game</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span>
                                Meditation</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> 799
                                Sweat coins</li>
                        </ul>

                        <div class="firstwealthfooter">
                            <h6>@2999/mo</h6> <a href="#" class="subscribe-btn">Subscribe</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="thetlanfit-sect">
                        <h4><span>Recommended</span><br>
                            Swasth Anushandhan
                        </h4>
                        <ul>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> AI
                                Customised diet plan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Food
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                planner</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Body
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Face
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Yoga
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Brain
                                teaser game</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span>
                                Meditation</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> 799
                                Sweat coins</li>
                        </ul>

                        <div class="firstwealthfooter">
                            <h6>@7999/quarterly</h6> <a href="#" class="subscribe-btn">Subscribe</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="thetlanfit-sect">
                        <h4><span>Recommended</span><br>
                            Swasth Arjit
                        </h4>
                        <ul>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Food
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                planner</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Body
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Workout
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Face
                                Scan</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Yoga
                                videos</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> Brain
                                teaser game</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span>
                                Meditation</li>
                            <li><span><img src="{{ asset('frontend/images/Arrow-right.png') }}" class=""
                                        alt=""></span> 799
                                Sweat coins</li>
                        </ul>

                        <div class="firstwealthfooter">
                            <h6>@14999/half yearly</h6> <a href="#" class="subscribe-btn">Subscribe</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- Video Content Section End -->



    <!-- MeetourTeam Section -->
    <div class="meetourteam-section">
        <div class="container">
            <h3>Swaasthfiit</h3>
            <p>SwaasthFiit aims to integrate health practices into everybody's life with a hassle-free experience. Our
                goal is to make health and fitness accessible to everyone, regardless of their lifestyle or financial
                resources.</p>
            <p>We strive to create an engaging and supportive environment so that our users can make meaningful and
                lasting changes to their health.</p>
            <p>Our platform provides users with easy-to-follow health and fitness plans tailored to their individual
                needs. We also offer personalised support and guidance to help them stay on track and reach their goals.
            </p>
            <p>With Swaasthfiit, everyone can take charge of their health and wellbeing.</p>

            <div class="meeteam-sect">
                <img src="{{ asset('frontend/images/meeteam-sect01.png') }}" alt="">
                <h2>Meet Our Team</h2>
            </div>

            <div class="row">

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg01.png') }}"
                                alt=""></div>
                        <h4>Rakhi Dutta</h4>
                        <h4><b>Rakhi Dutta</b></h4>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg02.png') }}"
                                alt=""></div>
                        <h4>Anirudh Das</h4>
                        <h4><b>Co-Director</b></h4>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg03.png') }}"
                                alt=""></div>
                        <h4>Abhhijit Das</h4>
                        <h4><b>Founder</b></h4>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg04.png') }}"
                                alt=""></div>
                        <h4>Titiksha Shri</h4>
                        <h4><b>Co-Founder &<br> Legal Head</b></h4>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg05.png') }}"
                                alt=""></div>
                        <h4>Harpreet Raheja</h4>
                        <h4><b>Co-Founder &<br> Finacial Advisor</b></h4>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg06.png') }}"
                                alt=""></div>
                        <h4>Amit Sharma</h4>
                        <h4><b>Advocate</b></h4>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12">
                    <h5>Coaches</h5>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg07.png') }}"
                                alt=""></div>
                        <h4>Raja Pathak</h4>
                        <h4><b>Fitness Coach</b></h4>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="meeteamcard">
                        <div class="meeteamimg"><img src="{{ asset('frontend/images/meeteamimg08.png') }}"
                                alt=""></div>
                        <h4>Ashish Singh</h4>
                        <h4><b>Fitness Coach</b></h4>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
