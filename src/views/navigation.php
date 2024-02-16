<?php 
    $active = null;
    if(isset($_SESSION['active'])) {
        $active = $_SESSION['active'];
    }

    $user = null;

    if(isset($_SESSION['user'])) {
        $user = $_SESSION['user']['user'];
        if (isset($_SESSION['user']['expiry_time'])) { 
            if (time() > $_SESSION['user']['expiry_time']) {
                $user = null;
                session_destroy();
            }
        }
    }

?>

<?php if(isset($user)): ?>
    <nav class="roboto-bold">
        <div class="left">
            <div class="logo"></div>
            <ul>
                <li><a href="/" class="<?= $active === '/' ? 'active' : '' ?>">Home</a></li>
                <li><a href="/notes" class="<?= $active === '/notes' ? 'active' : '' ?>">Notes</a></li>
                <li><a href="/about" class="<?= $active === '/about' ? 'active' : '' ?>">About</a></li>
                <li><a href="/contact" class="<?= $active === '/contact' ? 'active' : '' ?>">Contact</a></li>
            </ul>
        </div>
        <div class="right">
            <ul>
                <li><a href="/logout">Logout</a></li>
                <li><div class="notification">
                    <i class="fa-solid fa-bell"></i>
                </div></li>
                <li><div class="profile">
                    <img src="<?= assets('images/dummy_profile.png') ?>" alt="profile" class="profile">
                </div></li>
            </ul>
        </div>
    </nav>
<?php else: ?>
    <nav class="roboto-bold">
        <div class="left">
            <ul>
            <li><a href="/" class="<?= $active === '/' ? 'active' : '' ?>">Home</a></li>
            <li><a href="/login" class="<?= $active === '/login' ? 'active' : '' ?>">Login</a></li>
            <li><a href="/register" class="<?= $active === '/register' ? 'active' : '' ?>">Register</a></li>
            </ul>
        </div>
    </nav>
<?php endif; ?>