<?php
/**
 * @Note: 公共方法文件
 */

/**
 * 发送HTTP请求方法
 * @param string $url 请求URL
 * @param array $params 请求参数
 * @param string $method 请求方法GET/POST
 * @param array $header 请求头
 * @param bool $multi 是否传输文件 默认false
 * @return string  $data   响应数据
 * @throws Exception
 */
function sendHttp(string $url, array $params, $method = 'GET', $header = array(), $multi = false)
{
    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );
    //根据请求类型设置特定参数
    switch (strtoupper($method)) {
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            if ($multi) {
                foreach ($params as $k => $path) {
                    if (is_file($path)) {
                        $post[$k] = new \CURLFile(realpath($path));
                    }
                    break;
                }
            } else {
                $post = http_build_query($params);
            }
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $post;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }

    //初始化并执行curl请求
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data['curl_url'] = $opts[CURLOPT_URL];
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) {
        throw new Exception('请求发生错误：' . $error);
    }
    return $data;
}
