<!-- Botón "Volver Arriba" -->
<button id="btn-volver-arriba" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
    <i class="fas fa-arrow-up"></i>
</button>


<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date("Y") ?>. <a href="<?= base_url() ?>" id="inst_footer"><?= $_SESSION['userData']['razon'] ?></a>.</strong>
    <!-- Todos los derechos reservados. -->
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 2.0
    </div>
</footer>