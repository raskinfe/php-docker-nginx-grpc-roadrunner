<div>
    <?php 
        $flashMessage = getFlashMessage();
        if(isset($flashMessage) && !empty($flashMessage)): ?>
        <?php $className = $flashMessage['type']; ?>
        <div class="flashMessage">
            <span class="<?=$className ?? ''?>"><?= $flashMessage['message']?></span>
        </div>
    <?php endif; ?>
</div>

<script>
    const messageElement = document.querySelector('.flashMessage');
    if (messageElement) {
        setTimeout(() => {
            messageElement.parentElement.removeChild(messageElement);
        }, 2000)
    }
</script>