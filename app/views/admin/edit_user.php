<?php require_once(__DIR__ . '/../../models/User.php'); ?>
<h2>Edit User</h2>
<form method="post" action="<?= BASE_URL ?>/user/update">
    <input type="hidden" name="id" value="<?= htmlspecialchars(convert_string('encrypt', $user['id'])) ?>">
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    <button type="submit">Update</button>
    <a href="<?= BASE_URL ?>/admin/dashboard">Cancel</a>
</form>
