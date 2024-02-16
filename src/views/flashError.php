<style>
    .alert-error {
        color: crimson;
        font-size: 14px;
    }
</style>

<p class="alert-error"><?=$errors['body']?></p>

<script>
    document.addEventListener("input", (event) => {
        element = document.querySelector('.alert-error')
        if (element) {
            const target = event.target
            const sibling = element.previousElementSibling.previousElementSibling
            if (target === sibling) {
                element.parentElement.removeChild(element);
            }
        }
    });
</script>