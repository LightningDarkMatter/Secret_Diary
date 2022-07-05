<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(".toggleForms").click(function() {
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
        });

        $("#diary").bind("input propertychange", function() {
            $.ajax({
                method: "POST",
                url: "update.php",
                data: {
                    content: $("#diary").val()
                }
            })
        });

    </script> 
</body>
</html>
