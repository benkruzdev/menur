jQuery(document).ready(function($) {
    
    // Toggle Event
    $(document).on('click', '.ben-kruz-mobile-toggle', function() {
        var $wrapper = $(this).closest('.ben-kruz-header');
        var $menu = $wrapper.find('.ben-kruz-mobile-menu');
        
        $menu.toggleClass('active');
        
        // İkonları değiştir
        var $openIcon = $(this).find('.bkm-icon-open');
        var $closeIcon = $(this).find('.bkm-icon-close');

        if ($menu.hasClass('active')) {
            $openIcon.hide();
            $closeIcon.show();
        } else {
            $openIcon.show();
            $closeIcon.hide();
        }
    });

    // Menü dışına tıklanınca kapatma
    $(document).on('click', function(event) { 
        if (!$(event.target).closest('.ben-kruz-header').length) {
            var $menu = $('.ben-kruz-mobile-menu');
            if($menu.hasClass('active')){
                $menu.removeClass('active');
                
                // İkonları sıfırla
                $('.bkm-icon-open').show();
                $('.bkm-icon-close').hide();
            }
        }
    });
});