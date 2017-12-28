<?php
class RegisterForm extends ActionForm {
	/**
 	 * @access  public
	 * @return object ActionErrors
	 */
	function  &validate(&$mapping, &$IN) 
	{
		$errors = new ActionErrors();

//add by easyT,2007.12.10 (主要是为了几种应用整合时数据库字段长度的统一)

        if(strlen($this->bean['UserName']) < 4) {//用户名长度限制
            $errors->add(ActionErrors_GLOBAL_ERROR, 'register.username.tooshort' );        
        }//有效为4字节
        
        if(strlen($this->bean['UserName']) > 15 ) {//用户名长度限制
            $errors->add(ActionErrors_GLOBAL_ERROR, 'register.username.toolong' );        
        }//有效为15字节


        if(strlen($this->bean['Password']) < 4) {//密码长度限制
            $errors->add(ActionErrors_GLOBAL_ERROR, 'register.password.tooshort' );        
        }//有效为4字节
        
        if(strlen($this->bean['Password']) > 32 ) {//密码长度限制
            $errors->add(ActionErrors_GLOBAL_ERROR, 'register.password.toolong' );        
        }//有效为32字节
//add by easyt end.

		if($this->bean['Password'] != $this->bean['Password2']) {
			$errors->add(ActionErrors_GLOBAL_ERROR, 'register.password.password2notmatch' );		
		}
		
		return $errors;
		
	}
}
?>