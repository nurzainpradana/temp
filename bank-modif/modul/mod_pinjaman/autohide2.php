<html>
<head>
    <title>Test Hide/Show Fields</title>
    <script language="javascript" type="text/javascript" src="jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="showhide.js"></script>
</head>
<body>
    <?php
        //this will show you the values in the form the data when you hit the submit button
        if ($_POST) {
            echo "Form was submitted, here are the form values: <pre>";
            print_r($_POST);
            echo "</pre>";
        }
    ?>
    <form method='POST'>
        <p>Name: <input type="text" name='player_name' /></p>
        <p>Email: <input type="text" name='player_email' /></p>
        <p>Age: 
             <select id='age' name='age'>
             <?php
                  //sorry but if you're over 30 you're too old to join, lol
                  for ($age = 6; $age <= 30; $age++)
                       echo "<option value='$age'>$age</option>";
             ?>
             </select>
        </p>
        <div id='parentPermission'>
                <p>Parent's Name: <input type='text' name='parent_name' /></p>
                <p>Parent's Email: <input type='text' name='parent_email' /></p>
                <p>You must have parental permission before you can play.</p>
        </div>
        <p align='center'><input type='submit' value='Join Game!' /></p> 
 </form>
</body>
</html>