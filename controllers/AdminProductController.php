<?php

require_once '../models/Product.php';

class AdminProductController {

    protected $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function save($data) {
        $this->product->create($data);
        return "Successfully inserted data!!";
    }
}


// $obj = new AdminProductController();
// $data = [
//             'name' => "Sample Product3",
//             'price' => 200.25,
//             'description' => "LLorem1 Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
//         ];

// $db = $obj->save($data);

// print_r($db);die;

?>