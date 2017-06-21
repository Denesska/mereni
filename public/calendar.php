<?php
require_once "../includes/layout/session.php";
$title = "Calendar  personal";
$page="calendar";
$j=0;
?>
<?php
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
?>

    <main class="container">
            <iframe id="google_calendar" src="https://calendar.google.com/calendar/embed?src=denesska%40gmail.com&ctz=Europe/Bucharest"></iframe>
    </main>

<?php require "../includes/layout/bottom_page.php" ?>