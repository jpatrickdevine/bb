            <!-- Start sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column pt-2">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pageTitle == 'Management Console') echo "active" ?>" href="index.php">
                                <i class="fas fa-home"></i>
                                Dashboard <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pageTitle == 'Requests') echo "active" ?>" href="requests.php">
                                <i class="far fa-paper-plane"></i>
                                Requests
                                <?php if ($pageTitle != 'Requests')
                                {
                                    if ($newRequests == "0")
                                    {
                                        $newRequests = "";
                                    }
                                    echo "<span class='badge badge-pill badge-danger'>" . $newRequests . "</span>\n";
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item not-allowed">
                            <a class="nav-link disabled" href="#">
                                <i class="fas fa-utensils"></i>
                                Reservations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pageTitle == 'Guestbook') echo "active" ?>" href="guestbook.php">
                                <i class="fas fa-book-open"></i>
                                Guestbook
                            </a>
                        </li>
                        <li class="nav-item not-allowed">
                            <a class="nav-link disabled" href="#">
                                <i class="fas fa-chart-bar"></i>
                                Insights
                            </a>
                        </li>
                    </ul>
                                    
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Analytics</span>
                    </h6>
                    <ul class="nav flex-column pt-2">
                        <li class="nav-item not-allowed">
                            <a class="nav-link disabled" href="#">
                                <i class="fas fa-chart-line"></i>
                                Website
                            </a>
                        </li>
                        <li class="nav-item not-allowed">
                            <a class="nav-link disabled" href="#">
                                <i class="fas fa-chart-line"></i>
                                Social Media
                            </a>
                        </li>
                        <li class="nav-item not-allowed">
                            <a class="nav-link disabled" href="#">
                                <i class="fas fa-chart-line"></i>
                                Email
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <!-- Alert if smaller than landscape iPad -->
                <div class="alert alert-danger d-lg-none w-100 mt-4">
                    Your window width is too narrow for this app. Use a larger device or maximize your window for all features.
                </div>
                <!-- Show content on large enough screens -->
                <div class="d-none d-lg-block">
<?php // start main content ?>