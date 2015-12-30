<HTML xmlns="http://www.w3.org/1999/html">
<HEAD>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $(document).ready(function()
        {

            $("#button").click(function() {

                $.ajax({
                    type: "post",
                    url: "http://localhost/lis/ajax/check",
                    cache: false,

                    data: $('#userForm').serialize(),
                    success: function (json) {
                        try {
                            var obj = jQuery.parseJSON(json);

                            alert('hurray');


                        } catch (e) {
                            alert('Exception while request..');
                        }
                    },
                    error: function () {
                        alert('Error while request..');
                    }

                });
            });


        });

    </script>

</HEAD>
<BODY>

<form name="userForm" id="userForm" type="POST" >
    <table border="1">
        <tr>
            <td valign="top" align="left">
                Username:- <input type="text" name="userName" id="userName" value="">
            </td>
        </tr>
        <tr>
            <td valign="top" align="left">
                Password :- <input type="password" name="userPassword" id="userPassword" value="">
            </td>
        </tr>
        <tr>
            <td>
                <button id="button" class="button">Get External Content</button>
            </td>
        </tr>
    </table>
</form>
<div id="data" class="data1"></div>

</BODY>

</HTML>