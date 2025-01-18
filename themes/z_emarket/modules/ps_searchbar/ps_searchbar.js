$(document).ready(function () {
    var $searchWidget = $('#search_widget');
    var $searchBox    = $searchWidget.find('input[type=text]');
    var searchURL     = $searchWidget.attr('data-search-controller-url');

    $.widget('prestashop.psBlockSearchAutocomplete', $.ui.autocomplete, {
        _renderItem: function (ul, product) {
            var cover = '', ref = '';
            if (product.cover && product.cover.small && product.cover.small.url) {
                cover = $('<span>').addClass('cover').html('<img src="'+product.cover.small.url+'" class="img-fluid">');
            }
            if (product.reference && product.reference != '') {
                ref = $('<span>').addClass('pref').html(' (Ref: ' + product.reference + ')');
            }

            return $('<li>').addClass('search-menu-item')
                .append($('<a>').addClass('search-item')
                    .append(cover)
                    .append($('<span>').addClass('info')
                        .append($('<span>').html(product.name).addClass('product'))
                        .append($('<span>').html(product.price).addClass('pprice'))
                        .append(ref)
                    )
                ).appendTo(ul)
            ;
        }
    });

    $searchBox.psBlockSearchAutocomplete({
        source: function (query, response) {
            $.post(searchURL, {
                s: query.term,
                resultsPerPage: 10
            }, null, 'json')
            .then(function (resp) {
                response(resp.products);
            })
            .fail(response);
        },
        select: function (event, ui) {
            var url = ui.item.url;
            window.location.href = url;
        },
    });
});
