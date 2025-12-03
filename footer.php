    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="social-links">
                <a href="https://www.upwork.com/freelancers/~01a1b2c3d4e5f6g7h8" target="_blank" rel="noopener noreferrer" aria-label="Upwork Profile">
                    <i class="fab fa-upwork"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" aria-label="GitHub Profile">
                    <i class="fab fa-github"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn Profile">
                    <i class="fab fa-linkedin"></i>
                </a>
            </div>
            <p>&copy; <span id="year"></span> Kedir Mundino. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
    <?php if (isset($additional_scripts)): ?>
        <script>
            <?php echo $additional_scripts; ?>
        </script>
    <?php endif; ?>
</body>
</html>
