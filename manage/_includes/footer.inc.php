                </div> <!-- end block-content-on-small-screens row -->
            </main>
        </div> <!-- end first 'row' -->
    </div> <!-- end first 'container-fluid' -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- jQuery UI -->
    <script src="jquery-ui/jquery-ui.min.js"></script>
    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <?php if ($pageTitle == 'Management Console') include '_includes/chart.js.inc.php'; ?>
    <script>
        // document ready
        $(function() {
            // initialize datepicker
            $("#datepicker").datepicker({
                dateFormat: "@" // unix timestamp in JS milleseconds
            });
            $("#datepicker").on("change", function() {
                var dpDate = $(this).val() / 1000; // convert unix timestamp to seconds
                var urlStr = "index.php?d=" + dpDate; // create url based on date picked
                // go to date-url from datepicker
                location.replace(urlStr);
            });
            // initialize dropdown
            $('.dropdown-toggle').dropdown();
            // prevent dropdown menu from closing on click inside
            $('.dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>