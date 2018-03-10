<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('os_wxapp_one')) {$zbp->ShowError(48);die();}

$blogtitle = '微信小程序 ONE 配置页面';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';

$swipers = $os_wxapp_one->GetSwiperList(null, null, array("wxapp_swiper_Order" => "DESC"));
?>
<style>
.edit-input {
    display: block;
    width: 100%;
    height: 40px;
    line-height: 24px;
    font-size: 14px;
    padding: 8px;
    box-sizing: border-box;
}
.save-btn,
.del-btn {
    display: inline-block;
    width: 45px;
    height: 26px;
    line-height: 26px;
    padding: 0;
    margin: 0;
    color: #fff;
    border: none;
    background: #3a6ea5;
    cursor: pointer;
    vertical-align: middle;
}
.del-btn {
    text-align: center;
    color: #555 !important;
    background: #eee;
}
</style>
<div id="divMain">
    <div class="divHeader"><?php echo $blogtitle;?></div>
    <div class="SubMenu"><?php os_wxapp_one_SubMenu(1);?></div>
    <div id="divMain2">
        <table border="1" class="tableFull tableBorder tableBorder-thcenter" style="max-width: 1000px">
            <thead>
                <tr>
                    <th width="400px">图片地址</th>
                    <th>关联类型</th>
                    <th>关联内容</th>
                    <th>排序数值</th>
                    <th width="80px">是否启用</th>
                    <th width="120px">操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form action="./save.php?type=swiper&id=0" method="post">
                        <td><input type="text" name="Imgurl" class="edit-input" /></td>
                        <td>
                            <select name="Type">
                                <option value="normal">不关联</option>
                                <option value="article">文章</option>
                                <option value="page">单页</option>
                                <option value="search">搜索</option>
                            </select>
                        </td>
                        <td><input type="text" name="Related" class="edit-input" /></td>
                        <td><input type="number" name="Order" class="edit-input" /></td>
                        <td><input type="text" name="Status" class="checkbox" value="1" /></td>
                        <td>
                            <button class="save-btn">保存</button>
                        </td>
                    </form>
                </tr>
                <?php
                    foreach ($swipers as $item) {
                ?>
                <tr>
                    <form action="./save.php?type=swiper&id=<?php echo $item->ID ?>" method="post">
                        <td><input type="text" name="Imgurl" class="edit-input" value="<?php echo $item->Imgurl ?>" /></td>
                        <td>
                            <select id="swiper-select-<?php echo $item->ID ?>" name="Type" data-value="<?php echo $item->Type ?>">
                                <option value="normal">不关联</option>
                                <option value="article">文章</option>
                                <option value="page">单页</option>
                                <option value="search">搜索</option>
                            </select>
                            <script>
                                !function() {
                                    var select = document.querySelector('#swiper-select-<?php echo $item->ID ?>')
                                    select.value = select.getAttribute('data-value')
                                }();
                            </script>
                        </td>
                        <td><input type="text" name="Related" class="edit-input" value="<?php echo $item->Related ?>" /></td>
                        <td><input type="number" name="Order" class="edit-input" value="<?php echo $item->Order ?>" /></td>
                        <td><input type="text" name="Status" class="checkbox" value="<?php echo $item->Status ?>" /></td>
                        <td>
                            <button class="save-btn">保存</button>
                            <a class="del-btn" href="./save.php?type=swiper_del&id=<?php echo $item->ID ?>">删除</a>
                        </td>
                    </form>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
