<?php
class list_account extends controller {
    private $lst_account;

    public function __construct() {
        $this->lst_account = $this->model('account_m');
    }

    public function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'list_account_v',
            'dulieu'=> $this->lst_account->account_find('','','')
        ]);
    }

    public function find() {
        if (isset($_POST['txtSearch'])) {
            $query = $_POST['txtSearch'];
            $searchType = $_POST['kieuTimKhachHang'];
            $name = '';
            $email = '';
            $username = '';
    
            switch ($searchType) {
                case 'ten':
                    $name = $query;
                    break;
                case 'email':
                    $email = $query;
                    break;
                case 'taikhoan':
                    $username = $query;
                    break;
            }
    
            $result = $this->lst_account->account_find($username,$email, $name );
            
            $this->view('Masterlayout', [
                'dulieu' => $result,
                'page' => 'list_account_v'
            ]);
        }
    }
    public function toggleStatus($username) {
        try {
            $new_status = $this->lst_account->toggle_active_status($username);
            $message = "Cập nhật trạng thái thành công.";
        } catch (Exception $e) {
            $message = "Cập nhật trạng thái thất bại: " . $e->getMessage();
        }

        
        $dulieu = $this->lst_account->account_find('', '', '');
        $this->view('Masterlayout', [
            'dulieu' => $dulieu,
            'page' => 'list_account_v',
            'message' => $message
        ]);
    }
    
    public function delete($username){
        try {
            $this->lst_account->account_del($username);
            $message = "Xóa tài khoản thành công.";
        } catch (Exception $e) {
            $message = "Xóa tài khoản thất bại: " . $e->getMessage();
        }

       
        $dulieu = $this->lst_account->account_find('', '', '');
        $this->view('Masterlayout', [
            'dulieu' => $dulieu,
            'page' => 'list_account_v',
            'message' => $message
        ]);
    }
}
?>