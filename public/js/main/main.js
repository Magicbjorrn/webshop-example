+function ($) {
    $(document).ready(function () {

        /* START EVENT HANDLING */

        $('.btn-buy').on('click', function(e) {
            var href = this.href;

            e.preventDefault();
            $.ajax({
                type: "POST",
                url: href,
                dataType: 'json'
            });
        });

        $('.btn-payment').on('click', function(e) {
            $('.btn-payment').each(function(index, item) {
                $(item).removeClass('active');
            })

            $(e.target).addClass('active');

            $('#ideal_banks').hide();

            if (e.target.className.indexOf('ideal') != -1) {
                $('#ideal_master').addClass('active');

                $('#ideal_banks').show();

                if (e.target.className.indexOf('child') != -1) {
                    $('#btn-pay').show();
                }
            }
        });
    });
}(jQuery);
