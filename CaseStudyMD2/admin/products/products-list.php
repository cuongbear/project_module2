<?php
include '../layouts/header.php';
include '../layouts/sidebar.php';
include_once '../layouts/db.php';

$sql = "SELECT products.*, categories.name AS category_name FROM `products` 
JOIN categories ON products.category_id = categories.id ";
// echo '<pre>';
// print_r($sql);die;

$sql = "SELECT COUNT(id) AS total_records FROM `products`";
$stmt = $conn->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$pagination = $stmt->fetch();
// echo '<pre>';
// print_r($pagination);die;

$total_records = $pagination['total_records']; //45
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; //2
$limit = 3;
$total_page = ceil($total_records / $limit);
if ($current_page > $total_page) {
    $current_page = $total_page;
} else if ($current_page < 1) {
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$sql = "SELECT products.*, categories.name AS category_name FROM `products` 
JOIN categories ON products.category_id = categories.id  order by products.id desc LIMIT $start, $limit ";

$stmt = $conn->query($sql);
$stmt->setFetchMode(PDO::FETCH_OBJ);
$rows = $stmt->fetchAll();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Danh Sách</h1>
            <div class="row">
                <div class="col-lg-12">
                    <form class="search-form" action="products-search.php" method="POST">
                        <input class="btn btn-outline-dark" type="search" placeholder="Tìm Kiếm" name="search" title="Tìm Kiếm">
                        <button type="submit" class="btn btn-primary">Gửi</button>
                        <a href="products-add.php" class="btn btn-primary">Thêm</a>
                    </form>
                    <table border="1" class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Mã Sản Phẩm</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Giá Sản Phẩm</th>
                                <th>Số Lượng Sản Phẩm</th>
                                <th>Tên Danh Mục</th>
                                <th>Mô Tả Sản Phẩm</th>
                                <th>Tùy Chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row) : ?>
                                <tr>
                                    <td><?php echo $row->id; ?></td>
                                    <td><?php echo $row->products_name; ?></td>
                                    <td><?php echo $row->price; ?></td>
                                    <td><?php echo $row->amount; ?></td>
                                    <td><?php echo $row->category_name; ?></td>
                                    <td><?php echo $row->description; ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="products-edit.php?id=<?php echo $row->id; ?>">Sửa</a>
                                        <a class="btn btn-danger" href="products-delete.php?id=<?php echo $row->id; ?>">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                    <div class="dataTable-bottom">
                        <nav class="dataTable-pagination">
                            <ul class="dataTable-pagination-list">
                                <?php
                                if ($current_page > 1 && $total_page > 1) {
                                    echo '<li><a href="products-list.php?page=' . ($current_page - 1) . '">Prev</a></li>';
                                }
                                for ($i = 1; $i <= $total_page; $i++) {
                                    if ($i == $current_page) {
                                        echo '<a>' . $i . '</a>';
                                    } else {
                                        echo '<li><a href="products-list.php?page=' . $i . '">' . $i . '</a></li>';
                                    }
                                }
                                if ($current_page < $total_page && $total_page > 1) {
                                    echo '<li><a href="products-list.php?page=' . ($current_page + 1) . '">Next</a></li>';
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>