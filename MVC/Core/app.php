<?php 
    class app{
        protected $controller= 'home';
        protected $action='Get_data';
        protected $param=[];
        function __construct()
        {
            $arr=$this->processURL();

            // Xử lý Controller

            if($arr != null){
                if(file_exists('./MVC/Controllers/'.$arr[0].'.php')){
                    $this->controller=$arr[0];
                    unset($arr[0]);
                }
            }
            include_once './MVC/Controllers/'.$this->controller.'.php';
            $this->controller = new $this->controller;
            
            // Xử lý action
            if(isset($arr[1])){
                if(method_exists($this->controller,$arr[1])){
                    $this->action=$arr[1];
                }
                unset($arr[1]);
            }
            // Xử lý param
            $this->param=$arr?array_values($arr):[];
            //Tạo biến có 3 tham số
            call_user_func_array([$this->controller, $this->action], $this->param);
        }
        function processURL(){
            if(isset($_GET['url'])){
            return explode('/',filter_var(trim($_GET['url']),FILTER_DEFAULT));
            }
        }
    }

?>
