<div id="page-progress"></div>

<header class="mh-header">
    <div class="container">
        <div class="mh-row">

            <!-- Logo -->
            <a href="{{ route('frontend.index') }}" class="mh-logo">
                <img src="https://andaleebtours.com/assets/uploads/logo/andaleeb_logo_200x58176314551092.webp"
                    alt="Andaleeb Travel Agency" />
            </a>

            <!-- Navigation -->
            <nav class="mh-nav">
                <ul class="mh-nav-list">
                    <li><a href="">Dubai Tours</a></li>
                    <li><a href="">Holidays</a></li>
                    <li><a href="">Hotels</a></li>
                    <li><a href="">Insurance</a></li>
                </ul>
            </nav>

            <!-- Actions -->
            <div class="mh-actions">

                <!-- Contact -->
                <div class="mh-contact-group">
                    <a href="tel:+971525748986" class="mh-link">
                        <i class="bx bxl-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="tel:+97145766068" class="mh-btn-primary">
                        <i class="bx bx-phone"></i>
                        <span>Helpline</span>
                    </a>
                </div>

                <span class="mh-divider"></span>

                <!-- User/Cart -->
                <div class="mh-icons-group">
                    <a href="{{ route('frontend.auth.login') }}" class="mh-icon-link">
                        <i class="bx bx-user"></i>
                    </a>
                    <a href="" class="mh-icon-link mh-cart">
                        <i class='bx bx-shopping-bag'></i>
                        <span class="mh-badge">0</span>
                    </a>
                    <a href="javascript:void(0);" class="mh-icon-link menu-btn" data-menu-button
                        onclick="openSideBar()">
                        <i class="bx bx-menu"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</header>

<div class="sideBar" id="sideBar">
    <a href="javascript:void(0)" class="sideBar__close" onclick="closeSideBar()">×</a>
    <a href="{{ route('frontend.index') }}" class="sideBar__logo">
        <img src="https://andaleebtours.com/assets/uploads/logo/andaleeb_logo_200x58176314551092.webp" alt="Logo"
            class="imgFluid">
    </a>
    <ul class="sideBar__nav">
        <li><a href="#">About Us </a></li>
        <li><a href="#">Dubai Tour Packages</a></li>
        <li><a href="#">Holiday Packages</a></li>
        <li><a href="#">Hotels</a></li>
        <li><a href="#">Travel Insurance</a></li>
        <li><a href="#">Contact Us</a></li>
    </ul>
    <div class="sidebar-btns-wrapper">
        <a href="tel:+971 45766068" class="themeBtn"><i class="bx bx-phone"></i>Helpline</a>
        <a href="tel:+971 525748986" class="themeBtn"><i class="bx bxl-whatsapp"></i>WhatsApp</a>
    </div>
</div>


<div class="first-section"></div>
