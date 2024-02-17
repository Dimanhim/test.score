$(document).ready(function() {
    $('.changeble-default select').on('change', function() {
        if($(this).val() != 0) {
            $('.costs-name').fadeOut();
            $('.costs-category').fadeOut();
        }
        else {
            $('.costs-name').fadeIn();
            $('.costs-category').fadeIn();
        }
    });
    $('#costs-category').on('change', function() {
        var self = $(this);
        var val = self.val();
        var url = "/costs/get-sub-cats";
        $.post(url, {id: val}, function(data) {
            $('#costs-category_child').html(data);
            $('.auto-complete').fadeIn();
            console.log(data);
        });

    });
    $('#costsdefault-category').on('change', function() {
        var self = $(this);
        var val = self.val();
        var url = "/costs/get-sub-cats";
        $.post(url, {id: val}, function(data) {
            $('#costsdefault-category_child').html(data);
            $('.auto-complete').fadeIn();
            console.log(data);
        });

    });
    $('#costs-date').on('change', function() {
       console.log($(this).val());
    });
    $('body').on('change', '#costs-check_for_days', function(e) {
        e.preventDefault();
        if(!$(this).is(':checked')) {
            $('#obligstory_payments').fadeIn();
        }
        else {
            $('#obligstory_payments').fadeOut();
        }
    });
});
