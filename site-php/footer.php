<?php 
include "./config.php";
error_reporting( E_ALL );
// session_start();


if ( isset( $_SESSION["token"] ) ) {
    $token = $_SESSION["token"];
}else{
    $token = "";
}
if ( empty( $token ) ) {
    echo "<meta http-equiv='refresh' content='2; url=".$base_url."/index.php?cod=1' />";
}
?>

<footer class="app-footer"> <!--begin::To the end-->
    <div class="float-end d-none d-sm-inline">INCLUSIVE CCTV</div> <!--end::To the end--> <!--begin::Copyright--> <strong>
        Copyright &copy; 2020-<?php echo date('Y'); ?>&nbsp;
        <a href="https://inclusive.cl" class="text-decoration-none">Inclusive.cl</a>.
    </strong>
    All rights reserved.
    <!--end::Copyright-->
</footer>