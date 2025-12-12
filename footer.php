<?php
// footer.php - Common footer for pages
?>
    </main>
    <footer class="border-t border-black dark:border-[#392828] px-4 py-8 mt-8">
      <div class="container mx-auto flex items-center justify-between">
        <div class="text-sm">© 2025 Academia. Todos os direitos reservados.</div>
        <div class="flex gap-4">
          <a href="#" class="hover:text-primary">Termos</a>
          <a href="#" class="hover:text-primary">Privacidade</a>
        </div>
      </div>
    </footer>

  <div id="vlibras-wrapper"></div>
  <script>
    // on page unload, stop speech
    window.addEventListener('beforeunload', function(){ if(window.speechSynthesis) window.speechSynthesis.cancel(); });
  </script>
</body>
</html>