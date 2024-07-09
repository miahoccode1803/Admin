<?php
class list_supplier extends controller {
    private $lst_supplier;

    public function __construct() {
        $this->lst_supplier = $this->model('supplier_m');
    }

    public function Get_data() {
        $data = $this->lst_supplier->supplier_find('name','');
        $this->view('Masterlayout', [
            'data' => $data,
            'page' => 'list_supplier_v'
        ]);
    }

    public function add() {
        $message = '';
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $contact_name = $_POST['contact_name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
    
            // Validate input here if needed
    
            // Check for duplicate name
            if ($this->lst_supplier->duplicateName($name)) {
                $message = "Tên nhà cung cấp đã tồn tại. Vui lòng chọn tên khác.";
            } else {
                // Call model to add supplier
                $result = $this->lst_supplier->supplier_ins($name, $contact_name, $phone, $email, $address);
    
                if ($result) {
                    $message = "Thêm nhà cung cấp thành công.";
                } else {
                    $message = "Thêm nhà cung cấp thất bại. Vui lòng thử lại.";
                }
            }
        }
    
        $this->view('Masterlayout', [
            'page' => 'supplier_v',
            'message' => $message
        ]);
    }
    
    

    public function update_data() {
        $message = '';

        if (isset($_POST['btnUpdate'])) {
            $name = $_POST['txtname'];
            $contact_name = $_POST['txtcontact_name'];
            $phone = $_POST['txtphone'];
            $email = $_POST['txtemail'];
            $address = $_POST['txtaddress'];

            // Validate input here if needed

            // Call model to update supplier
                $result = $this->lst_supplier->supplier_upd($name, $contact_name, $phone, $email, $address);
    
                if ($result) {
                    $message = "Cập nhật nhà cung cấp thành công.";
                } else {
                    $message = "Cập nhật nhà cung cấp thất bại. Vui lòng thử lại.";
                }
            
        }

        // Get supplier data for update form
        $supplier = $this->lst_supplier->get_supplier_by_id($name);

        $this->view('Masterlayout', [
            'page' => 'supplier_upd_v',
             'name' => $name,
            'contact_name' => $contact_name,
            'contact_phone' => $phone,
            'contact_email' => $email,
            'address' => $address,
            'message' => $message
        ]);
    }

    public function update($supplier_id){
        $supplier = $this->lst_supplier->get_supplier_by_id($supplier_id);
        $this->view('Masterlayout', [
            'page' => 'supplier_upd_v',
            'name' => $supplier['name'],
            'contact_name' => $supplier['contact_name'],
            'contact_phone' => $supplier['contact_phone'],
            'contact_email' => $supplier['contact_email'],
            'address' => $supplier['address'],
        ]);
    }
    

    public function search() {
        if (isset($_POST['btnFind'])) {
            $criteria = isset($_POST['kieuTimNCC']) ? $_POST['kieuTimNCC'] : 'name';
            $keyword = isset($_POST['txtFind']) ? $_POST['txtFind'] : '';
            
            $data = $this->lst_supplier->supplier_find($criteria, $keyword);
    
            $this->view('Masterlayout', [
                'data' => $data,
                'page' => 'list_supplier_v'
            ]);
        } else {
            // Xử lý khi không có nút tìm kiếm được nhấn (nếu cần)
            // Ví dụ: Hiển thị danh sách ban đầu khi chưa tìm kiếm
            $data = $this->lst_supplier->supplier_find('name', ''); // Thay 'name' bằng tiêu chí mặc định của bạn
            $this->view('Masterlayout', [
                'data' => $data,
                'page' => 'list_supplier_v'
            ]);
        }
    }
    

    public function delete($supplier_id) {
        $message = '';

        // Call model to delete supplier
        $result = $this->lst_supplier->supplier_del($supplier_id);
        $data = $this->lst_supplier->supplier_find('name', ''); 
        if ($result) {
            $message = "Xóa nhà cung cấp thành công.";
        } else {
            $message = "Xóa nhà cung cấp thất bại. Vui lòng thử lại.";
        }

        // Get updated supplier list
        

        $this->view('Masterlayout', [
            'page' => 'list_supplier_v',
            'data' => $data,
            'message' => $message
        ]);
    }
}
?>