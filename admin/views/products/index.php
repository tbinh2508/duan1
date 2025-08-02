<h2>Danh sách sản phẩm</h2>
<a href="index.php?controller=product&action=create">+ Thêm sản phẩm</a>
<table border="1">
    <tr><th>ID</th><th>Tên</th><th>Danh mục</th><th>Thương hiệu</th><th>Giá</th><th>Hành động</th></tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= $p["id"] ?></td>
        <td><?= $p["name"] ?></td>
        <td><?= $p["category_name"] ?></td>
        <td><?= $p["brand_name"] ?></td>
        <td><?= $p["price"] ?></td>
        <td>
            <a href="index.php?controller=product&action=edit&id=<?= $p["id"] ?>">Sửa</a> |
            <a href="index.php?controller=product&action=delete&id=<?= $p["id"] ?>">Xoá</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
