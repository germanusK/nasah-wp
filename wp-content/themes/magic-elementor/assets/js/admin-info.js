;(function($){
    $(document).ready(function() {
    $('.meis-dismissible').on('click',function(){
        $.post(mgelajinfo.ajax_url,{
            action: 'dismissopenot',
            dismiss:1,
            nonce:mgelajinfo.nonce
        },function(data){
           
        });
    });
    $('.mgrev-hide').on('click',function(){
        $.post(mgelajinfo.ajax_url,{
            action: 'dismissopenot',
            revdismiss:1,
            nonce:mgelajinfo.nonce
        },function(data){
           
        });
    $('.mgele-notice').hide();
    });
        


    });
})(jQuery);