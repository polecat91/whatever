
(function(){

    'use strict'
    
    var LOGIN = {
        
        getDocument: function() {
			return $(document);
		},
        getLoginForm: function() {
            return this.getDocument().find('.form-login');
        },
        getLoginEmail: function() {
            return this.getLoginForm().find('.login-email');
        },
        getLoginPassword: function() {
            return this.getLoginForm().find('.login-password');
        },
        getLoginBtn: function() {
            return this.getLoginForm().find('.login-button');
        },
        getNotify: function() {
            return this.getDocument().find('.notify');
        },
        
        signIn: function() {
            var self = this,
                strEmail = $.trim(self.getLoginEmail().val()),
                strPassword = $.trim(self.getLoginPassword().val());

            if(self.isValidEmail(strEmail) && strPassword) {
                var strDo = JSON.stringify({
                    "email":strEmail,
                    "password":strPassword
                });
                AJAX_Login(strDo, function(strResponse) {
                    var isLogin = JSON.parse(strResponse);
                    if(isLogin) {
                        location.reload();
                    } else {
                        SCOPE.addNotify('Error', 'Invalid email or password.<br />Try again.', true);
                    }
                });
            } else {
                var strError = '';
                if(!self.isValidEmail(strEmail)) {
                    strError = 'Invalid email address';
                }
                SCOPE.addNotify('Error', strError, true);
            }
        
        },
        isValidEmail: function(strEmail) {
            if(strEmail) {
                var strRegExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return strRegExp.test(strEmail);
            } else {
                return false;
            }
        },
    };
    
    LOGIN.getLoginForm().submit(function(){
        LOGIN.signIn();
        return false;
    });
    
})();