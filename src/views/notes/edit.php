<?php
    include(dirname(__DIR__)."/layout.php");
?>

<link rel="stylesheet" href="src/assets/css/notes.css">

<div class="container">
    <header>
        <div>
            <form method="post" action="/note">
                <input type="text" hidden name="id" value="<?= $note->getId(); ?>">
                <input type="text" hidden name="_method" value="PATCH">
                <input type="text" name="content" id="note" value="<?= $note->getContent()?>">
                <input type="submit" value="Update note" class="btn btn-secondary">
            </form>
        </div>
    </header>
</div>