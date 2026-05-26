

<a href="<?= BASE_URL ?>/index.php?page=add_page" class="btn btn-primary">
Add New Page
</a>

<div class="row mt-5">

<div class="table-responsive">

<table class="table text-center">

<thead>
<tr>
<th>PID</th>
<th>Title</th>
<th>Update</th>
</tr>
</thead>

<tbody>

   <?php foreach($pages as $page): ?>

<tr>

  <td><?= htmlspecialchars($page['id']) ?></td>
                <td><?= htmlspecialchars($page['title']) ?></td>

                <td>
                    <a href="<?= BASE_URL ?>index.php?page=edit_page&id=<?= $page['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= BASE_URL ?>index.php?page=delete_page&id=<?= $page['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this page?')">Delete</a>
                </td>

</tr>

  <?php endforeach; ?>

</tbody>

</table>

</div>

