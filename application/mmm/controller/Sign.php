<?php
/**
 * 2019-12-09
 */
namespace app\mmm\controller;
use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;
use think\facade\Session;

class Sign extends Controller {
	
	public function login(){
		if(Session::get('admin')['id']){
			$this->redirect("Index/index");
		}
		
		if($_POST){
			$admin = input('admin/s', '', 'trim');
			$password = input('password/s', '', 'trim');
			
			if(md5(input('verify')) != Session::get('verify')['vcode']){
				$this->error('验证码不对1', '', '', getSet('waitTime'));
			}
			
			if(time() > Session::get('verify')['time'] + 300){
				$this->error('验证码过期2', '', '', getSet('waitTime'));
			}
			
			$findAdmin = Db::name('admin')->where('admin', '=', $admin)->find();
			if(!$findAdmin){
				$this->error('管理员或者密码不对3', '', '', getSet('waitTime'));
			}
	
			$findPassword = Db::name('admin_password')->where('admin_id', '=', $findAdmin['id'])->find();
			if(!$findPassword){
				$this->error('管理员或者密码不对4', '', '', getSet('waitTime'));
			}		
	
			if(!password_verify($findAdmin['admin'].$password.config('encodeKey'), $findPassword['password'])){
				$this->error('管理员或者密码不对5', '', '', getSet('waitTime'));
			}
			Session::set('admin', ['id'=>intval($findAdmin['id']), 'admin'=>$findAdmin['admin']]);
				
			$this->redirect('Index/index');
		}
		return view();
	}
    
	
	/**
	 * 验证码
	 * 军
	 * 2017-09-22
	 */
    public function verify(){
        Header( "Content-type: image/PNG" );
        $im   = imagecreate( 44, 18 );
        $back = ImageColorAllocate( $im, 245, 245, 245 );
        imagefill( $im, 0, 0, $back );
        srand( (double) microtime() * 1000000 );
        $vcodes = '';
        
        for ( $i = 0; $i < 4; $i++ ) {
            $font    = ImageColorAllocate( $im, rand( 100, 255 ), rand( 0, 100 ), rand( 100, 255 ) );
            $authnum = rand( 1, 9 );
            $vcodes .= $authnum;
            imagestring( $im, 5, 2 + $i * 10, 1, $authnum, $font );
        }
        
        for ( $i = 0; $i < 100; $i++ ) {
            $randcolor = ImageColorallocate( $im, rand( 0, 255 ), rand( 0, 255 ), rand( 0, 255 ) );
            imagesetpixel( $im, rand() % 70, rand() % 30, $randcolor );
        }
        ImagePNG( $im );
        ImageDestroy( $im );
        Session::set('verify', ['vcode'=>md5($vcodes), 'time'=>time()]);
    }
	
    /**
     * 登出
     * 2019-03-08
     */
    public function logout(){
    	Session::set('admin', null);
    	$this->redirect("login");
    }
    
    
	/**
	 * 测试创建密码
	 * 2019-07-28
	 */
	public function testCreatePassword(){
		$username = 'admin';
		$passwordNew = 'admin';
		dump($this->encodeKey);
		$passwordHash = password_hash($username.$passwordNew.config('encodeKey'), PASSWORD_DEFAULT);
		dump($passwordHash);
	}
}