//
//(function(){
//
//    'use strict'
//    
//    var ABOUT = {
//        
//        getDocument: function() {
//			return $(document);
//		},
//        getLogOut: function() {
//            return this.getDocument().find('.logout');
//        },
//        
//        signOut: function() {
//            AJAX_SignOut('', function(strResponse) {
//                var signOut = JSON.parse(strResponse);
//                if(signOut) {
//                    location.reload();
//                } else {
//                    self.errorLogin("error logout");
//                }
//            });
//        }
//        
//    };
//    
//    ABOUT.getLogOut().click(function(){
//        ABOUT.signOut();
//    });
//    
//})();