<form method="post" action="index.php?controller=product&action=<?= isset($product) ? 'update' : 'store' ?>">
    <?php if (isset($product)): ?>
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
    <?php endif; ?>

    <input name="name" value="<?= $product['name'] ?? '' ?>" placeholder="Tên sản phẩm"><br>

    <select name="brand_id">
        <?php foreach ($brands as $b): ?>
            <option value="<?= $b['id'] ?>" <?= isset($product) && $product['brand_id'] == $b['id'] ? 'selected' : '' ?>>
                <?= $b['name'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <select name="category_id">
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>" <?= isset($product) && $product['category_id'] == $c['id'] ? 'selected' : '' ?>>
                <?= $c['name'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <textarea name="description"><?= $product['description'] ?? '' ?></textarea><br>
    <input name="price" type="number" value="<?= $product['price'] ?? '' ?>" step="0.01"><br>

    <button type="submit"><?= isset($product) ? 'Cập nhật' : 'Thêm mới' ?></button>
</form>
