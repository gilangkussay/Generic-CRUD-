<div class="page-heading"><div><p class="eyebrow">RINGKASAN</p><h1>Dashboard</h1><p class="muted">Ikhtisar data yang sedang dikelola dalam template CRUD.</p></div><a class="btn btn-primary" href="<?= e(url('records-create')) ?>">＋ Tambah data</a></div>
<div class="stats-grid">
    <article class="stat-card"><div class="stat-top"><span class="stat-icon purple">▤</span><span class="stat-trend">Total</span></div><p>Total data</p><strong><?= number_format((int) $stats['total']) ?></strong><small>Semua data tersimpan</small></article>
    <article class="stat-card"><div class="stat-top"><span class="stat-icon green">✓</span><span class="stat-trend positive">Aktif</span></div><p>Data aktif</p><strong><?= number_format((int) $stats['active']) ?></strong><small>Status aktif</small></article>
    <article class="stat-card"><div class="stat-top"><span class="stat-icon orange">◫</span><span class="stat-trend">Kategori</span></div><p>Kategori berbeda</p><strong><?= number_format((int) $stats['categories']) ?></strong><small>Kelompok data</small></article>
    <article class="stat-card"><div class="stat-top"><span class="stat-icon blue">∑</span><span class="stat-trend">Agregat</span></div><p>Total nilai angka</p><strong><?= e(format_number($stats['sum'])) ?></strong><small>Sesuaikan makna field pada tugas</small></article>
</div>
<div class="panel"><div class="panel-heading"><div><h2>Data terbaru</h2><p>Data terakhir diperbarui</p></div><a class="text-link" href="<?= e(url('records')) ?>">Lihat semua →</a></div>
<?php if ($latest === []): ?>
    <div class="empty-state"><div class="empty-icon">▤</div><h3>Belum ada data</h3><p>Tambahkan data pertama untuk mencoba alur CRUD.</p><a href="<?= e(url('records-create')) ?>" class="btn btn-primary">Tambah data pertama</a></div>
<?php else: ?>
    <div class="table-wrap"><table><thead><tr><th>KODE</th><th>NAMA</th><th>KATEGORI</th><th>NILAI ANGKA</th><th>STATUS</th></tr></thead><tbody>
    <?php foreach ($latest as $record): ?><tr><td><span class="code-chip"><?= e($record['record_code']) ?></span></td><td class="cell-primary"><?= e($record['name']) ?></td><td><?= e($record['category']) ?></td><td><?= e(format_number($record['numeric_value'] ?? 0)) ?></td><td><span class="status status-<?= e($record['status']) ?>"><?= $record['status'] === 'active' ? 'Aktif' : 'Nonaktif' ?></span></td></tr><?php endforeach; ?>
    </tbody></table></div>
<?php endif; ?></div>
<div class="tip-card"><div class="tip-symbol">✦</div><div><strong>Tips adaptasi untuk Ujikom</strong><p>Mulai dari spesifikasi: catat entitas, field, relasi, validasi, dan alur kerja. Jangan langsung mengganti kode sebelum memahami kebutuhan.</p></div><a href="docs/PANDUAN-ADAPTASI.md" class="text-link">Baca panduan ↗</a></div>
