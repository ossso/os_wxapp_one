<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('os_wxapp_one')) {$zbp->ShowError(48);die();}

$save_param = array(
    "appid",
    "secret",
    "tuis",
    "cates"
);

foreach ($save_param as $v) {
    $zbp->Config('os_wxapp_one')->$v = GetVars($v, "post");
}

$zbp->SaveConfig('os_wxapp_one');
$zbp->SetHint('good', "保存成功");
Redirect("./main.php");
