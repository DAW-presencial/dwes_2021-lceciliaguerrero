<?php
include_once("config/core.php");
$page_title = "Register";
include_once("login_checker.php");
include_once("config/database.php");
include_once("objects/user.php");
include_once("libs/php/utils.php");
include_once("layout_head.php");
echo "<div class='col-md-12'>";
if ($_POST) {
    $database = new database();
    $db = $database->getConnectionDataBase();
    $user = new User($db);
    $utils = new Utils();
    $user->email = $_POST['email'];
    if ($user->emailExists()) {
        echo "<div class='alert alert-danger'>";
        echo "The email you specified is already registered. Please try again or <a href='{$applicationUrl}login'>login.</a>";
        echo "</div>";
    } else {
        $user->publicName = $_POST['name'];
        $user->publicPassword = $_POST['password'];
        $user->publicAccessLevel = 'Customer';
        $user->publicStatus = 1;
        if ($user->create()) {
            echo "<div class='alert alert-info'>";
            echo "Successfully registered. <a href='{$applicationUrl}login'>Please login</a>.";
            echo "</div>";
            $_POST = array();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Unable to register. Please try again.</div>";
        }
    }
}
?>
    <form action='register.php' method='post' id='register'>
        <table class='table table-responsive'>
            <tr>
                <td class='width-30-percent'>Name</td>
                <td><input type='text' name='firstname' class='form-control' required
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : ""; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type='email' name='email' class='form-control' required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ""; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Register
                    </button>
                </td>
            </tr>
        </table>
    </form>
<?php
echo "</div>";
include_once("layout_foot.php");
