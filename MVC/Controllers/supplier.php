<?php
class supplier extends controller {
    private $supplier_n;

    public function __construct() {
        $this->supplier_n = $this->model('supplier_m');
    }

    public function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'supplier_v'
        ]);
    }
}

?>