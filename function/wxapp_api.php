<?php
/**
 * 监听请求是否符合API规则
 */
function os_wxapp_one_WatchApi($url) {
    global $zbp, $os_wxapp_one;
    $status = strripos($url, '/os_wxapi');
    if ($status !== 0) {
        return false;
    }

    // 匹配路由
    $regexp = "/\/os_wxapi\/([a-z0-9\-\_]*)\/([a-z0-9\-\_]*)\/?([a-z0-9\-\_]*)/";
    $routes = array();
    preg_match_all($regexp, $url, $routes);

    $version = null;
    if (isset($routes[1]) && count($routes[1]) > 0) {
        $version = $routes[1][0];
    }
    $type = null;
    if (isset($routes[2]) && count($routes[2]) > 0) {
        $type = $routes[2][0];
    }
    $param = null;
    if (isset($routes[3]) && count($routes[3]) > 0) {
        $param = $routes[3][0];
    }

    $json = array();

    switch ($version) {
        case 'v1':
            os_wxapp_one_api_v1($type, $param, $json);
        break;
        default:
            $json['code'] = -1;
            $json['message'] = "未找到定义接口";
        break;
    }

    echo json_encode($json);
    exit;
}

/**
 * v1版本接口处理
 */
function os_wxapp_one_api_v1($type, $param, &$json = []) {
    global $zbp;
    switch ($type) {
        case 'home':
            os_wxapp_one_APIHome($json);
        break;
        case 'list':
            os_wxapp_one_APIList($json);
        break;
        default:
            $json['code'] = -2;
            $json['message'] = "未找到定义接口";
        break;
    }
}

/**
 * 首页数据输出
 */
function os_wxapp_one_APIHome(&$json = []) {
    global $zbp;

    $page = GetVars("page", "GET");
    $page = (int)$page>0 ? (int)$page : 1;

    $result = os_wxapp_one_JSON_GetArticleList(10, null, $page);

    $json['code'] = 100000;
    $json['result'] = $result;
}

/**
 * 首页数据输出
 */
function os_wxapp_one_APIList(&$json = []) {
    global $zbp;

    $page = GetVars("page", "GET");
    $page = (int)$page>0 ? (int)$page : 1;

    $cateid = GetVars("cateid", "GET");
    
    if (empty($cateid)) {
        $json['code'] = 200100;
        $json['message'] = "分类ID异常";
        return false;
    }

    $result = os_wxapp_one_JSON_GetArticleList(10, $cateid, $page, true);

    $json['code'] = 100000;
    $json['result'] = $result;
}
