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
    });
}(jQuery);
