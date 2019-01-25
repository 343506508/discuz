<?php
defined('IN_DISCUZ');
require_once './source/class/class_core.php';//必须的，你懂的
$discuz = & discuz_core::instance();//必须的，你懂的
$discuz->cachelist = $cachelist;//必须的，你懂的
$discuz->init();//必须的，你懂的

/*$query = DB::query("SELECT * FROM ".DB::table('common_member')." order by uid" );
while($row = DB::fetch($query)) {
    echo  $row["uid"]."  " .$row["username"]."  ".$row["email"]."<br/>";
}*/

class discuzCustomer
{
    // 判断存不存在
    public function isExist($uid,$username) {
        $query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE username='$username'");
        if(DB::fetch($query) == null){
            echo 0;
            $this->insertDiscuz($uid,$username);
            return 0;
        } else {
            echo 1;
            $this->deleteDiscuz();
            return 1;
        }
        /*echo DB::fetch($query);
        while($row = DB::fetch($query)) {
            #echo  $row["uid"]."  " .$row["username"]."  ".$row["email"]."<br/>";
            echo $row["username"];
            echo $row["username"] != null;

        }*/
    }

    // 不存在直接添加
    public function insertDiscuz($uid,$username) {
        $data = [
            'uid' => $uid,
            'username' => $username
        ];
        $res = DB::insert('common_member',$data,true);
        DB::insert('ucenter_members',$data,true);
        return $res;
    }

    // 存在清空表在添加
    public function deleteDiscuz() {
        $validates = DB::delete('common_member','uid!=0');
        DB::delete('ucenter_members','uid!=0');
        return $validates;
    }

}

$customer = new discuzCustomer();
$customer->isExist($_GET['uid'],$_GET['username']);

/*echo "==>"+$customer;
echo $_GET['uid'];
echo $_GET['username'];*/
?>