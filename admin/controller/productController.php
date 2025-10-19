<?php
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../../user/model/Comment.php';


class ProductController {
    private $productModel;
    private $commentModel;

    public function __construct() {
        global $conn;
        $this->productModel = new Product($conn);
        $this->commentModel = new Comment($conn);

        // Kiểm tra admin đã đăng nhập
        if(!isset($_SESSION['admin'])) {
            header("Location: index.php?controller=admin&action=login");
            exit;
        }
    }


    public function index() {
        $products = $this->productModel->getAll();

        // Gắn thêm thống kê đánh giá vào từng sản phẩm
        foreach ($products as &$p) {
            $stats = $this->commentModel->getStatsByProduct($p['id']);
            $p['total_comments'] = $stats['total_comments'] ?? 0;
            $p['avg_rating'] = $stats['avg_rating'] ?? 0;
        }

        include 'view/home.php';
    }

    // Danh sách sản phẩm
    public function list() {
        $products = $this->productModel->getAll();
        include __DIR__ . '/../view/product_list.php';
    }

    // Thêm sản phẩm
    public function add() {
        $error = '';
        $product = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            $description = $_POST['description'] ?? '';
            $discount = $_POST['discount'] ?? 0;
            $image = null;
            

           if(isset($_FILES['image']) && $_FILES['image']['name']) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            // Tạo tên ảnh duy nhất theo id sản phẩm hoặc uniqid
            $imageName = uniqid() . '.' . $ext;
            $targetPath = __DIR__ . '/../assets/images/products/' . $imageName;

            if(move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = $imageName; // Lưu vào DB
            }else{
                    $error = "Upload ảnh thất bại!";
            }
            } else {
            // Nếu không upload file mới, giữ ảnh cũ (chỉ khi edit)
    
            $image = $product['image'] ?? null;
            }
    

            if(empty($name)) $error = "Tên sản phẩm không được để trống";

                if(empty($error)) {
                    $this->productModel->create($name, $price, $quantity, $description, $image, $discount);
                    header("Location: index.php?controller=product&action=list");
                    exit;
                }

                $product = ['name'=>$name, 'price'=>$price, 'quantity'=>$quantity, 'description'=>$description, 'image'=>$image, 'discount'=>$discount];
            }

                include __DIR__ . '/../view/product_form.php';
    }

    // Sửa sản phẩm
    public function edit() {
        $error = '';
        $id = $_GET['id'] ?? 0;
        $discount = $_POST['discount'] ?? 0;
        $product = $this->productModel->getById($id);

        if(!$product) {
            $_SESSION['error'] = "Sản phẩm không tồn tại";
            header("Location: index.php?controller=product&action=list");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            $description = $_POST['description'] ?? '';
            $image = $product['image'];

            if(isset($_FILES['image']) && $_FILES['image']['name']) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/products/' . $image);
            }

            if(empty($name)) $error = "Tên sản phẩm không được để trống";

            if(empty($error)) {
                $this->productModel->update($id, $name, $price, $quantity, $description, $image, $discount);
                header("Location: index.php?controller=product&action=list");
                exit;
            }

            $product = ['id'=>$id,'name'=>$name,'price'=>$price,'quantity'=>$quantity,'description'=>$description,'image'=>$image,'discount'=>$discount];
        }

        include __DIR__ . '/../view/product_form.php';
    }

    // Xóa sản phẩm
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->productModel->delete($id);
        header("Location: index.php?controller=product&action=list");
        exit;
    }

    
}
?>