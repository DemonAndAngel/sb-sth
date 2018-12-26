<?php
/**
 * Created by PhpStorm.
 * User: imden
 * Date: 2018/3/12
 * Time: 上午11:53
 */
//git webhook 自动部署脚本
$time = time();
// 日志路径
$gitLogPath = "../git-webhook-log/".date('Y-m-d',$time)."/";
// 日志文件名
$fileName = "git.log";
// 创建文件夹
if(!is_dir($gitLogPath)){
    mkdir($gitLogPath, 0755,true);
}
// 请求成功写入
file_put_contents($gitLogPath.$fileName, '---请求成功---'.PHP_EOL, FILE_APPEND);
// 获取git传过来的数据
$requestBody = file_get_contents("php://input");
if (empty($requestBody)) {
    die('参数错误！');
}
$content = json_decode($requestBody, true);
//若是主分支且提交数大于0
if ($content['ref']=='refs/heads/master') {
    // 项目路径
    start_shell("/www/wwwroot/sb-sth/",$content,$time,$gitLogPath.$fileName);
}
file_put_contents($gitLogPath.$fileName, '---请求结束---'.PHP_EOL, FILE_APPEND);
function start_shell($path,$content,$time,$gitLogFullPath){
    // 执行shell脚本
    $res_log = '------------执行日志-------------'.PHP_EOL;
    $res = shell_exec("cd {$path} && git pull 2>&1");//以www用户运行
    $res_log .= $content['user_name'] . ' 在' . date('Y-m-d H:i:s',$time) . '向' . $content['repository']['name'] . '项目的' . $content['ref'] . '分支push了' . $content['total_commits_count'] . '个commit：' . PHP_EOL;
    $res_log .= $res.PHP_EOL;
    file_put_contents($gitLogFullPath, $res_log, FILE_APPEND);//追加写入
}