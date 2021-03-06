<?php
define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');
/*
 * 作用：编辑栏目
 * 思路：
 * 接收cat_id
 * 实例化model
 * 调用model取出栏目信息
 * 展示到表单
 */

$cat_id = $_GET['cat_id'] + 0;
$cat = new CatModel();
$catinfo = $cat->find($cat_id);
//print_r($catinfo);


$catlist = $cat->select();
$catlist = $cat->getCatTree($catlist);

if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){
    include(ROOT.'view/admin/templates/catedit.html');
}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,请尝试重新登录,5秒后自动前往用户登录界面。';
}

?>