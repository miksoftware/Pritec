<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2025 MikSoftware. Todos los derechos reservados. Desarrollado por MikSoftware.</p>

    </div>
</footer>

<style>
    .footer {
        background-color: rgb(14, 13, 13);
        color: #ffffff;
        text-align: center;
        padding: 1rem 0;
        position: fixed;
        bottom: 0;
        width: calc(100% - 250px);
        margin-left: 250px;
        z-index: 1000;
        transition: all 0.3s;
    }

    #sidebar.collapsed+#content+.footer {
        width: calc(100% - 60px);
        margin-left: 60px;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer p {
        margin: 5px 0;
        font-size: 14px;
    }

    .footer i {
        color: #ff0000;
        margin: 0 5px;
    }

    #content {
        padding-bottom: 80px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.getElementById('toggle-btn').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    });
</script>
</body>

</html>