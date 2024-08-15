<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    function submitDeleteForm(button){
        const userResponse = confirm('Are you sure you want to delete');
        if(userResponse){
            const form = button.parentElement;
            form.submit();
        }
    }
</script>