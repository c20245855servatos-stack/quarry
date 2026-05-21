<?php ob_start(); ?>
<h2>Create User</h2>

<form method="POST" action="?controller=user&action=store">

    <input type="text" name="full_name" placeholder="Full Name" required>

    <input type="text" name="contact_number" placeholder="Contact Number">

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Password" required>

    <textarea name="address" placeholder="Address"></textarea>

    <label>
        <input type="checkbox" name="is_admin" value="1">
        Is Admin
    </label>

    <button type="submit">Create</button>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';