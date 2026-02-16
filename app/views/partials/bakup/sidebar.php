<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-text">BNGRC</div>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li <?= ($activePage ?? '') === 'dashboard' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/dashboard">Dashboard</a></li>
            <li <?= ($activePage ?? '') === 'villes' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/villes">Villes</a></li>
            <li <?= ($activePage ?? '') === 'besoins' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/besoins">Besoins</a></li>
            <li <?= ($activePage ?? '') === 'dons' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/dons">Dons</a></li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <p>© 2026</p>
    </div>
</aside>