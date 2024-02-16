<?php

    include("layout.php");
?>
<body>
    <div class="container">
        <header>
            <div>Signup form</div>
        </header>
        <main>
            <form method="post" action="/register" class="">
                <div>
                    <input value="<?php if(isset($request)){ echo $request['name']; } ?>" type="text" name="name" placeholder="Name" required>
                </div>
                <div>
                    <input value="<?php if(isset($request)){ echo $request['username']; } ?>" type="text" name="username" placeholder="Username" required>
                    <?php if(isset($errors['username'])): ?>
                        <?php include('flashError.php');?>
                    <?php endif; ?>
                </div>
                <div>
                    <input value="<?php if(isset($request)){ echo $request['email']; } ?>" type="email" name="email" placeholder="Email" required>
                    <?php if(isset($errors['email'])): ?>
                        <?php include('flashError.php');?>
                    <?php endif; ?>
                </div>
                <!-- <div>
                    <input type="email" name="repeat_email" placeholder="Repeat email" required>
                </div> -->
                <div>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <!-- <div>
                    <input type="password" name="repeat_password" placeholder="Repeat password" required>
                </div> -->
                <input type="submit" value="Signup" class="btn btn-primary">
            </form>
        </main>
        <?php
              include('flashMessage.php')
        ?>
    </div>
</body>
</html>