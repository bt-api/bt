<?php
namespace Bt;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
/**
 * Class Server
 * @package Bt
 * 宝塔面板站点操作类库（该版本是在原有官方类库进行修正升级，并对composer的支持）
 * @author 阿良 or Youngxj(二次开发) or bt-api
 * @link https://www.bt.cn/api-doc.pdf
 * @link https://github.com/bt-api/bt
 * @version 1.0
 * @example
 * $bt = new Bt('http://127.0.0.1/8888','xxxxxxxxxxxxxxxx');
 * echo $bt->GetSystemTotal();//获取系统基础统计
 */
class Server extends Uri{
    private string $BT_KEY = "";  	//接口密钥
    private string $BT_PANEL = "";	//面板地址
    private Client $client;         //访问端
    /**
     * 初始化
     * Server constructor.
     * @param string|null $bt_panel
     * @param string|null $bt_key
     * @param int $timeout
     */
    public function __construct(string $bt_panel = null,string $bt_key = null,int $timeout=60){
        if($bt_panel)$this->BT_PANEL = $bt_panel;
        if($bt_key)$this->BT_KEY = $bt_key;
        $this->client = new Client(['base_uri' => $this->BT_PANEL,'timeout'  => $timeout,'cookies' => true]);
    }

    /**
     * 获取系统基础统计
     * @return array|bool
     */
    public function GetSystemTotal(){
        $p_data = $this->GetKeyData();
        return $this->HttpPostCookie($this->btUri("GetSystemTotal"),$p_data);
    }

    /**
     * 获取磁盘分区信息
     */
    public function GetDiskInfo(){
        $p_data = $this->GetKeyData();
        return $this->HttpPostCookie($this->btUri("GetDiskInfo"),$p_data);
    }

    /**
     * 获取实时状态信息(CPU、内存、网络、负载)
     * @return array|bool
     */
    public function GetNetWork(){
        $p_data = $this->GetKeyData();
        return $this->HttpPostCookie($this->btUri("GetNetWork"),$p_data);
    }

