<?php

include_once __DIR__.'/database/index.php';
include_once __DIR__.'/function/main.php';
include_once __DIR__.'/third_libs/wxapp/wxBizDataCrypt.php';

#注册插件
RegisterPlugin("os_wxapp_one", "ActivePlugin_os_wxapp_one");
/**
 * 注册接收处理指令
 */
$GLOBALS['actions']['os_wxapi'] = 6;
function ActivePlugin_os_wxapp_one() {
    global $zbp;
    Add_Filter_Plugin('Filter_Plugin_ViewAuto_Begin','os_wxapp_one_WatchApi');
    Add_Filter_Plugin('Filter_Plugin_Cmd_Begin','os_wxapp_one_WatchCmdApi');
}

function InstallPlugin_os_wxapp_one() {
    os_wxapp_one_CreateTable();
}

function UninstallPlugin_os_wxapp_one() {}
