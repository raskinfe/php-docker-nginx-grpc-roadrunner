<?php
    include("layout.php");
?>

<div class="container">
    <header>
        <div>Login form</div>
    </header>
    <main>
        <form method="post" action="/login" class="">
            <div>
                <input 
                    value="<?php if(isset($request)){ echo $request['username']; } ?>" 
                    type="text" 
                    name="username" 
                    placeholder="Username" 
                    required
                >
                <?php if(isset($errors['username'])): ?>
                    <?php include('flashError.php');?>
                <?php endif; ?>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" required>
                <?php if(isset($errors['password'])): ?>
                    <?php include('flashError.php');?>
                <?php endif; ?>
            </div>
            <input type="submit" value="Login" class="btn btn-primary">
        </form>

        <div class="register-cta">
            Not registered yet? <a class="cta" href="/register">Signup</a>
        </div>

        <?php
            include('flashMessage.php')
        ?>
    </main>
</div>
