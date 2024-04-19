<?php
?>

<footer class="py-1 my-0 fixed-bottom" style="background-color: #3297a8; position: fixed">

    <p class="text-center p-2" style="color: azure">© 2024 KeyCyber, Inc</p>
</footer>
<script>
    function onav() {
        document.getElementById("sidenav").style.width = "190px";
        document.getElementById("ul").style.display= "block";
        document.getElementById("close").style.display = "block";
        document.getElementById("open").style.display = "none";
        document.getElementById("iframe").style.right ="0px";

    }
    function cnav() {
        document.getElementById("sidenav").style.width = "0";
        document.getElementById("ul").style.display= "none";
        document.getElementById("close").style.display = "none";
        document.getElementById("open").style.display = "block";
        document.getElementById("iframe").style.left ="0px";


    }


</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
