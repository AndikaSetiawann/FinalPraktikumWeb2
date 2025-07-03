<h3>Latest Artikel<?= $category ? ' - ' . esc($category) : '' ?></h3>

<?php if (!empty($artikel)) : ?>
  <ul>
    <?php foreach ($artikel as $row) : ?>
      <li>
        <a href="<?= base_url('/artikel/' . esc($row['slug'])) ?>">
          <?= esc($row['title']) ?>
        </a><br>

        <small>Posted in: <?= date('d M Y H:i', strtotime($row['created_at'])) ?></small><br>
        <small>Category: <?= esc($row['category']) ?></small>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else : ?>
  <p>There are no artikel in this category.</p>
<?php endif; ?>
