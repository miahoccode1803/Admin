<?php
    class Home extends controller{
        function Get_data(){
            $this->view('Masterlayout', [
                'page'=> 'home_v'
            ]);
        }
    }