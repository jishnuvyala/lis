<html>
<head>
    <title></title>
    <style>

        ..box {
            width:300px;
            height:300px;
            background-color:#d9d9d9;
            position:fixed;
            margin-left:-150px; /* half of width */
            margin-top:-150px;  /* half of height */
            top:50%;
            left:50%;
        }
    </style>
</head>
<body>

<table class="box" border="1" cellpadding="1" cellspacing="1" style="width: 100%;">
    <tbody>
    <tr>
        <?php foreach($card as $row){ ?>
        <td style="text-align: center; vertical-align: middle;">
            <p>
                <strong>Lab Number&nbsp;</strong>: <?php echo $row->lab_number; ?></p>
            <p>
                <strong>Name</strong>&nbsp;: <?php echo $row->name; ?> &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<strong>Age&nbsp;</strong>: <?php echo $row->age;?>  </p>
            <p>
                <strong>Address&nbsp;</strong>:<?php echo $row->address; ?></p>
            <p>
                <strong>Phone</strong>&nbsp;: <?php echo $row->phone_no; ?> &nbsp;<strong>Email</strong>&nbsp;: <?php echo $row->email; ?></p>
            <div>
                &nbsp;</div>
        </td>
        <?php } ?>
    </tr>
    </tbody>
</table>
<p>
    &nbsp;</p>

</body>
</html>
