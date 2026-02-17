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
            <li <?= ($activePage ?? '') === 'achats' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/achats">Achats</a></li>
            <li <?= ($activePage ?? '') === 'dispatch' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/dispatch">Dispatch</a></li>
            <li <?= ($activePage ?? '') === 'produits' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/produits">Produits</a></li>
            <li <?= ($activePage ?? '') === 'categories' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/categorie">Catégories</a></li>
            <li <?= ($activePage ?? '') === 'categories' ? 'class="active"' : '' ?>><a href="<?= BASE_URL ?>/recapitulation">Recapitulatifs</a></li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <p>© 2026</p>
    </div>
</aside>