<?php
/**
 * os_wxapp_one_Event_GetArticleCover - 输出文章的封面图片
 *
 * @param  {object} $article 文章对象
 * @param  {number} $num = 1 输出数量
 */
function os_wxapp_one_Event_GetArticleCover($article, $num = 1) {
    global $zbp;

    // 如果存在预先存储的缩略图，就使用准备好的
    if ($article->Metas->os_wxapp_images && $num > 3) {
        $covers = explode(',', $article->Metas->os_wxapp_images);
        return array_slice($covers, 0, (int)$num);
    } elseif ($article->Metas->os_wxapp_images_count > 0) {
        $covers = explode(',', $article->Metas->os_wxapp_images);
        if ($num == 1) {
            return $covers[0];
        } else {
            return array_slice($covers, 0, (int)$num);
        }
    }

    // 如果文章没有预先读取 开始正则匹配
    $pattern = "/<img.*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/i";
    $content = $article->Content;
    preg_match_all($pattern, $content, $matchContent);

    if(isset($matchContent[1][0])){

        // 匹配成功可以存起来，后面出现重新保存文章时，内容也会被另外一个函数更新
        $article->Metas->os_wxapp_images = implode(",", $matchContent[1]);
        $article->Metas->os_wxapp_images_count = count($matchContent[1]);
        $article->Save();

        if ($num == 1) {
            return $matchContent[1][0];
        }
        return array_slice($matchContent[1], 0, (int)$num);
    } else {
        if ($num == 1) {
            return $zbp->host.'zb_users/plugin/os_wxapp_one/images/noimg.png';
        }
        return array($zbp->host.'zb_users/plugin/os_wxapp_one/images/noimg.png');
    }
}