    /**
     * 检查是否有安装任务
     */
    public function GetTaskCount(){
        $url = $this->BT_PANEL.$this->btUri("GetTaskCount");
        $p_data = $this->GetKeyData();
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 检查面板更新
     */
    public function UpdatePanel($check=false,$force=false){
        $url = $this->BT_PANEL.$this->btUri("UpdatePanel");
        $p_data = $this->GetKeyData();
        $p_data['check'] = $check;
        $p_data['force'] = $force;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }



    /**
     * 获取网站列表
     * @param string $page   当前分页
     * @param string $limit  取出的数据行数
     * @param string $type   分类标识 -1: 分部分类 0: 默认分类
     * @param string $order  排序规则 使用 id 降序：id desc 使用名称升序：name desc
     * @param string $tojs   分页 JS 回调,若不传则构造 URI 分页连接
     * @param string $search 搜索内容
     */
    public function Websites($search='',$page='1',$limit='15',$type='-1',$order='id desc',$tojs=''){
        $url = $this->BT_PANEL.$this->btUri("Websites");
        $p_data = $this->GetKeyData();
        $p_data['p'] = $page;
        $p_data['limit'] = $limit;
        $p_data['type'] = $type;
        $p_data['order'] = $order;
        $p_data['tojs'] = $tojs;
        $p_data['search'] = $search;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站FTP列表
     * @param string $page   当前分页
     * @param string $limit  取出的数据行数
     * @param string $type   分类标识 -1: 分部分类 0: 默认分类
     * @param string $order  排序规则 使用 id 降序：id desc 使用名称升序：name desc
     * @param string $tojs   分页 JS 回调,若不传则构造 URI 分页连接
     * @param string $search 搜索内容
     */
    public function WebFtpList($search='',$page='1',$limit='15',$type='-1',$order='id desc',$tojs=''){
        $url = $this->BT_PANEL.$this->btUri("WebFtpList");
        $p_data = $this->GetKeyData();
        $p_data['p'] = $page;
        $p_data['limit'] = $limit;
        $p_data['type'] = $type;
        $p_data['order'] = $order;
        $p_data['tojs'] = $tojs;
        $p_data['search'] = $search;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站SQL列表
     * @param string $page   当前分页
     * @param string $limit  取出的数据行数
     * @param string $type   分类标识 -1: 分部分类 0: 默认分类
     * @param string $order  排序规则 使用 id 降序：id desc 使用名称升序：name desc
     * @param string $tojs   分页 JS 回调,若不传则构造 URI 分页连接
     * @param string $search 搜索内容
     */
    public function WebSqlList($search='',$page='1',$limit='15',$type='-1',$order='id desc',$tojs=''){
        $url = $this->BT_PANEL.$this->btUri("WebSqlList");
        $p_data = $this->GetKeyData();
        $p_data['p'] = $page;
        $p_data['limit'] = $limit;
        $p_data['type'] = $type;
        $p_data['order'] = $order;
        $p_data['tojs'] = $tojs;
        $p_data['search'] = $search;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取所有网站分类
     */
    public function Webtypes(){
        $url = $this->BT_PANEL.$this->btUri("Webtypes");
        $p_data = $this->GetKeyData();
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取已安装的 PHP 版本列表
     */
    public function GetPHPVersion(){
        //拼接URL地址
        $url = $this->BT_PANEL.$this->btUri("GetPHPVersion");
        //准备POST数据
        $p_data = $this->GetKeyData();		//取签名
        //请求面板接口
        $result = $this->HttpPostCookie($url,$p_data);
        //解析JSON数据
        return json_decode($result,true);
    }

    /**
     * 修改指定网站的PHP版本
     * @param [type] $site 网站名
     * @param [type] $php  PHP版本
     */
    public function SetPHPVersion($site,$php){
        $url = $this->BT_PANEL.$this->btUri("SetPHPVersion");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $p_data['version'] = $php;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取指定网站运行的PHP版本
     * @param [type] $site 网站名
     */
    public function GetSitePHPVersion($site){
        $url = $this->BT_PANEL.$this->btUri("GetSitePHPVersion");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }


    /**
     * 新增网站
     * @param [type] $webname      网站域名 json格式
     * @param [type] $path         网站路径
     * @param [type] $type_id      网站分类ID
     * @param string $type         网站类型
     * @param [type] $version      PHP版本
     * @param [type] $port         网站端口
     * @param [type] $ps           网站备注
     * @param [type] $ftp          网站是否开通FTP
     * @param [type] $ftp_username FTP用户名
     * @param [type] $ftp_password FTP密码
     * @param [type] $sql          网站是否开通数据库
     * @param [type] $codeing      数据库编码类型 utf8|utf8mb4|gbk|big5
     * @param [type] $datauser     数据库账号
     * @param [type] $datapassword 数据库密码
     */
    public function AddSite($infoArr=[]){
        $url = $this->BT_PANEL.$this->btUri("WebAddSite");
        //准备POST数据
        $p_data = $this->GetKeyData();		//取签名
        $p_data['webname'] = $infoArr['webname'];
        $p_data['path'] = $infoArr['path'];
        $p_data['type_id'] = $infoArr['type_id'];
        $p_data['type'] = $infoArr['type'];
        $p_data['version'] = $infoArr['version'];
        $p_data['port'] = $infoArr['port'];
        $p_data['ps'] = $infoArr['ps'];
        $p_data['ftp'] = $infoArr['ftp'];
        $p_data['ftp_username'] = $infoArr['ftp_username'];
        $p_data['ftp_password'] = $infoArr['ftp_password'];
        $p_data['sql'] = $infoArr['sql'];
        $p_data['codeing'] = $infoArr['codeing'];
        $p_data['datauser'] = $infoArr['datauser'];
        $p_data['datapassword'] = $infoArr['datapassword'];
        //请求面板接口
        $result = $this->HttpPostCookie($url,$p_data);
        //解析JSON数据
        return json_decode($result,true);
    }

    /**
     * 删除网站
     * @param [type] $id       网站ID
     * @param [type] $webname  网站名称
     * @param [type] $ftp      是否删除关联FTP
     * @param [type] $database 是否删除关联数据库
     * @param [type] $path     是否删除关联网站根目录
     *
     */
    public function WebDeleteSite($id,$webname,$ftp,$database,$path){
        $url = $this->BT_PANEL.$this->btUri("WebDeleteSite");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['webname'] = $webname;
        $p_data['ftp'] = $ftp;
        $p_data['database'] = $database;
        $p_data['path'] = $path;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 停用站点
     * @param [type] $id   网站ID
     * @param [type] $name 网站域名
     */
    public function WebSiteStop($id,$name){
        $url = $this->BT_PANEL.$this->btUri("WebSiteStop");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['name'] = $name;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 启用网站
     * @param [type] $id   网站ID
     * @param [type] $name 网站域名
     */
    public function WebSiteStart($id,$name){
        $url = $this->BT_PANEL.$this->btUri("WebSiteStart");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['name'] = $name;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 设置网站到期时间
     * @param [type] $id    网站ID
     * @param [type] $edate 网站到期时间 格式：2019-01-01，永久：0000-00-00
     */
    public function WebSetEdate($id,$edate){
        $url = $this->BT_PANEL.$this->btUri("WebSetEdate");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['edate'] = $edate;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 修改网站备注
     * @param [type] $id 网站ID
     * @param [type] $ps 网站备注
     */
    public function WebSetPs($id,$ps){
        $url = $this->BT_PANEL.$this->btUri("WebSetPs");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['ps'] = $ps;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站备份列表
     * @param [type] $id    网站ID
     * @param string $page  当前分页
     * @param string $limit 每页取出的数据行数
     * @param string $type  备份类型 目前固定为0
     * @param string $tojs  分页js回调若不传则构造 URI 分页连接 get_site_backup
     */
    public function WebBackupList($id,$page='1',$limit='5',$type='0',$tojs=''){
        $url = $this->BT_PANEL.$this->btUri("WebBackupList");
        $p_data = $this->GetKeyData();
        $p_data['p'] = $page;
        $p_data['limit'] = $limit;
        $p_data['type'] = $type;
        $p_data['tojs'] = $tojs;
        $p_data['search'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 创建网站备份
     * @param [type] $id 网站ID
     */
    public function WebToBackup($id){
        $url = $this->BT_PANEL.$this->btUri("WebToBackup");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 删除网站备份
     * @param [type] $id 网站备份ID
     */
    public function WebDelBackup($id){
        $url = $this->BT_PANEL.$this->btUri("WebDelBackup");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 删除数据库备份
     * @param [type] $id 数据库备份ID
     */
    public function SQLDelBackup($id){
        $url = $this->BT_PANEL.$this->btUri("SQLDelBackup");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 备份数据库
     * @param [type] $id 数据库列表ID
     */
    public function SQLToBackup($id){
        $url = $this->BT_PANEL.$this->btUri("SQLToBackup");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站域名列表
     * @param [type]  $id   网站ID
     * @param boolean $list 固定传true
     */
    public function WebDoaminList($id,$list=true){
        $url = $this->BT_PANEL.$this->btUri("WebDoaminList");
        $p_data = $this->GetKeyData();
        $p_data['search'] = $id;
        $p_data['list'] = $list;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 添加域名
     * @param [type] $id      网站ID
     * @param [type] $webname 网站名称
     * @param [type] $domain  要添加的域名:端口 80 端品不必构造端口,多个域名用换行符隔开
     */
    public function WebAddDomain($id,$webname,$domain){
        $url = $this->BT_PANEL.$this->btUri("WebAddDomain");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['webname'] = $webname;
        $p_data['domain'] = $domain;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 删除网站域名
     * @param [type] $id      网站ID
     * @param [type] $webname 网站名
     * @param [type] $domain  网站域名
     * @param [type] $port    网站域名端口
     */
    public function WebDelDomain($id,$webname,$domain,$port){
        $url = $this->BT_PANEL.$this->btUri("WebDelDomain");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['webname'] = $webname;
        $p_data['domain'] = $domain;
        $p_data['port'] = $port;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取可选的预定义伪静态列表
     * @param [type] $siteName 网站名
     */
    public function GetRewriteList($siteName){
        $url = $this->BT_PANEL.$this->btUri("GetRewriteList");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $siteName;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取预置伪静态规则内容（文件内容）
     * @param [type] $path 规则名
     * @param [type] $type 0->获取内置伪静态规则；1->获取当前站点伪静态规则
     */
    public function GetFileBody($path,$type=0){
        $url = $this->BT_PANEL.$this->btUri("GetFileBody");
        $p_data = $this->GetKeyData();
        $path_dir = $type?'vhost/rewrite':'rewrite/nginx';
        //获取当前站点伪静态规则
        ///www/server/panel/vhost/rewrite/user_hvVBT_1.test.com.conf
        //获取内置伪静态规则
        ///www/server/panel/rewrite/nginx/EmpireCMS.conf
        //保存伪静态规则到站点
        ///www/server/panel/vhost/rewrite/user_hvVBT_1.test.com.conf
        ///www/server/panel/rewrite/nginx/typecho.conf
        $p_data['path'] = '/www/server/panel/'.$path_dir.'/'.$path.'.conf';
        //var_dump($p_data['path']);
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 保存伪静态规则内容(保存文件内容)
     * @param [type] $path     规则名
     * @param [type] $data     规则内容
     * @param string $encoding 规则编码强转utf-8
     * @param number $type     0->系统默认路径；1->自定义全路径
     */
    public function SaveFileBody($path,$data,$encoding='utf-8',$type=0){
        $url = $this->BT_PANEL.$this->btUri("SaveFileBody");
        if($type){
            $path_dir = $path;
        }else{
            $path_dir = '/www/server/panel/vhost/rewrite/'.$path.'.conf';
        }
        $p_data = $this->GetKeyData();
        $p_data['path'] = $path_dir;
        $p_data['data'] = $data;
        $p_data['encoding'] = $encoding;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }



    /**
     * 设置密码访问网站
     * @param [type] $id       网站ID
     * @param [type] $username 用户名
     * @param [type] $password 密码
     */
    public function SetHasPwd($id,$username,$password){
        $url = $this->BT_PANEL.$this->btUri("SetHasPwd");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['username'] = $username;
        $p_data['password'] = $password;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 关闭密码访问网站
     * @param [type] $id 网站ID
     */
    public function CloseHasPwd($id){
        $url = $this->BT_PANEL.$this->btUri("CloseHasPwd");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站日志
     * @param [type] $site 网站名
     */
    public function GetSiteLogs($site){
        $url = $this->BT_PANEL.$this->btUri("GetSiteLogs");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站盗链状态及规则信息
     * @param [type] $id   网站ID
     * @param [type] $site 网站名
     */
    public function GetSecurity($id,$site){
        $url = $this->BT_PANEL.$this->btUri("GetSecurity");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['name'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 设置网站盗链状态及规则信息
     * @param [type] $id      网站ID
     * @param [type] $site    网站名
     * @param [type] $fix     URL后缀
     * @param [type] $domains 许可域名
     * @param [type] $status  状态
     */
    public function SetSecurity($id,$site,$fix,$domains,$status){
        $url = $this->BT_PANEL.$this->btUri("SetSecurity");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['name'] = $site;
        $p_data['fix'] = $fix;
        $p_data['domains'] = $domains;
        $p_data['status'] = $status;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站三项配置开关（防跨站、日志、密码访问）
     * @param [type] $id   网站ID
     * @param [type] $path 网站运行目录
     */
    public function GetDirUserINI($id,$path){
        $url = $this->BT_PANEL.$this->btUri("GetDirUserINI");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['path'] = $path;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 开启强制HTTPS
     * @param [type] $site 网站域名（纯域名）
     */
    public function HttpToHttps($site){
        $url = $this->BT_PANEL.$this->btUri("HttpToHttps");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 关闭强制HTTPS
     * @param [type] $site 域名(纯域名)
     */
    public function CloseToHttps($site){
        $url = $this->BT_PANEL.$this->btUri("CloseToHttps");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 设置SSL域名证书
     * @param [type] $type 类型
     * @param [type] $site 网站名
     * @param [type] $key  证书key
     * @param [type] $csr  证书PEM
     */
    public function SetSSL($type,$site,$key,$csr){
        $url = $this->BT_PANEL.$this->btUri("SetSSL");
        $p_data = $this->GetKeyData();
        $p_data['type'] = $type;
        $p_data['siteName'] = $site;
        $p_data['key'] = $key;
        $p_data['csr'] = $csr;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);

    }

    /**
     * 关闭SSL
     * @param [type] $updateOf 修改状态码
     * @param [type] $site     域名(纯域名)
     */
    public function CloseSSLConf($updateOf,$site){
        $url = $this->BT_PANEL.$this->btUri("CloseSSLConf");
        $p_data = $this->GetKeyData();
        $p_data['updateOf'] = $updateOf;
        $p_data['siteName'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取SSL状态及证书信息
     * @param [type] $site 域名（纯域名）
     */
    public function GetSSL($site){
        $url = $this->BT_PANEL.$this->btUri("GetSSL");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站默认文件
     * @param [type] $id 网站ID
     */
    public function WebGetIndex($id){
        $url = $this->BT_PANEL.$this->btUri("WebGetIndex");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 设置网站默认文件
     * @param [type] $id    网站ID
     * @param [type] $index 内容
     */
    public function WebSetIndex($id,$index){
        $url = $this->BT_PANEL.$this->btUri("WebSetIndex");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['Index'] = $index;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站流量限制信息
     * @param [type] $id [description]
     */
    public function GetLimitNet($id){
        $url = $this->BT_PANEL.$this->btUri("GetLimitNet");

        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 设置网站流量限制信息
     * @param [type] $id         网站ID
     * @param [type] $perserver  并发限制
     * @param [type] $perip      单IP限制
     * @param [type] $limit_rate 流量限制
     */
    public function SetLimitNet($id,$perserver,$perip,$limit_rate){
        $url = $this->BT_PANEL.$this->btUri("SetLimitNet");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['perserver'] = $perserver;
        $p_data['perip'] = $perip;
        $p_data['limit_rate'] = $limit_rate;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 关闭网站流量限制
     * @param [type] $id 网站ID
     */
    public function CloseLimitNet($id){
        $url = $this->BT_PANEL.$this->btUri("CloseLimitNet");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站301重定向信息
     * @param [type] $site 网站名
     */
    public function Get301Status($site){
        $url = $this->BT_PANEL.$this->btUri("Get301Status");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 设置网站301重定向信息
     * @param [type] $site      网站名
     * @param [type] $toDomain  目标Url
     * @param [type] $srcDomain 来自Url
     * @param [type] $type      类型
     */
    public function Set301Status($site,$toDomain,$srcDomain,$type){
        $url = $this->BT_PANEL.$this->btUri("Set301Status");
        $p_data = $this->GetKeyData();
        $p_data['siteName'] = $site;
        $p_data['toDomain'] = $toDomain;
        $p_data['srcDomain'] = $srcDomain;
        $p_data['type'] = $type;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站反代信息及状态
     * @param [type] $site [description]
     */
    public function GetProxyList($site){
        $url = $this->BT_PANEL.$this->btUri("GetProxyList");
        $p_data = $this->GetKeyData();
        $p_data['sitename'] = $site;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 添加网站反代信息
     * @param [type] $cache     是否缓存
     * @param [type] $proxyname 代理名称
     * @param [type] $cachetime 缓存时长 /小时
     * @param [type] $proxydir  代理目录
     * @param [type] $proxysite 反代URL
     * @param [type] $todomain  目标域名
     * @param [type] $advanced  高级功能：开启代理目录
     * @param [type] $sitename  网站名
     * @param [type] $subfilter 文本替换json格式[{"sub1":"百度","sub2":"白底"},{"sub1":"","sub2":""}]
     * @param [type] $type      开启或关闭 0关;1开
     */
    public function CreateProxy($cache,$proxyname,$cachetime,$proxydir,$proxysite,$todomain,$advanced,$sitename,$subfilter,$type){
        $url = $this->BT_PANEL.$this->btUri("CreateProxy");
        $p_data = $this->GetKeyData();
        $p_data['cache'] = $cache;
        $p_data['proxyname'] = $proxyname;
        $p_data['cachetime'] = $cachetime;
        $p_data['proxydir'] = $proxydir;
        $p_data['proxysite'] = $proxysite;
        $p_data['todomain'] = $todomain;
        $p_data['advanced'] = $advanced;
        $p_data['sitename'] = $sitename;
        $p_data['subfilter'] = $subfilter;
        $p_data['type'] = $type;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 添加网站反代信息
     * @param [type] $cache     是否缓存
     * @param [type] $proxyname 代理名称
     * @param [type] $cachetime 缓存时长 /小时
     * @param [type] $proxydir  代理目录
     * @param [type] $proxysite 反代URL
     * @param [type] $todomain  目标域名
     * @param [type] $advanced  高级功能：开启代理目录
     * @param [type] $sitename  网站名
     * @param [type] $subfilter 文本替换json格式[{"sub1":"百度","sub2":"白底"},{"sub1":"","sub2":""}]
     * @param [type] $type      开启或关闭 0关;1开
     */
    public function ModifyProxy($cache,$proxyname,$cachetime,$proxydir,$proxysite,$todomain,$advanced,$sitename,$subfilter,$type){
        $url = $this->BT_PANEL.$this->btUri("ModifyProxy");
        $p_data = $this->GetKeyData();
        $p_data['cache'] = $cache;
        $p_data['proxyname'] = $proxyname;
        $p_data['cachetime'] = $cachetime;
        $p_data['proxydir'] = $proxydir;
        $p_data['proxysite'] = $proxysite;
        $p_data['todomain'] = $todomain;
        $p_data['advanced'] = $advanced;
        $p_data['sitename'] = $sitename;
        $p_data['subfilter'] = $subfilter;
        $p_data['type'] = $type;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站域名绑定二级目录信息
     * @param [type] $id 网站ID
     */
    public function GetDirBinding($id){
        $url = $this->BT_PANEL.$this->btUri("GetDirBinding");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 设置网站域名绑定二级目录
     * @param [type] $id      网站ID
     * @param [type] $domain  域名
     * @param [type] $dirName 目录
     */
    public function AddDirBinding($id,$domain,$dirName){
        $url = $this->BT_PANEL.$this->btUri("AddDirBinding");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['domain'] = $domain;
        $p_data['dirName'] = $dirName;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 删除网站域名绑定二级目录
     * @param [type] $dirid 子目录ID
     */
    public function DelDirBinding($dirid){
        $url = $this->BT_PANEL.$this->btUri("DelDirBinding");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $dirid;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 获取网站子目录绑定伪静态信息
     * @param [type] $dirid 子目录绑定ID
     */
    public function GetDirRewrite($dirid,$type=0){
        $url = $this->BT_PANEL.$this->btUri("GetDirRewrite");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $dirid;
        if($type){
            $p_data['add'] = 1;
        }
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 修改FTP账号密码
     * @param [type] $id           FTPID
     * @param [type] $ftp_username 用户名
     * @param [type] $new_password 密码
     */
    public function SetUserPassword($id,$ftp_username,$new_password){
        $url = $this->BT_PANEL.$this->btUri("SetUserPassword");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['ftp_username'] = $ftp_username;
        $p_data['new_password'] = $new_password;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 修改SQL账号密码
     * @param [type] $id           SQLID
     * @param [type] $ftp_username 用户名
     * @param [type] $new_password 密码
     */
    public function ResDatabasePass($id,$name,$password){
        $url = $this->BT_PANEL.$this->btUri("ResDatabasePass");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['name'] = $name;
        $p_data['password'] = $password;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 启用/禁用FTP
     * @param [type] $id       FTPID
     * @param [type] $username 用户名
     * @param [type] $status   状态 0->关闭;1->开启
     */
    public function SetStatus($id,$username,$status){
        $url = $this->BT_PANEL.$this->btUri("SetStatus");
        $p_data = $this->GetKeyData();
        $p_data['id'] = $id;
        $p_data['username'] = $username;
        $p_data['status'] = $status;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 宝塔一键部署列表
     * @param  string $search 搜索关键词
     * @return [type]         [description]
     */
    public function deployment($search=''){
        if($search){
            $url = $this->BT_PANEL.$this->btUri("deployment").'&search='.$search;
        }else{
            $url = $this->BT_PANEL.$this->btUri("deployment");
        }
        $p_data = $this->GetKeyData();
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 宝塔一键部署执行
     * @param [type] $dname       部署程序名
     * @param [type] $site_name   部署到网站名
     * @param [type] $php_version PHP版本
     */
    public function SetupPackage($dname,$site_name,$php_version){
        $url = $this->BT_PANEL.$this->btUri("SetupPackage");
        $p_data = $this->GetKeyData();
        $p_data['dname'] = $dname;
        $p_data['site_name'] = $site_name;
        $p_data['php_version'] = $php_version;
        $result = $this->HttpPostCookie($url,$p_data);
        return json_decode($result,true);
    }

    /**
     * 构造带有签名的关联数组
     * @return array
     */
    public function GetKeyData(): array{
        $now_time = time();
        return array(
            'request_token'	=>	md5($now_time.''.md5($this->BT_KEY)),
            'request_time'	=>	$now_time
        );
    }

    /**
     * 发起POST请求
     * @param $url
     * @param $p_data
     * @param int $timeout
     * @return array|bool
     */
    private function HttpPostCookie($url, $p_data)
    {
        try {
            $response=$this->client->request('POST', $url,['form_params' => $p_data]);
            if($response->getStatusCode()==200){
                $data=json_decode($response->getBody()->getContents(),true);
                return !empty($data)?(isset($data["status"])?:array("status"=>true,"msg"=>"获取成功！","data"=>$data)):array("status"=>false,"msg"=>"响应数据错误");
            }else{
                return array("status"=>false,"msg"=>"响应代码:".$response->getStatusCode());
            }
        }catch(GuzzleException $e){
            return array("status"=>false,"msg"=>$e->getMessage());
        }
    }
}