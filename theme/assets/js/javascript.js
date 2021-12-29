/*global common_params:false*/
jQuery(document).ready(function($) {
  'use strict';
    var paged = 2;

    $( '#load-more' ).click(function() {
        var template = $(this).attr('data-template');
        var post_type = $(this).attr('data-post-type');
        var posts_per_page = $(this).attr('data-posts-per-page');
        var data_max_page = $(this).attr('data-max-page');

        if (paged > data_max_page){
            return false;
        }else{
            loadArticle(template, post_type, posts_per_page, paged);
        }
        paged++;
    });

    function loadArticle(template, post_type, posts_per_page, paged) {
        $( '#load-more' ).button('loading');
        $.ajax({
            url: common_params.site_url + '/wp-admin/admin-ajax.php',
            type:'POST',
            data: 'action=infinite_scroll&template='+ template + '&post_type='+ post_type + '&posts_per_page=' + posts_per_page +'&paged='+ paged,
            success: function(html){
                $('#article-list').append(html);
                $( '#load-more' ).button('reset');
            }
        });
        return false;
    }

    // TOOLTIP AND POPOVES
    if ($('[data-toggle=tooltip]').length) {
        $('[data-toggle=tooltip]').tooltip();
    }

    if ($('[data-toggle=popover]').length) {
        $('[data-toggle=popover]').popover({
            trigger: 'hover'
        });
    }

    if ($('.owl-carousel').length) {
        $('.owl-carousel').owlCarousel({
          center: true,
          items:1
        });
    }

    $(window).bind('load', function() {
       $('#logo-manutencao').addClass('animated bounceIn');
       $('#box-manutencao').addClass('animated bounceInUp');
    });
    $('#logo-manutencao')
    .mouseover(function() {
        $('#logo-manutencao').removeClass('bounceIn').addClass('shake');
    })
    .mouseout(function() {
        $('#logo-manutencao').removeClass('shake');
    });

});
