<?php
$unauthorizedFooter = pathinfo($_SERVER["PHP_SELF"]);
if(($unauthorizedFooter["filename"] == "footer")){
    header("Location:http://" . $_SERVER["SERVER_NAME"] . pathinfo($_SERVER["PHP_SELF"])["dirname"]);
    exit();
}
?>
<footer class="bg-light text-lg-start">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © <?= date("Y"); ?> Copyright:
        <a class="text-dark" target="_blank" href="https://mehmetozgul.com/">mehmetozgul.com</a>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>