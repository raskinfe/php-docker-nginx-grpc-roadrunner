<?php
    include("src/views/layout.php");
?>

<link rel="stylesheet" href="<?= assets('css/notes.css')?>">

<div class="container">
    <header>
        <div>
            <input type="text" name="note" id="note">
            <input type="submit" value="Create note" class="btn btn-secondary" onclick="createNote()">
        </div>
    </header>
    <main>
        <?php if(isset($notes) && count($notes) > 0):?>
            <?php foreach($notes as $note):?>
                <div class="note-container">
                    <span><?=$note->getContent() ?></span>
                    <span><?=$note->getAuthor()->getUsername() ?></span>
                    <span><?= $note->getDate()->format('d-m-Y H:m:s') ?></span>
                    <?php if($note->getAuthor()->getId() !== currentUser()->getId()): ?>
                        <div class="actions">
                            <span class="disabled"><i class="fa fa-edit"></i></span>
                            <span class="disabled"><i class="fa fa-trash"></i></span>
                        </div>
                    <?php else: ?>
                        <div class="actions">
                            <a href="/note?id=<?= $note->getId()?>"" class="edit"><i class="fa fa-edit"></i> </a>
                            <form id="form" action="/note?id=<?= $note->getId()?>" method="post">
                                <input type="text" hidden name="_method" value="delete">
                                <input type="text" hidden name="id" value="<?= $note->getId()?>">
                                <a href="#" class="delete" onclick="document.getElementById('form').submit();"><i class="fa fa-trash"></i> </a>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>

<script>
    async function createNote() {
        const contentElement = document.getElementById('note');
        const content = contentElement?.value;

        const data = {
            content
        }
        
        const response =await fetch('/create-note', {
            headers: {
                "Content-Type": "Application/json"
            },
            method: 'POST',
            credentials: "same-origin",
            body: JSON.stringify(data)
        })
        

        if(response.status === 201) {
            window.location.reload();
        }
    }
</script>