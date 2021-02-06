<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Example</title>
    <link rel="stylesheet" href="static/css/styles.css">
</head>
<body>

    <?php
        $message = isset($_GET['m']) ? $_GET['m'] : null;
        if ($message != null){
            echo "<script> alert('".$message."')</script>";
        }
    ?>
    <?php require_once("components/header.php"); ?>

    <div class="container">
        <form id="contact" action="../validation/FormValidation.php" method="post">
            <h3>Colorlib Contact Form</h3>
            <h4>Contact us for custom quote</h4>
            <fieldset>
                <input placeholder="Your name" type="text" tabindex="1" name="name" required autofocus>
                <span class="error" style="color: red; display: <?php echo isset($_GET['name'])? 'block' : 'none'; ?>">
                    <?= $_GET['name']?>
                </span>

            </fieldset>
            <fieldset>
                <input placeholder="Your Email Address" type="email" name="email" tabindex="2" required>
                <span class="error" style="display: <?php echo isset($_GET['email'])? 'block' : 'none'; ?>">
                    <?= $_GET['email']?>
                </span>
            </fieldset>
            <fieldset>
                <input placeholder="Your Phone Number (optional)" type="tel" name="phone" tabindex="3" required>
                <span class="error" style="display: <?php echo isset($_GET['phone'])? 'block' : 'none'; ?>">
                    <?= $_GET['phone']?>
                </span>
            </fieldset>
            <fieldset>
                <input placeholder="Your Web Site (optional)" type="url" name="url" tabindex="4" required>
                <span class="error" style="display: <?php echo isset($_GET['url'])? 'block' : 'none'; ?>">
                    <?= $_GET['url']?>
                </span>
            </fieldset>
            <fieldset>
                <textarea placeholder="Type your message here...." tabindex="5" name="description" required></textarea>
                <span class="error" style="display: <?php echo isset($_GET['description'])? 'block' : 'none'; ?>">
                    <?= $_GET['description']?>
                </span>
            </fieldset>
            <fieldset>
                <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
            </fieldset>
            <p class="copyright">Designed by <a href="https://colorlib.com" target="_blank" title="Colorlib">Colorlib</a></p>
        </form>
    </div>
        
    <?php require_once("components/footer.php"); ?>
</body>
</html>

