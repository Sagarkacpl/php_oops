<?php require_once(__DIR__ . '/../../models/User.php'); ?>
<h2>Welcome, Admin!</h2>
<p>This is the admin dashboard.</p>
<a href="<?= BASE_URL ?>/admin/logout">Logout</a>

<h3>Users</h3>

<!-- Create User Form -->
<form method="post" action="<?= BASE_URL ?>/user/create">
    <input type="text" name="username" placeholder="Username" required>
    <button type="submit">Add User</button>
</form>

<!-- Users List (Read) -->
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td>
            <!-- Edit User Link -->
            <a href="<?= BASE_URL ?>/user/edit/<?= urlencode(convert_string('encrypt', $user['id'])) ?>">Edit</a>
            <!-- Delete User -->
            <form method="post" action="<?= BASE_URL ?>/user/delete" style="display:inline;">
                <input type="hidden" name="id" value="<?= htmlspecialchars(convert_string('encrypt', $user['id'])) ?>">
                <button type="submit" onclick="return confirm('Delete this user?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>